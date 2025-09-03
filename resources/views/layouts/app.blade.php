<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Library RS')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen flex">
        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
             class="fixed inset-y-0 left-0 z-50 w-64 bg-indigo-800 shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0">
            
            <!-- Logo/Brand -->
            <div class="flex items-center justify-center h-16 px-4 border-b border-indigo-700">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                        <i class="fas fa-plus text-indigo-800 text-sm"></i>
                    </div>
                    <h1 class="text-xl font-bold text-white">Library RS</h1>
                </div>
            </div>

            <!-- Sidebar Navigation -->
            <nav class="px-4 py-6">
                <div class="mb-6">
                    <h3 class="text-xs font-semibold text-indigo-300 uppercase tracking-wider mb-3">MENU UTAMA</h3>
                </div>
                
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-indigo-700 transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-700' : '' }}">
                            <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                            Dashboard
                        </a>
                    </li>
                    
                    @if(auth()->user()->hasPermission('manage_materials'))
                    <li>
                        <a href="{{ route('materials.index') }}" class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-indigo-700 transition-colors {{ request()->routeIs('materials.*') ? 'bg-indigo-700' : '' }}">
                            <i class="fas fa-book-medical w-5 mr-3"></i>
                            Materi
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->hasPermission('manage_users'))
                    <li>
                        <a href="{{ route('users.index') }}" class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-indigo-700 transition-colors {{ request()->routeIs('users.*') ? 'bg-indigo-700' : '' }}">
                            <i class="fas fa-users w-5 mr-3"></i>
                            Users
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->hasPermission('manage_roles'))
                    <li>
                        <a href="{{ route('roles.index') }}" class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-indigo-700 transition-colors {{ request()->routeIs('roles.*') ? 'bg-indigo-700' : '' }}">
                            <i class="fas fa-user-shield w-5 mr-3"></i>
                            Roles
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->hasPermission('manage_permissions'))
                    <li>
                        <a href="{{ route('permissions.index') }}" class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-indigo-700 transition-colors {{ request()->routeIs('permissions.*') ? 'bg-indigo-700' : '' }}">
                            <i class="fas fa-key w-5 mr-3"></i>
                            Permissions
                        </a>
                    </li>
                    @endif
                </ul>

                <!-- User Profile Section -->
                <div class="mt-8 pt-6 border-t border-indigo-700">
                    <div class="flex items-center px-4 py-3 text-white">
                        <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-medium">{{ auth()->user()->name }}</div>
                            <div class="text-xs text-indigo-300">{{ auth()->user()->role->display_name ?? 'User' }}</div>
                        </div>
                        <i class="fas fa-chevron-down text-xs text-indigo-300"></i>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col lg:ml-0">
            <!-- Top Navigation Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between h-16 px-6">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden mr-4 p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h2>
                            <p class="text-sm text-gray-500">Library Management System</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-600">
                            {{ now()->format('d M Y, H:i') }}
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-md transition-colors">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6 bg-gray-50">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>

        <!-- Mobile Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" 
             class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"></div>
    </div>
</body>
</html>
