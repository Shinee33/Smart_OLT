<x-app.app-layout>
    <div class="mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('olt.index') }}" class="text-white hover:text-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-white">Tambah OLT Baru</h1>
                <p class="text-gray-200 mt-1">Penambahan Untuk OLT Baru</p>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-xl p-8 max-w-4xl">
        <form action="{{ route('olt.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- Nama OLT -->
                <div class="grid grid-cols-12 gap-4 items-center">
                    <label class="col-span-3 text-right text-sm font-medium text-gray-700">Nama</label>
                    <div class="col-span-9">
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
                        @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- OLT IP or FQDN -->
                <div class="grid grid-cols-12 gap-4 items-center">
                    <label class="col-span-3 text-right text-sm font-medium text-gray-700">OLT IP or FQDN</label>
                    <div class="col-span-9">
                        <input type="text" name="ip_address" value="{{ old('ip_address') }}" required
                               placeholder="10.16.100.34"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('ip_address') border-red-500 @enderror">
                        @error('ip_address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Telnet TCP Port -->
                <div class="grid grid-cols-12 gap-4 items-center">
                    <label class="col-span-3 text-right text-sm font-medium text-gray-700">Port TCP</label>
                    <div class="col-span-9">
                        <input type="number" name="telnet_port" value="{{ old('telnet_port', 23) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('telnet_port') border-red-500 @enderror">
                        @error('telnet_port')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- OLT Telnet Username -->
                <div class="grid grid-cols-12 gap-4 items-center">
                    <label class="col-span-3 text-right text-sm font-medium text-gray-700">OLT username</label>
                    <div class="col-span-9">
                        <input type="text" name="telnet_username" value="{{ old('telnet_username') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('telnet_username') border-red-500 @enderror">
                        @error('telnet_username')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- OLT Telnet Password -->
                <div class="grid grid-cols-12 gap-4 items-center">
                    <label class="col-span-3 text-right text-sm font-medium text-gray-700">OLT password</label>
                    <div class="col-span-9">
                        <input type="password" name="telnet_password" value="{{ old('telnet_password') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('telnet_password') border-red-500 @enderror">
                        @error('telnet_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- SNMP Read-only Community -->
                <div class="grid grid-cols-12 gap-4 items-center">
                    <label class="col-span-3 text-right text-sm font-medium text-gray-700">SNMP read community</label>
                    <div class="col-span-9">
                        <input type="text" name="snmp_community" value="{{ old('snmp_community', 'public') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('snmp_community') border-red-500 @enderror">
                        @error('snmp_community')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- SNMP Read-write Community -->
                <div class="grid grid-cols-12 gap-4 items-center">
                    <label class="col-span-3 text-right text-sm font-medium text-gray-700">SNMP write community</label>
                    <div class="col-span-9">
                        <input type="text" name="snmp_rw_community" value="{{ old('snmp_rw_community', 'private') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('snmp_rw_community') border-red-500 @enderror">
                        @error('snmp_rw_community')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- SNMP UDP Port -->
                <div class="grid grid-cols-12 gap-4 items-center">
                    <label class="col-span-3 text-right text-sm font-medium text-gray-700">SNMP UDP port</label>
                    <div class="col-span-9">
                        <input type="number" name="snmp_port" value="{{ old('snmp_port', 161) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('snmp_port') border-red-500 @enderror">
                        @error('snmp_port')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- IPTV Module -->
                <div class="grid grid-cols-12 gap-4 items-center">
                    <label class="col-span-3 text-right text-sm font-medium text-gray-700">IPTV module</label>
                    <div class="col-span-9">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="iptv_enabled" value="1" {{ old('iptv_enabled') ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Enable</span>
                        </label>
                    </div>
                </div>

                <!-- TYPE OLT -->
                <div class="grid grid-cols-12 gap-4 items-center">
                    <label class="col-span-3 text-right text-sm font-medium text-gray-700">Jenis OLT</label>
                    <div class="col-span-9">
                        <select name="type" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-100 @error('manufacturer') border-red-500 @enderror">
                            <option value="ZTE" {{ old('type', 'ZTE') === 'ZTE' ? 'selected' : '' }}>ZTE</option>
                            <option value="Huawei" {{ old('type') === 'Huawei' ? 'selected' : '' }}>Huawei</option>
                            <option value="Fastlink" {{ old('type') === 'Fastlink' ? 'selected' : '' }}>Fastlink</option>
                        </select>
                        @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- OLT Hardware Version -->
                <div class="grid grid-cols-12 gap-4 items-center">
                    <label class="col-span-3 text-right text-sm font-medium text-gray-700">OLT hardware version</label>
                    <div class="col-span-9">
                        <select name="hardware_version" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('hardware_version') border-red-500 @enderror">
                            <option value="ZTE-C220" {{ old('hardware_version') === 'ZTE-C220' ? 'selected' : '' }}>ZTE-C220</option>
                            <option value="ZTE-C300" {{ old('hardware_version', 'ZTE-C300') === 'ZTE-C300' ? 'selected' : '' }}>ZTE-C300</option>
                            <option value="ZTE-C300M" {{ old('hardware_version') === 'ZTE-C300M' ? 'selected' : '' }}>ZTE-C300M</option>
                            <option value="ZTE-C320" {{ old('hardware_version') === 'ZTE-C320' ? 'selected' : '' }}>ZTE-C320</option>
                            <option value="ZTE-C350" {{ old('hardware_version') === 'ZTE-C350' ? 'selected' : '' }}>ZTE-C350</option>
                            <option value="ZTE-C350M" {{ old('hardware_version') === 'ZTE-C350M' ? 'selected' : '' }}>ZTE-C350M</option>
                            <option value="ZTE-C600" {{ old('hardware_version') === 'ZTE-C600' ? 'selected' : '' }}>ZTE-C600</option>
                            <option value="ZTE-C610" {{ old('hardware_version') === 'ZTE-C610' ? 'selected' : '' }}>ZTE-C610</option>
                            <option value="ZTE-C610L" {{ old('hardware_version') === 'ZTE-C610L' ? 'selected' : '' }}>ZTE-C610L</option>
                            <option value="ZTE-C620" {{ old('hardware_version') === 'ZTE-C620' ? 'selected' : '' }}>ZTE-C620</option>
                            <option value="ZTE-C650" {{ old('hardware_version') === 'ZTE-C650' ? 'selected' : '' }}>ZTE-C650</option>
                            <option value="ZTE-C680" {{ old('hardware_version') === 'ZTE-C680' ? 'selected' : '' }}>ZTE-C680</option>
                            <option value="ZTE-C69E-15" {{ old('hardware_version') === 'ZTE-C69E-15' ? 'selected' : '' }}>ZTE-C69E-15</option>
                            <option value="ZTE-C69E-2" {{ old('hardware_version') === 'ZTE-C69E-2' ? 'selected' : '' }}>ZTE-C69E-2</option>
                            <option value="ZTE-C69E-7" {{ old('hardware_version') === 'ZTE-C69E-7' ? 'selected' : '' }}>ZTE-C69E-7</option>
                        </select>
                        @error('hardware_version')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- OLT Software Version -->
                <div class="grid grid-cols-12 gap-4 items-center">
                    <label class="col-span-3 text-right text-sm font-medium text-gray-700">OLT software version</label>
                    <div class="col-span-9">
                        <select name="software_version" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('software_version') border-red-500 @enderror">
                            <option value="1.2.x" {{ old('software_version', '1.2.x') === '1.2.x' ? 'selected' : '' }}>1.2.x</option>
                            <option value="2.0.x" {{ old('software_version') === '2.0.x' ? 'selected' : '' }}>2.0.x</option>
                            <option value="2.1.x" {{ old('software_version') === '2.1.x' ? 'selected' : '' }}>2.1.x</option>
                        </select>
                        @error('software_version')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Supported PON Types -->
                <div class="grid grid-cols-12 gap-4 items-center">
                    <label class="col-span-3 text-right text-sm font-medium text-gray-700">Supported PON types</label>
                    <div class="col-span-9">
                        <div class="flex gap-6">
                            <label class="inline-flex items-center">
                                <input type="radio" name="pon_type" value="GPON" {{ old('pon_type', 'GPON') === 'GPON' ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">GPON</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="pon_type" value="EPON" {{ old('pon_type') === 'EPON' ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">EPON</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="pon_type" value="GPON+EPON" {{ old('pon_type') === 'GPON+EPON' ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">GPON+EPON</span>
                            </label>
                        </div>
                        @error('pon_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-8 flex gap-3">
                <button type="submit" 
                        class="px-6 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded transition-all inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Save
                </button>
                <a href="{{ route('olt.index') }}" 
                   class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded transition-all">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app.app-layout>