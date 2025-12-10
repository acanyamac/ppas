<!-- Header -->
<header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-6 py-4">
    <div class="flex items-center justify-between">
        
        <!-- Left Side: Toggle & Search -->
        <div class="flex items-center gap-4">
            <!-- Sidebar Toggle (Desktop) -->
            <button 
                @click="sidebarOpen = !sidebarOpen" 
                class="hidden lg:block text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors"
            >
                <i class="fas fa-bars text-xl"></i>
            </button>
            
            <!-- Mobile Menu Toggle -->
            <button 
                @click="mobileMenuOpen = true" 
                class="lg:hidden text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors"
            >
                <i class="fas fa-bars text-xl"></i>
            </button>
            
            <!-- Search Bar -->
            <div class="hidden md:block relative">
                <input 
                    type="text" 
                    placeholder="Ara..." 
                    class="w-64 pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                >
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>
        
        <!-- Right Side: Actions & Profile -->
        <div class="flex items-center gap-3">
            
            <!-- Dark Mode Toggle -->
            <button 
                @click="toggleDarkMode()" 
                class="p-2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-all"
                title="Dark Mode"
            >
                <i class="fas fa-moon text-lg dark:hidden"></i>
                <i class="fas fa-sun text-lg hidden dark:inline"></i>
            </button>
            
            <!-- Notifications -->
            <div x-data="{ open: false }" class="relative">
                <button 
                    @click="open = !open" 
                    class="p-2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-all relative"
                    title="Bildirimler"
                >
                    <i class="fas fa-bell text-lg"></i>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
                
                <!-- Notifications Dropdown -->
                <div 
                    x-show="open" 
                    @click.away="open = false"
                    x-transition
                    class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 z-50"
                    x-cloak
                >
                    <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Bildirimler</h3>
                    </div>
                    <div class="max-h-96 overflow-y-auto scrollbar-thin">
                        <a href="#" class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex items-start gap-3">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-900 dark:text-white">Yeni aktivite eklendi</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">2 dakika önce</p>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex items-start gap-3">
                                <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-900 dark:text-white">Tagleme işlemi tamamlandı</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">1 saat önce</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 text-center">
                        <a href="#" class="text-sm text-primary-500 hover:text-primary-700 font-medium">Tümünü Gör</a>
                    </div>
                </div>
            </div>
            
            <!-- User Profile -->
            <div x-data="{ open: false }" class="relative">
                <button 
                    @click="open = !open" 
                    class="flex items-center gap-3 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-all"
                >
                    <div class="flex items-center gap-3">
                        <div class="hidden sm:block text-right">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ Auth::user()->name ?? 'Kullan cı' }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ Auth::user()->email ?? 'user@example.com' }}
                            </p>
                        </div>
                        <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-full flex items-center justify-center">
                            <span class="text-white font-semibold">
                                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                            </span>
                        </div>
                    </div>
                    <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                </button>
                
                <!-- Profile Dropdown -->
                <div 
                    x-show="open" 
                    @click.away="open = false"
                    x-transition
                    class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 z-50"
                    x-cloak
                >
                    <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ Auth::user()->name ?? 'Kullanıcı' }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ Auth::user()->email ?? 'user@example.com' }}</p>
                    </div>
                    <div class="py-2">
                        <a href="#" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-user w-4"></i>
                            <span>Profilim</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-cog w-4"></i>
                            <span>Ayarlar</span>
                        </a>
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-700 py-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors w-full text-left">
                                <i class="fas fa-sign-out-alt w-4"></i>
                                <span>Çıkış Yap</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</header>
