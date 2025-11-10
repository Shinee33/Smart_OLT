<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';

    protected $fillable = [
        'olt_id',
        'board',
        'pon',
        'onu_id',
        'name',
        'onu_type',
        'serial_number',
        'status',
        'rx_power',
        'tx_power',
        'gpon_optical_distance',
        'health',
        'last_online',
        'last_offline',
        'uptime',
        'offline_reason',
    ];

    protected $casts = [
        'last_online' => 'datetime',
        'last_offline' => 'datetime',
        'board' => 'integer',
        'pon' => 'integer',
        'onu_id' => 'integer',
        'health' => 'integer',
    ];

    // Accessor untuk badge status
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'online' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Online</span>',
            'offline' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Offline</span>',
            'los' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">LOS</span>',
            'dyinggasp', 'dying' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Dying Gasp</span>',
            default => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Unknown</span>',
        };
    }

    // Format OLT Location
    public function getOltLocationAttribute()
    {
        if (!$this->olt_id) return '-';
        return "{$this->olt_id} ({$this->board}/{$this->pon}/{$this->onu_id})";
    }

    // Format RX/TX untuk display
    public function getRxTxDisplayAttribute()
    {
        $rx = $this->rx_power ?? '-';
        $tx = $this->tx_power ?? '-';
        return "RX: {$rx} dBm / TX: {$tx} dBm";
    }

    // Get health status color
    public function getHealthColorAttribute()
    {
        if ($this->health >= 1500) return 'text-green-600';
        if ($this->health >= 1000) return 'text-yellow-600';
        if ($this->health > 0) return 'text-orange-600';
        return 'text-red-600';
    }

    // Format uptime untuk display yang lebih baik
    public function getFormattedUptimeAttribute()
    {
        return $this->uptime ?? '-';
    }

    // Scope untuk filter status
    public function scopeOnline($query)
    {
        return $query->where('status', 'online');
    }

    public function scopeOffline($query)
    {
        return $query->whereIn('status', ['offline', 'los']);
    }

    public function scopeDyingGasp($query)
    {
        return $query->whereIn('status', ['dyinggasp', 'dying']);
    }
}