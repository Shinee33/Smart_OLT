<x-app.app-layout>
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white">Dashboard</h1>
                <p class="text-gray-200 mt-1">Monitor pelanggan Smart OLT</p>
            </div>
            <div class="flex items-center gap-3 flex-wrap">
                <!-- Date Filter -->
                <div class="bg-white rounded-lg px-4 py-2 shadow-md">
                    <form method="GET" class="flex items-center gap-2" id="dateFilterForm">
                        <label for="date_filter" class="text-sm font-semibold text-gray-700">Tanggal:</label>
                        <input 
                            type="date" 
                            id="date_filter" 
                            name="date" 
                            value="{{ request('date', date('Y-m-d')) }}"
                            max="{{ date('Y-m-d') }}"
                            class="text-sm border border-gray-300 rounded px-3 py-1 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            onchange="this.form.submit()"
                        >
                        <button 
                            type="submit" 
                            class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold px-4 py-1 rounded transition-all"
                        >
                            Filter
                        </button>
                        @if(request('date') && request('date') != date('Y-m-d'))
                        <button 
                            type="button"
                            onclick="window.location.href='{{ strtok(url()->current(), '?') }}'"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-semibold px-4 py-1 rounded transition-all"
                        >
                            Reset
                        </button>
                        @endif
                    </form>
                </div>

                <!-- Live Status Indicator -->
                @if(!request('date') || request('date') == date('Y-m-d'))
                <div class="flex items-center gap-2 bg-white bg-opacity-20 rounded-lg px-4 py-2">
                    <div class="animate-pulse">
                        <div class="h-4 w-4 bg-green-400 rounded-full"></div>
                    </div>
                    <span class="text-white text-sm font-semibold">Live Monitoring</span>
                </div>
                @else
                <div class="flex items-center gap-2 bg-white bg-opacity-20 rounded-lg px-4 py-2">
                    <div class="h-4 w-4 bg-amber-400 rounded-full"></div>
                    <span class="text-white text-sm font-semibold">Mode Historis</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Info Mode -->

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        @if(!request('date') || request('date') == date('Y-m-d'))
        @else

        @endif

        <!-- Total Pelanggan Card -->
        <div class="bg-[#3B82F6] text-white shadow-lg rounded-xl p-6 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm uppercase font-semibold tracking-wide">Total Pelanggan</p>
                <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold mb-1" id="totalData">{{ $totalData ?? 0 }}</p>
            <p class="text-sm opacity-90">Pelanggan Terdaftar</p>
        </div>

        <!-- Online Card -->
        <div class="bg-[#10B981] text-white shadow-lg rounded-xl p-6 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm uppercase font-semibold tracking-wide">Online</p>
                <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold mb-1" id="online">{{ $online ?? 0 }}</p>
            <p class="text-sm opacity-90">Pelanggan Aktif</p>
        </div>

        <!-- Dying Gasp Card -->
        <div class="bg-[#F59E0B] text-white shadow-lg rounded-xl p-6 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm uppercase font-semibold tracking-wide">Dying Gasp</p>
                <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold mb-1" id="dyinggasp">{{ $dyinggasp ?? 0 }}</p>
            <p class="text-sm opacity-90">Sinyal Lemah</p>
        </div>

        <!-- Offline Card -->
        <div class="bg-[#EF4444] text-white shadow-lg rounded-xl p-6 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm uppercase font-semibold tracking-wide">Offline / LOS</p>
                <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold mb-1" id="offline">{{ $offline ?? 0 }}</p>
            <p class="text-sm opacity-90">Tidak Aktif</p>
        </div>
    </div>

    <!-- Grafik Statistik -->
    <div class="bg-white shadow-lg rounded-xl p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    @if(!request('date') || request('date') == date('Y-m-d'))
                        Statistik Real-Time (Per 3 Menit)
                    @else
                        Statistik Historis (Per Jam)
                    @endif
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    @if(!request('date') || request('date') == date('Y-m-d'))
                        Monitoring perubahan status pelanggan dalam 1 jam terakhir
                    @else
                        Monitoring perubahan status pelanggan selama 24 jam pada {{ \Carbon\Carbon::parse(request('date'))->isoFormat('DD MMMM YYYY') }}
                    @endif
                </p>
                <p class="text-xs text-gray-500 mt-1">
                    <span class="font-semibold">Rentang waktu:</span> 
                    <span id="timeRangeFrom">{{ $timeRangeStart ?? '' }}</span> - <span id="timeRangeTo">{{ $timeRangeEnd ?? '' }}</span>
                </p>
            </div>
            @if(!request('date') || request('date') == date('Y-m-d'))
            <div class="flex items-center gap-3">
                <div class="text-sm">
                    <div class="flex items-center gap-2 mb-1">
                        <div class="h-2 w-2 bg-teal-500 rounded-full animate-pulse"></div>
                        <span class="text-gray-600">Update setiap 3 menit</span>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="h-80">
            <canvas id="statsChart"></canvas>
        </div>

        <!-- Info box -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-teal-50 rounded-lg p-4 border border-teal-200">
                <div class="flex items-center gap-2">
                    <div class="h-3 w-3 bg-teal-500 rounded-full"></div>
                    <span class="font-semibold text-teal-700">Online</span>
                </div>
                <p class="text-xs text-teal-600 mt-1">Pelanggan dengan status aktif</p>
            </div>
            <div class="bg-amber-50 rounded-lg p-4 border border-amber-200">
                <div class="flex items-center gap-2">
                    <div class="h-3 w-3 bg-amber-500 rounded-full"></div>
                    <span class="font-semibold text-amber-700">Dying Gasp</span>
                </div>
                <p class="text-xs text-amber-600 mt-1">Perangkat dengan sinyal lemah</p>
            </div>
            <div class="bg-rose-50 rounded-lg p-4 border border-rose-200">
                <div class="flex items-center gap-2">
                    <div class="h-3 w-3 bg-rose-500 rounded-full"></div>
                    <span class="font-semibold text-rose-700">LOS / Offline</span>
                </div>
                <p class="text-xs text-rose-600 mt-1">Kehilangan sinyal atau mati</p>
            </div>
        </div>
    </div>

    {{-- Inject data dari Laravel ke JavaScript --}}
    <script>
        window.chartStats = {
            online: @json($onlineStats ?? []),
            dyinggasp: @json($dyinggaspStats ?? []),
            los: @json($losStats ?? []),
        };
        window.dashboardMode = '{{ request("date") && request("date") != date("Y-m-d") ? "historical" : "realtime" }}';
        window.selectedDate = '{{ request("date", date("Y-m-d")) }}';
    </script>

    {{-- Load dashboard.js --}}
    @vite('resources/js/components/dashboard.js')
</x-app.app-layout>