# database mysql
# db_host_mysql = "103.66.62.74"
# db_port_mysql = 3306                # pakai int
# db_name_mysql = "smart_olt"
# db_user_mysql = "smart_olt"
# db_pass_mysql = "Pm7KEjFNhXcT3Y8Z"


db_host_mysql = "123.253.54.3"
db_port_mysql = 3306                # pakai int
db_name_mysql = "smart"
db_user_mysql = "smart"
db_pass_mysql = "hHbE322wkb36KZpB"

PROFILE_DATA_SNMP = {
    "C300": {
        "2.1.X": { # VERSION
            "NAME":   "1.3.6.1.4.1.3902.1012.3.28.1.1.2",
            "DESC":   "1.3.6.1.4.1.3902.1012.3.28.1.1.3",
            "SN":     "1.3.6.1.4.1.3902.1012.3.28.1.1.5",
            "STATUS": "1.3.6.1.4.1.3902.1012.3.28.2.1.4",
            "RX":     "1.3.6.1.4.1.3902.1012.3.50.12.1.1.10",
            "TX":     "1.3.6.1.4.1.3902.1012.3.50.12.1.1.14",
            "SNCV": True,   # SN C300 = 4 ASCII + 4 byte HEX
            "STATUS_ONU": {
                0: "Logging",
                1: "LOS",
                2: "Synchronization",
                3: "Online",
                4: "Dying Gasp",
                5: "Auth Failed",
                6: "Offline",
                # nilai lain tampilkan sebagai "Code <n>" di layer pemanggil
            }
        }
    },
    "C320": {
        "2.1.X": {
            "NAME":   "1.3.6.1.4.1.3902.1082.500.10.2.3.3.1.2",
            "DESC":   "1.3.6.1.4.1.3902.1082.500.10.2.3.3.1.3",
            "SN":     "1.3.6.1.4.1.3902.1082.500.10.2.3.3.1.18",
            "STATUS": "1.3.6.1.4.1.3902.1082.500.10.2.3.8.1.4",
            "RX":     "1.3.6.1.4.1.3902.1082.500.20.2.2.2.1.10",
            "TX":     "1.3.6.1.4.1.3902.1082.500.20.2.2.2.1.14",  # sesuai setupmu 
            "snNeedsConvert": False,  # C320 biasanya sudah ASCII murni
            "STATUS_ONU": {
                1: "Logging",
                2: "LOS",
                3: "Synchronization",
                4: "Online",
                5: "Dying Gasp",
                6: "Auth Failed",
                7: "Offline",
                # sama: nilai lain → "Code <n>" di layer pemanggil
            }
        }
    }
}






# PROFILE_DATA_SNMP = {
#     "C300": {
#         "2.1": { # VERSION
#             "NAME":   "1.3.6.1.4.1.3902.1012.3.28.1.1.2",
#             "DESC":   "1.3.6.1.4.1.3902.1012.3.28.1.1.3",
#             "SN":     "1.3.6.1.4.1.3902.1012.3.28.1.1.5",
#             "STATUS": "1.3.6.1.4.1.3902.1012.3.28.2.1.4",
#             "RX":     "1.3.6.1.4.1.3902.1012.3.50.12.1.1.10",
#             "TX":     "1.3.6.1.4.1.3902.1012.3.50.12.1.1.14",
#             "SNCV": True,   # SN C300 = 4 ASCII + 4 byte HEX
#             "STATUS_ONU": {
#                 0: "Logging",
#                 1: "LOS",
#                 2: "Synchronization",
#                 3: "Online",
#                 4: "Dying Gasp",
#                 5: "Auth Failed",
#                 6: "Offline",
#                 # nilai lain tampilkan sebagai "Code <n>" di layer pemanggil
#             }
#         }
#     },
#     "C320": {
#         "NAME":   "1.3.6.1.4.1.3902.1082.500.10.2.3.3.1.2",
#         "DESC":   "1.3.6.1.4.1.3902.1082.500.10.2.3.3.1.3",
#         "SN":     "1.3.6.1.4.1.3902.1082.500.10.2.3.3.1.18",
#         "STATUS": "1.3.6.1.4.1.3902.1082.500.10.2.3.8.1.4",
#         "RX":     "1.3.6.1.4.1.3902.1082.500.20.2.2.2.1.10",
#         "TX":     "1.3.6.1.4.1.3902.1082.500.20.2.2.2.1.14",  # sesuai setupmu 
#         "snNeedsConvert": False,  # C320 biasanya sudah ASCII murni
#         "STATUS_ONU": {
#             1: "Logging",
#             2: "LOS",
#             3: "Synchronization",
#             4: "Online",
#             5: "Dying Gasp",
#             6: "Auth Failed",
#             7: "Offline",
#             # sama: nilai lain → "Code <n>" di layer pemanggil
#         }
#     }
# }