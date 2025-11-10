<x-app.app-layout>
    <div class="mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('olt.index') }}" class="text-white hover:text-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-white">Edit OLT</h1>
                <p class="text-gray-200 mt-1">Perbarui informasi OLT {{ $olt->name }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-xl p-8 max-w-4xl">
        <form action="{{ route('olt.update', $olt) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama OLT -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama OLT *</label>
                    <input type="text" name="name" value="{{ old('name', $olt->name) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 @error('name') border-red-500 @enderror">
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- IP Address -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">IP Address *</label>
                    <input type="text" name="ip_address" value="{{ old('ip_address', $olt->ip_address) }}" required
                           placeholder="192.168.1.1"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 @error('ip_address') border-red-500 @enderror">
                    @error('ip_address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SNMP Community -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">SNMP Community *</label>
                    <input type="text" name="snmp_community" value="{{ old('snmp_community', $olt->snmp_community) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 @error('snmp_community') border-red-500 @enderror">
                    @error('snmp_community')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SNMP Port -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">SNMP Port *</label>
                    <input type="number" name="snmp_port" value="{{ old('snmp_port', $olt->snmp_port) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 @error('snmp_port') border-red-500 @enderror">
                    @error('snmp_port')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telnet Username -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Telnet Username</label>
                    <input type="text" name="telnet_username" value="{{ old('telnet_username', $olt->telnet_username) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 @error('telnet_username') border-red-500 @enderror">
                    @error('telnet_username')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telnet Password -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Telnet Password</label>
                    <input type="password" name="telnet_password" value="{{ old('telnet_password', $olt->telnet_password) }}"
                           placeholder="Kosongkan jika tidak ingin mengubah"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 @error('telnet_password') border-red-500 @enderror">
                    @error('telnet_password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telnet Port -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Telnet Port *</label>
                    <input type="number" name="telnet_port" value="{{ old('telnet_port', $olt->telnet_port) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 @error('telnet_port') border-red-500 @enderror">
                    @error('telnet_port')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status *</label>
                    <select name="status" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 @error('status') border-red-500 @enderror">
                        <option value="active" {{ old('status', $olt->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status', $olt->status) === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lokasi -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi</label>
                    <input type="text" name="location" value="{{ old('location', $olt->location) }}"
                           placeholder="Contoh: Gedung A Lantai 2"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 @error('location') border-red-500 @enderror">
                    @error('location')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 @error('description') border-red-500 @enderror">{{ old('description', $olt->description) }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Info Box -->
            <div class="mt-6 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                <div class="flex gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                    <div class="text-sm text-amber-800">
                        <p class="font-semibold mb-1">Tabel Existing</p>
                        <p>Tabel: <span class="font-mono font-bold">{{ $olt->table_name }}</span></p>
                        <p class="mt-1">Mengubah nama OLT tidak akan mengubah nama tabel yang sudah ada.</p>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-8 flex gap-4">
                <button type="submit" 
                        class="px-8 py-3 bg-violet-500 hover:bg-violet-600 text-white font-semibold rounded-lg transition-all shadow-lg">
                    Update OLT
                </button>
                <a href="{{ route('olt.index') }}" 
                   class="px-8 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-all">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app.app-layout>