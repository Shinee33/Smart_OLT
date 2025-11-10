<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('olts', function (Blueprint $table) {
            // Tambah kolom type (ZTE, Huawei, Fiberhome)
            $table->string('type', 50)->default('ZTE')->after('name');
            
            // Tambah kolom hardware_version
            $table->string('hardware_version', 100)->nullable()->after('type');
            
            // Tambah kolom software_version
            $table->string('software_version', 50)->nullable()->after('hardware_version');
            
            // Tambah kolom pon_type
            $table->enum('pon_type', ['GPON', 'EPON', 'GPON+EPON'])->default('GPON')->after('software_version');
            
            // Tambah kolom snmp_rw_community (Read-Write)
            $table->string('snmp_rw_community', 255)->nullable()->after('snmp_community');
            
            // Tambah kolom iptv_enabled
            $table->boolean('iptv_enabled')->default(false)->after('telnet_port');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('olts', function (Blueprint $table) {
            $table->dropColumn([
                'type',
                'hardware_version',
                'software_version',
                'pon_type',
                'snmp_rw_community',
                'iptv_enabled'
            ]);
        });
    }
};