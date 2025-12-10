<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Envel∞p') }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css'])
</head>
<body class="antialiased bg-gradient-to-br from-blue-50 via-white to-purple-50">
    <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-blue-500 selection:text-white">
        @if (Route::has('login'))
            <div class="absolute top-0 right-0 p-6 text-right">
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-500">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-500">Login</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-500">Criar Conta</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex flex-col items-center">
                <!-- Logo -->
                <div class="text-center mb-8">
                    <h1 class="text-7xl font-bold text-gray-900 mb-4">Envel∞p</h1>
                    <p class="text-xl text-gray-600 max-w-2xl">
                        Organize suas finanças com o método dos envelopes
                    </p>
                </div>

                <!-- Feature Cards -->
                <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 max-w-5xl">
                    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                        <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg mb-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Método dos Envelopes</h3>
                        <p class="text-gray-600 text-sm">
                            Divida sua renda em categorias específicas e controle cada centavo sem tirar o dinheiro do banco.
                        </p>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                        <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg mb-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Relatórios Visuais</h3>
                        <p class="text-gray-600 text-sm">
                            Acompanhe seus gastos e ganhos com gráficos interativos e relatórios mensais detalhados.
                        </p>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                        <div class="flex items-center justify-center w-12 h-12 bg-purple-100 rounded-lg mb-4">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">100% Seguro</h3>
                        <p class="text-gray-600 text-sm">
                            Seus dados são criptografados e protegidos. Controle total sobre suas informações financeiras.
                        </p>
                    </div>
                </div>

                <!-- CTA Section -->
                <div class="mt-16 text-center">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">
                        Como funciona o método dos envelopes?
                    </h2>
                    <p class="text-gray-600 max-w-2xl mb-8">
                        O método consiste em dividir sua renda em envelopes específicos, destinados a cada uma de suas despesas. 
                        O Enveloop organiza suas finanças baseado neste método, assim você tem uma visualização de onde vai o seu dinheiro 
                        sem a necessidade de tirá-lo do banco.
                    </p>
                    
                    @guest
                    <div class="flex gap-4 justify-center">
                        <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition">
                            Começar Agora
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-white hover:bg-gray-50 text-gray-700 font-semibold rounded-lg shadow-md border border-gray-300 transition">
                            Já tenho conta
                        </a>
                    </div>
                    @endguest
                </div>

                <!-- Footer -->
                <div class="mt-16 text-center text-sm text-gray-500">
                    <p>Desenvolvido com ❤️ para ajudar você a organizar suas finanças</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
