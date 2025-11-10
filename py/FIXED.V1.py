from concurrent.futures import ThreadPoolExecutor, as_completed
from typing import *
from pysnmp.hlapi import *
import config
import time
from datetime import datetime
from sqlalchemy import create_engine, select, text
from sqlalchemy.orm import DeclarativeBase, Mapped, mapped_column, Session
from sqlalchemy import Integer, String

# =====================================================
# 🗄️ DATABASE CONFIG
# =====================================================
DB_URI = (
    f"mysql+pymysql://{config.db_user_mysql}:{config.db_pass_mysql}"
    f"@{config.db_host_mysql}:{config.db_port_mysql}/{config.db_name_mysql}"
)
engine = create_engine(DB_URI, pool_pre_ping=True,
                       pool_recycle=1800, echo=False)


class Base(DeclarativeBase):
    pass


class OLT(Base):
    __tablename__ = "olts"

    id: Mapped[int] = mapped_column(
        Integer, primary_key=True, autoincrement=True)
    name: Mapped[str] = mapped_column(String(128), nullable=False)
    type_: Mapped[str] = mapped_column("type", String(32), nullable=True)
    hardware_version: Mapped[str] = mapped_column(String(64), nullable=True)
    software_version: Mapped[str] = mapped_column(String(64), nullable=True)
    ip_address: Mapped[str] = mapped_column(String(64), nullable=False)
    snmp_community: Mapped[str] = mapped_column(String(64), nullable=True)
    snmp_port: Mapped[int] = mapped_column(
        Integer, nullable=False, default=161)
    table_name: Mapped[str] = mapped_column(String(64), nullable=True)
    status: Mapped[str] = mapped_column(
        String(16), nullable=False, default="active")


# =====================================================
# ⚙️ SNMP UTILITIES
# =====================================================
def snmp_walk_next(host: str, community: str, base_oid: str,
                   port: int = 161, timeout: int = 3, retries: int = 1,
                   max_results: Optional[int] = None):
    """SNMP walk menggunakan nextCmd — return list[(oid, value)]"""
    results = []
    for (errInd, errStat, errIdx, varBinds) in nextCmd(
        SnmpEngine(),
        CommunityData(community, mpModel=1),  # SNMP v2c
        UdpTransportTarget((host, port), timeout=timeout, retries=retries),
        ContextData(),
        ObjectType(ObjectIdentity(base_oid)),
        lexicographicMode=False
    ):
        if errInd:
            raise RuntimeError(f"SNMP error: {errInd}")
        if errStat:
            raise RuntimeError(f"SNMP error: {errStat.prettyPrint()}")
        for oid, val in varBinds:
            results.append((str(oid), val.prettyPrint()))
            if max_results and len(results) >= max_results:
                return results
    return results


