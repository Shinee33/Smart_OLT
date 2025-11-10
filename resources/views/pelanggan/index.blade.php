<x-app.app-layout>
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-white">Daftar Pelanggan</h1>
                <p class="text-gray-200 mt-1">Kelola data pelanggan Smart OLT</p>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif
    <!-- Filter & Search -->
    <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
        <form method="GET" action="{{ route('pelanggan.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[250px]">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari nama, SN, atau OLT..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent">
            </div>
            <div>
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="online" {{ request('status') === 'online' ? 'selected' : '' }}>Online</option>
                    <option value="offline" {{ request('status') === 'offline' ? 'selected' : '' }}>Offline</option>
                    <option value="los" {{ request('status') === 'los' ? 'selected' : '' }}>LOS</option>
                    <option value="dyinggasp" {{ request('status') === 'dyinggasp' ? 'selected' : '' }}>Dying Gasp</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2 bg-violet-500 hover:bg-violet-600 text-white font-semibold rounded-lg transition-all">
                    Filter
                </button>
                <a href="{{ route('pelanggan.index') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-all">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Tabel Pelanggan -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">OLT</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Board</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">PON</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">ONU ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">ONU Type</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Serial Number</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">RX Power</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">TX Power</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Distance</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Health</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Last Online</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Last Offline</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Uptime</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Offline Reason</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Timestamp</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($pelanggan as $p)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 text-gray-900">{{ $p->olt_id ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $p->board ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $p->pon ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $p->onu_id ?? '-' }}</td>
                        <td class="px-4 py-3 font-semibold text-gray-900">{{ $p->name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $p->onu_type ?? 'Unknown' }}</td>
                        <td class="px-4 py-3 font-mono text-xs text-gray-700">{{ $p->serial_number }}</td>
                        <td class="px-4 py-3">{!! $p->status_badge !!}</td>
                        <td class="px-4 py-3">
                            <span class="font-medium {{ $p->rx_power && floatval($p->rx_power) < 0 ? 'text-blue-600' : 'text-red-600' }}">
                                {{ $p->rx_power ?? '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $p->tx_power ?? 'None' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $p->gpon_optical_distance ?? 'None' }}</td>
                        <td class="px-4 py-3">
                            <span class="font-semibold {{ $p->health_color ?? 'text-gray-600' }}">
                                {{ $p->health ?? '0' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-600">
                            {{ $p->last_online ?? 'None' }}
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-600">
                            {{ $p->last_offline ?? 'None' }}
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-700">
                            {{ $p->uptime ?? 'None' }}
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-600">
                            {{ $p->offline_reason ?? 'Unknown' }}
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-600">
                            {{ $p->timestamp ?? '-' }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('pelanggan.edit', $p) }}" 
                                   class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                                <form action="{{ route('pelanggan.destroy', $p) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
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
                        <td colspan="18" class="px-6 py-12 text-center text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto mb-4 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                            </svg>
                            <p class="text-lg font-semibold">Belum ada data pelanggan</p>
                            <p class="mt-2">Data pelanggan akan muncul di sini</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($pelanggan->hasPages())
        <div class="px-6 py-4 border-t border-white">
            {{ $pelanggan->links() }}
        </div>
        @endif
    </div>
</x-app.app-layout>