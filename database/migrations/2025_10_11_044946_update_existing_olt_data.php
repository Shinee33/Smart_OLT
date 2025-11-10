<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ambil semua data OLT yang sudah ada
        $olts = DB::table('olts')->get();

        foreach ($olts as $olt) {
            // Jika masih menggunakan format database_name (olt_xxxxx)
            // Ubah menjadi format table_name (olt_xxxxx_pelanggan)
            
            $oldDatabaseName = $olt->table_name; // setelah rename kolom
            
            // Jika belum ada suffix _pelanggan, tambahkan
            if (!str_ends_with($oldDatabaseName, '_pelanggan')) {
                $newTableName = $oldDatabaseName . '_pelanggan';
                
                DB::table('olts')
                    ->where('id', $olt->id)
                    ->update(['table_name' => $newTableName]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke format lama jika diperlukan
        $olts = DB::table('olts')->get();

        foreach ($olts as $olt) {
            $tableName = $olt->table_name;
            
            // Hapus suffix _pelanggan
            if (str_ends_with($tableName, '_pelanggan')) {
                $oldFormat = str_replace('_pelanggan', '', $tableName);
                
                DB::table('olts')
                    ->where('id', $olt->id)
                    ->update(['table_name' => $oldFormat]);
            }
        }
    }
};