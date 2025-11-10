<x-app.app-layout>
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-white">Daftar OLT</h1>
                <p class="text-gray-200 mt-1">Kelola perangkat OLT dan monitoring jaringan</p>
            </div>
            <a href="{{ route('olt.create') }}" 
               class="px-6 py-3 bg-violet-500 hover:bg-violet-600 text-white font-semibold rounded-lg transition-all shadow-lg">
                + Tambah OLT
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif

    <!-- Filter & Search -->
    <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
        <form method="GET" action="{{ route('olt.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[250px]">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari nama, IP, Type, atau hardware..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent">
            </div>
            <div>
                <select name="type" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500">
                    <option value="">Semua Router Modem</option>
                    <option value="ZTE" {{ request('type') === 'ZTE' ? 'selected' : '' }}>ZTE</option>
                    <option value="Huawei" {{ request('type') === 'Huawei' ? 'selected' : '' }}>Huawei</option>
                    <option value="Fiberhome" {{ request('type') === 'Fiberhome' ? 'selected' : '' }}>Fiberhome</option>
                </select>
            </div>
            <div>
                <select name="pon_type" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500">
                    <option value="">Semua PON Type</option>
                    <option value="GPON" {{ request('pon_type') === 'GPON' ? 'selected' : '' }}>GPON</option>
                    <option value="EPON" {{ request('pon_type') === 'EPON' ? 'selected' : '' }}>EPON</option>
                    <option value="GPON+EPON" {{ request('pon_type') === 'GPON+EPON' ? 'selected' : '' }}>GPON+EPON</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2 bg-violet-500 hover:bg-violet-600 text-white font-semibold rounded-lg transition-all">
                    Filter
                </button>
                <a href="{{ route('olt.index') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-all">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Tabel OLT -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Nama OLT</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">IP Address</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Hardware</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Software</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">PON Type</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">SNMP</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Telnet</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">IPTV</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($olts as $olt)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3">
                            <div class="font-semibold text-gray-900">{{ $olt->name }}</div>
                        </td>
                        <td class="px-4 py-3 font-mono text-sm text-gray-700">{{ $olt->ip_address }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $olt->type ?? 'ZTE' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-700">
                            {{ $olt->hardware_version ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-600">
                            {{ $olt->software_version ?? '-' }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                @if(($olt->pon_type ?? 'GPON') === 'GPON') bg-green-100 text-green-800
                                @elseif($olt->pon_type === 'EPON') bg-purple-100 text-purple-800
                                @else bg-indigo-100 text-indigo-800
                                @endif">
                                {{ $olt->pon_type ?? 'GPON' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-600">
                            <div class="font-mono">{{ $olt->snmp_community }}:{{ $olt->snmp_port }}</div>
                            @if($olt->snmp_rw_community)
                            <div class="font-mono text-gray-500">RW: {{ $olt->snmp_rw_community }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-600">
                            <div class="font-mono">Port: {{ $olt->telnet_port ?? 23 }}</div>
                            @if($olt->telnet_username)
                            <div class="text-gray-500">User: {{ $olt->telnet_username }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($olt->iptv_enabled ?? false)
                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-green-100">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-green-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                            @else
                            <span class="text-gray-300">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('olt.edit', $olt) }}" 
                                   class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                                <button type="button" 
                                        onclick="testConnection('{{ $olt->ip_address }}', '{{ $olt->snmp_port }}', '{{ $olt->telnet_port }}')"
                                        class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" 
                                        title="Test Connection">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.347a1.125 1.125 0 0 1 0 1.972l-11.54 6.347a1.125 1.125 0 0 1-1.667-.986V5.653Z" />
                                    </svg>
                                </button>
                                <form action="{{ route('olt.destroy', $olt) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('PERHATIAN!\n\nMenghapus OLT akan menghapus semua data terkait.\n\nYakin ingin melanjutkan?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-6 py-12 text-center text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto mb-4 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 0 1-3-3m3 3a3 3 0 1 0 0 6h13.5a3 3 0 1 0 0-6m-16.5-3a3 3 0 0 1 3-3h13.5a3 3 0 0 1 3 3m-19.5 0a4.5 4.5 0 0 1 .9-2.7L5.737 5.1a3.375 3.375 0 0 1 2.7-1.35h7.126c1.062 0 2.062.5 2.7 1.35l2.587 3.45a4.5 4.5 0 0 1 .9 2.7m0 0a3 3 0 0 1-3 3m0 3h.008v.008h-.008v-.008Zm0-6h.008v.008h-.008v-.008Zm-3 6h.008v.008h-.008v-.008Zm0-6h.008v.008h-.008v-.008Z" />
                            </svg>
                            <p class="text-lg font-semibold">Belum ada OLT</p>
                            <p class="mt-2">Tambahkan OLT pertama Anda</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($olts->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $olts->links() }}
        </div>
        @endif
    </div>

    <script>
        function testConnection(ip, snmpPort, telnetPort) {
            alert(`Testing connection to OLT:\n\nIP: ${ip}\nSNMP Port: ${snmpPort}\nTelnet Port: ${telnetPort}\n\nFeature will be implemented soon...`);
        }
    </script>
</x-app.app-layout>