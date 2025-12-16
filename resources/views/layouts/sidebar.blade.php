<aside 
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 border-r border-gray-100 dark:border-gray-700 transition-transform duration-300 ease-in-out flex flex-col"
>
    
    <div class="h-16 flex items-center justify-between px-6 border-b border-gray-100 dark:border-gray-700">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path></svg>
            <span class="font-bold text-xl text-gray-800 dark:text-white">Mimate</span>
        </a>

        <button @click="sidebarOpen = false" class="md:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
        
        <a href="{{ route('dashboard') }}" 
           class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-300' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
            <span class="text-xl mr-3">📊</span>
            <span class="font-medium">Panel Principal</span>
        </a>

        <a href="{{ route('appointments.index') }}" 
           class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('appointments.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-300' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
            <span class="text-xl mr-3">📅</span>
            <span class="font-medium">Agenda</span>
        </a>

        <a href="{{ route('patients.create') }}" 
           class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('patients.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-300' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
            <span class="text-xl mr-3">👥</span>
            <span class="font-medium">Pacientes</span>
        </a>

        <a href="{{ route('services.index') }}" 
           class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('services.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-300' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
            <span class="text-xl mr-3">💆‍♀️</span>
            <span class="font-medium">Servicios</span>
        </a>

        <a href="{{ route('inventory.index') }}" 
           class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('inventory.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-300' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
            <span class="text-xl mr-3">📦</span>
            <span class="font-medium">Inventario</span>
        </a>

        <a href="#" class="flex items-center px-4 py-3 rounded-lg transition-colors text-gray-400 hover:text-gray-500 cursor-not-allowed" title="Próximamente">
            <span class="text-xl mr-3">💰</span>
            <span class="font-medium">Caja & Reportes</span>
        </a>
    </nav>

    <div class="border-t border-gray-100 dark:border-gray-700 p-4 bg-gray-50 dark:bg-gray-800/50">
        
        <button 
            x-data="{ 
                darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
                toggle() {
                    this.darkMode = !this.darkMode;
                    if (this.darkMode) {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('theme', 'dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('theme', 'light');
                    }
                }
            }"
            @click="toggle()"
            class="w-full flex items-center justify-between px-4 py-2 mb-4 bg-white dark:bg-gray-700 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition"
        >
            <span class="text-sm font-medium text-gray-700 dark:text-gray-200" x-text="darkMode ? 'Modo Oscuro' : 'Modo Claro'"></span>
            <svg x-show="!darkMode" class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            <svg x-show="darkMode" style="display: none;" class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
        </button>

        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="overflow-hidden">
                <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs text-red-500 hover:text-red-700 hover:underline">
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>