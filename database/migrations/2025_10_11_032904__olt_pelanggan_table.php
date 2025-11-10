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
        Schema::create('olts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('ip_address');
            $table->string('snmp_community');
            $table->integer('snmp_port')->default(161);
            $table->string('telnet_username')->nullable();
            $table->string('telnet_password')->nullable();
            $table->integer('telnet_port')->default(23);
            $table->string('location')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->text('description')->nullable();
            $table->string('table_name')->unique(); // Ganti dari database_name
            $table->timestamps();

            $table->index('status');
            $table->index('table_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('olts');
    }
};