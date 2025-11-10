<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width">
  <title>Sidebar - Smart OLT</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#e8eaf0] flex">

  <!-- SIDEBAR -->
  <aside 
    class="fixed left-0 top-0 h-screen flex flex-col bg-[#1e293b] border-r border-slate-700 shadow-xl w-64 transition-all duration-300 ease-in-out z-50"
    x-data="{ open: false }"
>
    <!-- Header -->
    <div class="flex items-center justify-between p-4 border-b border-gray-700/40">
      <a href="{{ route('dashboard.index') }}"  class="flex items-center gap-3 hover:opacity-80 transition-opacity">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
             stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-violet-400">
          <path stroke-linecap="round" stroke-linejoin="round" 
                d="M8.288 15.038a5.25 5.25 0 0 1 7.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 0 1 1.06 0Z" />
        </svg>
        <span class="text-xl font-bold text-white whitespace-nowrap">Smart OLT</span>
      </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto p-4 space-y-6">
      <div>
        <h3 class="text-xs uppercase text-gray-400 font-semibold pl-3 mb-3">Navigasi</h3>

        <ul class="space-y-1">
          <!-- Dashboard -->
          <li>
            <a href="{{ route('dashboard.index') }}" 
               class="flex items-center gap-3 px-4 py-2.5 text-white rounded-lg hover:bg-violet-500/10 transition-all {{ request()->routeIs('dashboard.*') ? 'bg-violet-500/10 text-violet-400' : '' }}">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                   viewBox="0 0 24 24" fill="none" stroke="currentColor"
                   stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m12 14 4-4" />
                <path d="M3.34 19a10 10 0 1 1 17.32 0" />
              </svg>
              <span class="text-sm font-medium">Dashboard</span>
            </a>
          </li>

          <!-- Penambahan Smart (Dropdown) -->
          <li>
            <button 
              @click="open = !open"
              class="w-full flex items-center justify-between px-4 py-2.5 text-gray-300 hover:text-white hover:bg-violet-500/10 rounded-lg transition">
              <div class="flex items-center gap-3">
                <svg class="w-5 h-5 fill-current text-gray-400"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                  <path d="M13.95.879a3 3 0 0 0-4.243 0L1.293 9.293a1 1 0 0 0-.274.51l-1 5a1 1 0 0 0 1.177 1.177l5-1a1 1 0 0 0 .511-.273l8.414-8.414a3 3 0 0 0 0-4.242L13.95.879Z" />
                  <path d="M10 14a1 1 0 1 0 0 2h5a1 1 0 1 0 0-2h-5Z" />
                </svg>
                <span class="text-sm font-medium">Penambahan Smart</span>
              </div>

              <svg class="w-4 h-4 fill-current text-gray-400 transition-transform"
                   :class="open ? 'rotate-180 text-violet-400' : ''"
                   viewBox="0 0 12 12">
                <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
              </svg>
            </button>

            <!-- Submenu -->
            <ul x-show="open" 
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform -translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                class="mt-1 space-y-1">
              <li>
                <a href="{{ route('olt.index') }}" 
                   class="flex items-center gap-3 pl-12 pr-4 py-2.5 text-sm rounded-lg transition-all {{ request()->routeIs('olt.*') ? 'text-violet-400 bg-violet-500/10' : 'text-gray-400 hover:text-violet-400 hover:bg-violet-500/10' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 0 1-3-3m3 3a3 3 0 1 0 0 6h13.5a3 3 0 1 0 0-6m-16.5-3a3 3 0 0 1 3-3h13.5a3 3 0 0 1 3 3m-19.5 0a4.5 4.5 0 0 1 .9-2.7L5.737 5.1a3.375 3.375 0 0 1 2.7-1.35h7.126c1.062 0 2.062.5 2.7 1.35l2.587 3.45a4.5 4.5 0 0 1 .9 2.7m0 0a3 3 0 0 1-3 3m0 3h.008v.008h-.008v-.008Zm0-6h.008v.008h-.008v-.008Zm-3 6h.008v.008h-.008v-.008Zm0-6h.008v.008h-.008v-.008Z" />
                  </svg>
                  Smart OLT
                </a>
              </li>
              <li>
                <a href="{{ route('pelanggan.index') }}" 
                   class="flex items-center gap-3 pl-12 pr-4 py-2.5 text-sm rounded-lg transition-all {{ request()->routeIs('pelanggan.*') ? 'text-violet-400 bg-violet-500/10' : 'text-gray-400 hover:text-violet-400 hover:bg-violet-500/10' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                  </svg>
                  Pelanggan
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>

    <!-- User Info -->
    <div class="p-4 border-t border-gray-700 mt-auto">
      <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-full bg-violet-500 flex items-center justify-center text-white font-semibold text-sm">A</div>
        <div class="flex-1 min-w-0">
          <p class="text-sm font-medium text-white truncate">Vito Ganteng</p>
          <p class="text-xs text-gray-400 truncate">vitoganteng@smartolt.com</p>
        </div>
      </div>
    </div>

  </aside>

</body>
</html>