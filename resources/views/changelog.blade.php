<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <h1 class="text-3xl font-bold text-gray-900">Changelog</h1>
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-md transition">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Voltar
                    </a>
                </div>
                <p class="mt-2 text-sm text-gray-600">Histórico de versões e atualizações do Enveloop</p>
            </div>

            <!-- Changelog Items -->
            <div class="space-y-6">
                
                <!-- Version 1.0.0 -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Versão 1.0.0</h2>
                            <p class="text-sm text-gray-500">Dezembro 2024 - Laravel 11</p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Atual
                        </span>
                    </div>
                    <div class="space-y-2 text-sm text-gray-700">
                        <p class="font-semibold text-gray-900">🚀 Grande Atualização - Migração para Laravel 11</p>
                        <ul class="list-disc list-inside space-y-1 ml-4">
                            <li>Migração completa para Laravel 11 e PHP 8.3</li>
                            <li>Novo design com Tailwind CSS</li>
                            <li>Arquitetura Service Layer implementada</li>
                            <li>Performance e segurança melhoradas</li>
                            <li>Interface responsiva e moderna</li>
                            <li>Gráficos interativos com Chart.js</li>
                            <li>Docker otimizado para Mac Silicon</li>
                        </ul>
                    </div>
                </div>

                <!-- Version 0.2.3 -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Versão 0.2.3</h2>
                            <p class="text-sm text-gray-500">2018 - Laravel 5.6</p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Legacy
                        </span>
                    </div>
                    <div class="space-y-2 text-sm text-gray-700">
                        <ul class="list-disc list-inside space-y-1 ml-4">
                            <li>Criação de novos relatórios gráficos</li>
                            <li>Substituição da tabela de progressão do saldo por gráficos</li>
                            <li>Melhorias no desempenho</li>
                            <li>Simplificação das funções de geração de gráficos</li>
                        </ul>
                    </div>
                </div>

                <!-- Version 0.2.2 -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Versão 0.2.2</h2>
                            <p class="text-sm text-gray-500">2018</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm text-gray-700">
                        <ul class="list-disc list-inside space-y-1 ml-4">
                            <li>Criação de mensagens quando saldo estiver negativo</li>
                            <li>Melhorias na interface de mensagens</li>
                        </ul>
                    </div>
                </div>

                <!-- Version 0.2.1 -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Versão 0.2.1</h2>
                            <p class="text-sm text-gray-500">2018</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm text-gray-700">
                        <ul class="list-disc list-inside space-y-1 ml-4">
                            <li>Correção na parte de relatório que somava o mês atual com o ano anterior</li>
                            <li>Correções pontuais de layout e textos</li>
                        </ul>
                    </div>
                </div>

                <!-- Version 0.2.0 -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Versão 0.2.0</h2>
                            <p class="text-sm text-gray-500">2018</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm text-gray-700">
                        <ul class="list-disc list-inside space-y-1 ml-4">
                            <li>Reformulação do layout com home simplificada</li>
                            <li>Detalhes dos envelopes em páginas internas</li>
                            <li>Relatórios contextuais para cada envelope</li>
                        </ul>
                    </div>
                </div>

                <!-- Version 0.1.3 -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Versão 0.1.3</h2>
                            <p class="text-sm text-gray-500">2018</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm text-gray-700">
                        <ul class="list-disc list-inside space-y-1 ml-4">
                            <li>Adicionada aba de estatísticas</li>
                        </ul>
                    </div>
                </div>

                <!-- Version 0.1.0 -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Versão 0.1.0</h2>
                            <p class="text-sm text-gray-500">2018</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm text-gray-700">
                        <ul class="list-disc list-inside space-y-1 ml-4">
                            <li>Criado feed de gastos para substituir as tabelas de envelopes</li>
                            <li>Melhoria na performance do código</li>
                            <li>Melhorias na interface</li>
                        </ul>
                    </div>
                </div>

                <!-- Version 0.0.1 Alpha -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Versão 0.0.1 Alpha</h2>
                            <p class="text-sm text-gray-500">2018</p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Primeira Versão
                        </span>
                    </div>
                    <div class="space-y-2 text-sm text-gray-700">
                        <ul class="list-disc list-inside space-y-1 ml-4">
                            <li>Lançamento inicial do Enveloop</li>
                            <li>App de finanças baseado no método dos envelopes</li>
                            <li>Relatórios que auxiliam na gestão de finanças pessoais</li>
                        </ul>
                    </div>
                </div>

            </div>

            <!-- Footer Note -->
            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            <strong>Nota:</strong> O Enveloop está em constante evolução. Sugestões e feedback são sempre bem-vindos!
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
