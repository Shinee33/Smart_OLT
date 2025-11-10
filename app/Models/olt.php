<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Olt extends Model
{
    protected $fillable = [
        'name',
        'type',
        'hardware_version',
        'software_version',
        'pon_type',
        'ip_address',
        'snmp_community',
        'snmp_rw_community',
        'snmp_port',
        'telnet_username',
        'telnet_password',
        'telnet_port',
        'iptv_enabled',
        'location',
        'status',
        'description',
        'table_name', // ✅ penting, biar bisa disimpan dari store()
    ];

    protected $casts = [
        'snmp_port' => 'integer',
        'telnet_port' => 'integer',
        'iptv_enabled' => 'boolean', // ✅ tambahkan untuk cast checkbox
    ];

    public function getStatusBadgeAttribute()
    {
        return $this->status === 'active' 
            ? '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>'
            : '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Nonaktif</span>';
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }
}
