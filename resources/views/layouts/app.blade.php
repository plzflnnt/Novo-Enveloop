<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <title>{{ config('app.name', 'Envel∞p') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">
                                {{ config('app.name', 'Envel∞p') }}
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        @auth
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('home') ? 'border-blue-600 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium transition">
                                <i class="fas fa-home mr-2"></i> Dashboard
                            </a>
                            <a href="{{ route('transactions') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('transactions') ? 'border-blue-600 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium transition">
                                <i class="fas fa-list mr-2"></i> Transações
                            </a>
                            <a href="{{ route('report') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('report') ? 'border-blue-600 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium transition">
                                <i class="fas fa-chart-line mr-2"></i> Relatórios
                            </a>
                        </div>
                        @endauth
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        @auth
                        <div class="relative ml-3" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none transition">
                                <i class="fas fa-user-circle text-xl mr-2"></i>
                                <span>{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down ml-2 text-xs"></i>
                            </button>

                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-50">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i> Perfil
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Sair
                                    </button>
                                </form>
                            </div>
                        </div>
                        @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-gray-900">Login</a>
                        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 hover:text-gray-900">Criar Conta</a>
                        @endauth
                    </div>

                    <!-- Hamburger -->
                    <div class="flex items-center sm:hidden" x-data="{ open: false }">
                        <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div class="sm:hidden" x-show="open" x-data="{ open: false }">
                @auth
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ route('home') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('home') ? 'border-blue-600 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:bg-gray-50' }} text-base font-medium">
                        Dashboard
                    </a>
                    <a href="{{ route('transactions') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('transactions') ? 'border-blue-600 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:bg-gray-50' }} text-base font-medium">
                        Transações
                    </a>
                    <a href="{{ route('report') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('report') ? 'border-blue-600 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:bg-gray-50' }} text-base font-medium">
                        Relatórios
                    </a>
                </div>

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="px-4">
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                            Perfil
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                                Sair
                            </button>
                        </form>
                    </div>
                </div>
                @endauth
            </div>
        </nav>

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Flash Messages -->
                @if (session('flash_message'))
                <div class="mb-4 bg-blue-50 border-l-4 border-blue-400 p-4 auto-collapse">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">{!! session('flash_message') !!}</p>
                        </div>
                        <button type="button" class="ml-auto text-blue-400 hover:text-blue-600" onclick="this.parentElement.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                @endif

                @if (session('success'))
                <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                @if (session('error'))
                <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                {{ $slot }}
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-12">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="text-center text-sm text-gray-500">
                    <p>Enveloop App - Ver 1.0.0 <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">Beta</span></p>
                    <p class="mt-2">
                        <a href="{{ route('changelog') }}" class="text-blue-600 hover:text-blue-800">Changelog</a>
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>
</html>
