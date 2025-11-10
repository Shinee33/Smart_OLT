<div class="min-w-fit relative" x-data="{ sidebarOpen: false, sidebarExpanded: true }">
    <!-- Toggle sidebar button -->
    <button 
        @click="sidebarOpen = !sidebarOpen"
        type="button"
        x-show="!sidebarOpen"
        x-transition
        class="fixed top-4 left-4 z-[60] lg:hidden inline-flex items-center justify-center w-11 h-11 rounded-lg bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-500 shadow-lg transition-all duration-200"
    >
        <span class="sr-only">Toggle sidebar</span>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24">
            <path d="M3 6h18M3 12h18M3 18h18"/>
        </svg>
    </button>

    <!-- Sidebar backdrop -->
    <div
        x-show="sidebarOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="sidebarOpen = false"
        class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-[50] lg:hidden"
        style="display: none;"
    ></div>

    <!-- Sidebar -->
    <aside
        id="sidebar"
        class="flex flex-col fixed lg:static left-0 top-0 h-screen overflow-y-auto no-scrollbar shrink-0 bg-white dark:bg-gray-800 p-4 transition-all duration-300 ease-in-out border-r border-gray-200 dark:border-gray-700/60 shadow-xl lg:shadow-none"
        :class="{
            'translate-x-0': sidebarOpen || window.innerWidth >= 1024,
            '-translate-x-full': !sidebarOpen && window.innerWidth < 1024,
            'z-[55]': sidebarOpen,
            'z-10': !sidebarOpen,
            'lg:w-64': sidebarExpanded,
            'lg:w-20': !sidebarExpanded,
            'w-64': true
        }"
        @keydown.escape.window="sidebarOpen = false"
    >

        <!-- Sidebar header -->
        <div class="flex justify-between items-center mb-10 pr-3 sm:px-2">
            <!-- Close button (mobile only) -->
            <button 
                type="button"
                class="lg:hidden inline-flex items-center justify-center w-9 h-9 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200"
                @click="sidebarOpen = false"
            >
                <span class="sr-only">Close sidebar</span>
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                    <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                </svg>
            </button>

            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                <svg class="fill-violet-500 shrink-0" xmlns="http://www.w3.org/2000/svg" width="32" height="32">
                    <path d="M31.956 14.8C31.372 6.92 25.08.628 17.2.044V5.76a9.04 9.04 0 0 0 9.04 9.04h5.716ZM14.8 26.24v5.716C6.92 31.372.63 25.08.044 17.2H5.76a9.04 9.04 0 0 1 9.04 9.04Zm11.44-9.04h5.716c-.584 7.88-6.876 14.172-14.756 14.756V26.24a9.04 9.04 0 0 1 9.04-9.04ZM.044 14.8C.63 6.92 6.92.628 14.8.044V5.76a9.04 9.04 0 0 1-9.04 9.04H.044Z" />
                </svg>
                <span class="text-xl font-bold text-gray-900 dark:text-white whitespace-nowrap" x-show="sidebarExpanded" x-transition>
                    Smart OLT
                </span>
            </a>
        </div>

        <!-- Navigation -->
        <div class="space-y-8 flex-1">
            <div>
                <h3 class="text-xs uppercase text-gray-400 dark:text-gray-500 font-semibold pl-3 mb-3">
                    <span x-show="!sidebarExpanded" class="block text-center w-full" x-transition>•••</span>
                    <span x-show="sidebarExpanded" x-transition>Navigasi</span>
                </h3>

                <ul class="space-y-1">
                    <!-- Dashboard -->
                    <li class="rounded-lg">
                        <a 
                            href="{{ route('dashboard') }}" 
                            class="flex items-center gap-3 px-4 py-2.5 text-gray-800 dark:text-gray-100 hover:text-violet-600 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg transition-all duration-200"
                        >
                            <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 12l9-9 9 9v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            </svg>
                            <span class="text-sm font-medium" x-show="sidebarExpanded" x-transition>Dashboard</span>
                        </a>
                    </li>

                    <!-- Smart OLT (placeholder) -->
                    <li class="rounded-lg">
                        <a 
                            href="#" 
                            class="flex items-center gap-3 px-4 py-2.5 text-gray-800 dark:text-gray-100 hover:text-violet-600 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg transition-all duration-200"
                        >
                            <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            <span class="text-sm font-medium" x-show="sidebarExpanded" x-transition>Smart OLT</span>
                        </a>
                    </li>

                    <!-- Pelanggan (placeholder) -->
                    <li class="rounded-lg">
                        <a 
                            href="#" 
                            class="flex items-center gap-3 px-4 py-2.5 text-gray-800 dark:text-gray-100 hover:text-violet-600 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg transition-all duration-200"
                        >
                            <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A10 10 0 1 1 18.364 4.561M15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                            </svg>
                            <span class="text-sm font-medium" x-show="sidebarExpanded" x-transition>Pelanggan</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Expand button -->
        <div class="absolute top-1/2 -right-3.5 -translate-y-1/2 hidden lg:block">
            <button 
                type="button"
                @click="sidebarExpanded = !sidebarExpanded"
                class="group relative flex items-center justify-center w-7 h-7 rounded-full shadow-lg bg-gradient-to-br from-violet-500 to-violet-600 hover:scale-110 active:scale-95 transition-all duration-200 text-white focus:outline-none focus:ring-4 focus:ring-violet-200 dark:focus:ring-violet-800"
            >
                <span class="sr-only">Expand / collapse sidebar</span>
                <svg class="w-4 h-4 fill-current transition-transform duration-300" :class="sidebarExpanded ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                    <path d="M15 16a1 1 0 0 1-1-1V1a1 1 0 1 1 2 0v14a1 1 0 0 1-1 1ZM8.586 7H1a1 1 0 1 0 0 2h7.586l-2.793 2.793a1 1 0 1 0 1.414 1.414l4.5-4.5a1 1 0 0 0 0-1.414l-4.5-4.5a1 1 0 0 0-1.414 1.414L8.586 7Z"/>
                </svg>
            </button>
        </div>
    </aside>
</div>
