<x-app.app-layout>
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('pelanggan.index') }}" class="p-2 hover:bg-white/10 rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-white">Tambah Pelanggan</h1>
                <p class="text-gray-200 mt-1">Tambahkan pelanggan baru ke sistem</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white shadow-lg rounded-xl p-8 max-w-4xl">
        <form action="{{ route('pelanggan.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Pelanggan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent @error('name') border-red-500 @enderror">
                    @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Serial Number -->
                <div>
                    <label for="serial_number" class="block text-sm font-semibold text-gray-700 mb-2">
                        Serial Number <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent font-mono @error('serial_number') border-red-500 @enderror">
                    @error('serial_number')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent @error('status') border-red-500 @enderror">
                        <option value="">Pilih Status</option>
                        <option value="online" {{ old('status') === 'online' ? 'selected' : '' }}>Online</option>
                        <option value="offline" {{ old('status') === 'offline' ? 'selected' : '' }}>Offline</option>
                        <option value="los" {{ old('status') === 'los' ? 'selected' : '' }}>LOS</option>
                        <option value="dyinggasp" {{ old('status') === 'dyinggasp' ? 'selected' : '' }}>Dying Gasp</option>
                        <option value="dying" {{ old('status') === 'dying' ? 'selected' : '' }}>Dying</option>
                        <option value="unknown" {{ old('status') === 'unknown' ? 'selected' : '' }}>Unknown</option>
                    </select>
                    @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- OLT ID -->
                <div>
                    <label for="olt_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        OLT ID
                    </label>
                    <input type="text" name="olt_id" id="olt_id" value="{{ old('olt_id') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent @error('olt_id') border-red-500 @enderror">
                    @error('olt_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Board -->
                <div>
                    <label for="board" class="block text-sm font-semibold text-gray-700 mb-2">
                        Board
                    </label>
                    <input type="number" name="board" id="board" value="{{ old('board') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent @error('board') border-red-500 @enderror">
                    @error('board')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PON -->
                <div>
                    <label for="pon" class="block text-sm font-semibold text-gray-700 mb-2">
                        PON
                    </label>
                    <input type="number" name="pon" id="pon" value="{{ old('pon') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent @error('pon') border-red-500 @enderror">
                    @error('pon')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- ONU ID -->
                <div>
                    <label for="onu_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        ONU ID
                    </label>
                    <input type="number" name="onu_id" id="onu_id" value="{{ old('onu_id') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent @error('onu_id') border-red-500 @enderror">
                    @error('onu_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- ONU Type -->
                <div>
                    <label for="onu_type" class="block text-sm font-semibold text-gray-700 mb-2">
                        ONU Type
                    </label>
                    <input type="text" name="onu_type" id="onu_type" value="{{ old('onu_type') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent @error('onu_type') border-red-500 @enderror">
                    @error('onu_type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- RX Power -->
                <div>
                    <label for="rx_power" class="block text-sm font-semibold text-gray-700 mb-2">
                        RX Power (dBm)
                    </label>
                    <input type="number" step="0.01" name="rx_power" id="rx_power" value="{{ old('rx_power') }}" placeholder="e.g. -18.5"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent @error('rx_power') border-red-500 @enderror">
                    @error('rx_power')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- TX Power -->
                <div>
                    <label for="tx_power" class="block text-sm font-semibold text-gray-700 mb-2">
                        TX Power (dBm)
                    </label>
                    <input type="number" step="0.01" name="tx_power" id="tx_power" value="{{ old('tx_power') }}" placeholder="e.g. 2.5"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent @error('tx_power') border-red-500 @enderror">
                    @error('tx_power')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Optical Distance -->
                <div>
                    <label for="gpon_optical_distance" class="block text-sm font-semibold text-gray-700 mb-2">
                        Optical Distance (m)
                    </label>
                    <input type="number" name="gpon_optical_distance" id="gpon_optical_distance" value="{{ old('gpon_optical_distance') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent @error('gpon_optical_distance') border-red-500 @enderror">
                    @error('gpon_optical_distance')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- IP Address -->
                <div>
                    <label for="ip_address" class="block text-sm font-semibold text-gray-700 mb-2">
                        IP Address
                    </label>
                    <input type="text" name="ip_address" id="ip_address" value="{{ old('ip_address') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent @error('ip_address') border-red-500 @enderror">
                    @error('ip_address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Health -->
                <div>
                    <label for="health" class="block text-sm font-semibold text-gray-700 mb-2">
                        Health
                    </label>
                    <input type="text" name="health" id="health" value="{{ old('health') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent @error('health') border-red-500 @enderror">
                    @error('health')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Offline Reason -->
                <div class="md:col-span-2">
                    <label for="offline_reason" class="block text-sm font-semibold text-gray-700 mb-2">
                        Offline Reason
                    </label>
                    <textarea name="offline_reason" id="offline_reason" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent @error('offline_reason') border-red-500 @enderror">{{ old('offline_reason') }}</textarea>
                    @error('offline_reason')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-4 mt-8">
                <button type="submit" 
                        class="px-8 py-3 bg-violet-500 hover:bg-violet-600 text-white font-semibold rounded-lg shadow-lg transition-all duration-300">
                    Simpan Pelanggan
                </button>
                <a href="{{ route('pelanggan.index') }}" 
                   class="px-8 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-all duration-300">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app.app-layout