# =====================================================
# 💾 SIMPAN KE TABLE ONU_STATUS
# =====================================================
def insert_snmp_to_onu_status(olt: OLT, results: Dict[str, List[Tuple[str, str]]]):
    """
    Simpan hasil SNMP langsung ke tabel `onu_status`
    (struktur sesuai Laravel Smart OLT)
    """
    print(f"🗄️  Menyimpan hasil ke tabel: onu_status")

    with engine.connect() as conn:
        onus = {}

        def parse_index(oid: str):
            parts = oid.split(".")
            try:
                return ".".join(parts[-3:])
            except:
                return parts[-1]

        # kumpulkan hasil per ONU
        for key, data in results.items():
            for oid, val in data:
                idx = parse_index(oid)
                if idx not in onus:
                    onus[idx] = {}
                onus[idx][key] = val

        now = datetime.now().strftime("%Y-%m-%d %H:%M:%S")

        for idx, onu in onus.items():
            # parse board, pon, onu_id
            parts = idx.split(".")
            board = int(parts[0]) if len(
                parts) > 0 and parts[0].isdigit() else 0
            pon = int(parts[1]) if len(parts) > 1 and parts[1].isdigit() else 0
            onu_id = int(parts[2]) if len(
                parts) > 2 and parts[2].isdigit() else 0

            name = onu.get("name", "")
            desc = onu.get("desc", "")
            sn = onu.get("sn", "")
            state = onu.get("state", "")
            rx = onu.get("rx", "")
            tx = onu.get("tx", "")

            # konversi numeric aman
            def safe_float(v):
                try:
                    return float(v)
                except:
                    return 0

            rx_val = safe_float(rx)
            tx_val = safe_float(tx)
            gpon_distance = 0  # default 0 jika tidak ada data dari SNMP
            health = ""        # default kosong

            insert_sql = text("""
                INSERT INTO onu_status
                (olt_id, board, pon, onu_id, name, description, onu_type, serial_number,
                 status, ip_address, last_online, last_offline, uptime,
                 last_down_time_duration, offline_reason, gpon_optical_distance,
                 rx_power, tx_power, health, timestamp)
                VALUES (:olt_id, :board, :pon, :onu_id, :name, :desc, '', :sn, :state, '',
                        NULL, NULL, NULL, NULL, '', :gpon_distance, :rx, :tx, :health, :ts)
                ON DUPLICATE KEY UPDATE
                    name = VALUES(name),
                    description = VALUES(description),
                    serial_number = VALUES(serial_number),
                    status = VALUES(status),
                    gpon_optical_distance = VALUES(gpon_optical_distance),
                    rx_power = VALUES(rx_power),
                    tx_power = VALUES(tx_power),
                    health = VALUES(health),
                    timestamp = VALUES(timestamp)
            """)

            conn.execute(insert_sql, {
                "olt_id": olt.id,
                "board": board,
                "pon": pon,
                "onu_id": onu_id,
                "name": name,
                "desc": desc,
                "sn": sn,
                "state": state,
                "gpon_distance": gpon_distance,
                "rx": rx_val,
                "tx": tx_val,
                "health": health,
                "ts": now
            })

        conn.commit()
        print(f"✅ {len(onus)} data ONU disimpan ke tabel onu_status")


# =====================================================
# 🔁 POLLING OLT
# =====================================================
def poll_one_olt(olt: OLT):
    if olt.status != "active":
        print(f"[SKIP] OLT {olt.name} tidak aktif.")
        return

    vhardware = (olt.hardware_version or "C320").strip().upper()
    vsoftware = (olt.software_version or "V1").strip().upper()
    prof = config.PROFILE_DATA_SNMP[vhardware][vsoftware]

    print(
        f"\n🔹 Polling OLT: {olt.name} ({olt.ip_address}) - {vhardware}/{vsoftware}")

    OIDS = {
        "name":  prof["NAME"],
        "desc":  prof["DESC"],
        "sn":    prof["SN"],
        "state": prof["STATUS"],
        "rx":    prof["RX"],
        "tx":    prof["TX"],
    }

    results: Dict[str, List[Tuple[str, str]]] = {}
    with ThreadPoolExecutor(max_workers=len(OIDS)) as ex:
        futures = {}
        for key, base_oid in OIDS.items():
            fut = ex.submit(
                snmp_walk_next,
                olt.ip_address,
                olt.snmp_community,
                base_oid,
                olt.snmp_port,
            )
            futures[fut] = key

        for fut in as_completed(futures):
            key = futures[fut]
            try:
                results[key] = fut.result()
            except Exception as e:
                results[key] = []
                print(f"[ERR] {olt.ip_address} - {key}: {e}")

    # tampilkan hasil singkat
    for key, data in results.items():
        print(f"[{key}] {len(data)} entri")
        if data:
            print("  contoh:", data[:3])

    # simpan ke database Laravel
    insert_snmp_to_onu_status(olt, results)


def _poll_one_olt_catch(olt: OLT):
    try:
        poll_one_olt(olt)
        return (olt.name, olt.table_name, None)
    except Exception as e:
        return (olt.name, olt.table_name, e)


# =====================================================
# 🧠 MAIN LOOP
# =====================================================
def pool_all_data():
    with Session(engine) as s:
        olts = s.execute(select(OLT)).scalars().all()

    if not olts:
        print("[INFO] Tidak ada OLT di database.")
        return

    for olt in olts:
        name, table_name, err = _poll_one_olt_catch(olt)
        if err:
            print(f"[ERR] {name}: {err}")


if __name__ == "__main__":
    print("🚀 Smart OLT SNMP Collector (Laravel Sync Mode)")
    pool_all_data()
    time.sleep(2)
