<?php

namespace App\Http\Controllers;

use App\Models\Olt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class OltController extends Controller
{
    public function index(Request $request)
    {
        $query = Olt::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $olts = $query->latest()->paginate(15);
        return view('olt.index', compact('olts'));
    }

    public function create()
    {
        return view('olt.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
        'name' => 'required|string|max:255',
        'ip_address' => 'required|string|max:50',
        'snmp_community' => 'required|string|max:255',
        'snmp_port' => 'required|integer',
        'telnet_port' => 'required|integer',
        'type' => 'required|string|max:50',
        'hardware_version' => 'nullable|string|max:100',
        'software_version' => 'nullable|string|max:50',
        'pon_type' => 'required|string',
        'snmp_rw_community' => 'nullable|string|max:255',
        'iptv_enabled' => 'nullable|boolean',
    ]);

    try {
        DB::beginTransaction();

        // ✅ Set default nilai tambahan
        $validated['iptv_enabled'] = $request->has('iptv_enabled') ? 1 : 0;
        $validated['status'] = 'active'; // default aktif
        $validated['table_name'] = $this->generateTableName($validated['name']);

        // ✅ Simpan data OLT
        $olt = Olt::create($validated);

        // ✅ Buat tabel pelanggan untuk OLT ini
        $this->createOltTable($validated['table_name']);

        DB::commit();

        return redirect()
            ->route('olt.index')
            ->with('success', "OLT '{$olt->name}' berhasil ditambahkan dan tabel '{$validated['table_name']}' telah dibuat!");
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withInput()
            ->with('error', 'Gagal menambahkan OLT: ' . $e->getMessage());
    }
    }

    public function edit(Olt $olt)
    {
        return view('olt.edit', compact('olt'));
    }

    public function update(Request $request, Olt $olt)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('olts')->ignore($olt->id)],
            'ip_address' => 'required|ip',
            'snmp_community' => 'required|string|max:255',
            'snmp_port' => 'required|integer|min:1|max:65535',
            'telnet_username' => 'nullable|string|max:255',
            'telnet_password' => 'nullable|string|max:255',
            'telnet_port' => 'required|integer|min:1|max:65535',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
        ]);

        $olt->update($validated);
        return redirect()->route('olt.index')
            ->with('success', "OLT '{$olt->name}' berhasil diperbarui!");
    }

    public function destroy(Olt $olt)
    {
        try {
            DB::beginTransaction();
            
            $oltName = $olt->name;
            $tableName = $olt->table_name;
            
            // Hapus tabel pelanggan
            $this->dropOltTable($tableName);
            
            // Hapus data OLT
            $olt->delete();
            
            DB::commit();

            return redirect()->route('olt.index')
                ->with('success', "OLT '{$oltName}' dan tabel '{$tableName}' berhasil dihapus!");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menghapus OLT: ' . $e->getMessage());
        }
    }

    /**
     * Generate nama tabel dari nama OLT
     */
    private function generateTableName($name)
    {
        // Bersihkan nama: lowercase, replace spasi/simbol dengan underscore
        $cleanName = strtolower($name);
        $cleanName = preg_replace('/[^a-z0-9]+/', '_', $cleanName);
        $cleanName = trim($cleanName, '_');
        
        // Tambah prefix olt_ dan suffix _pelanggan
        $tableName = 'olt_' . $cleanName . '_pelanggan';
        
        // Potong jika terlalu panjang (max 64 karakter untuk MySQL)
        if (strlen($tableName) > 64) {
            $tableName = substr($tableName, 0, 64);
        }
        
        return $tableName;
    }

    /**
     * Buat tabel pelanggan untuk OLT
     */
    private function createOltTable($tableName)
    {
        // Cek apakah tabel sudah ada
        if (Schema::hasTable($tableName)) {
            throw new \Exception("Tabel {$tableName} sudah ada!");
        }

        Schema::create($tableName, function ($table) {
            $table->id();
            $table->string('olt_id')->nullable();
            $table->string('board')->nullable();
            $table->string('pon')->nullable();
            $table->string('onu_id')->nullable();
            $table->string('name');
            $table->string('onu_type')->nullable();
            $table->string('serial_number')->unique();
            $table->enum('status', ['online', 'offline', 'los', 'dyinggasp'])->default('offline');
            $table->string('rx_power')->nullable();
            $table->string('tx_power')->nullable();
            $table->string('gpon_optical_distance')->nullable();
            $table->integer('health')->default(0);
            $table->timestamp('last_online')->nullable();
            $table->timestamp('last_offline')->nullable();
            $table->string('uptime')->nullable();
            $table->string('offline_reason')->nullable();
            $table->timestamp('timestamp')->nullable();
            $table->timestamps();

            $table->index(['status', 'serial_number']);
            $table->index('olt_id');
        });
    }

    /**
     * Hapus tabel pelanggan OLT
     */
    private function dropOltTable($tableName)
    {
        if (Schema::hasTable($tableName)) {
            Schema::dropIfExists($tableName);
        }
    }
}