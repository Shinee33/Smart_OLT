<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id();
            
            // OLT Information
            $table->string('olt_id')->nullable();
            $table->integer('board')->nullable();
            $table->integer('pon')->nullable();
            $table->integer('onu_id')->nullable();
            
            // Customer Information
            $table->string('name');
            $table->string('onu_type')->nullable();
            $table->string('serial_number')->unique(); // SN
            
            // Status
            $table->enum('status', ['online', 'offline', 'los', 'dyinggasp', 'dying', 'unknown'])->default('offline');
            
            // Power & Signal
            $table->string('rx_power')->nullable(); // RX
            $table->string('tx_power')->nullable(); // TX
            $table->string('gpon_optical_distance')->nullable();
            
            // Health & Time Tracking
            $table->integer('health')->default(0);
            $table->timestamp('last_online')->nullable();
            $table->timestamp('last_offline')->nullable();
            $table->string('uptime')->nullable(); // Store as string karena format "0 days 20 hours..."
            $table->string('offline_reason')->nullable(); // PowerOff, LOSi, Unknown
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};