<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Messages -->
            @if($envelopeNegative && $grandBalanceInCents < 0)
                <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                <strong>Cuidado!</strong> Seu saldo está negativo. Você possui um ou mais envelopes com saldo negativo.<br>
                                <small>Isso quer dizer que você gastou mais do que tinha somando todos os seus recursos.</small>
                            </p>
                        </div>
                    </div>
                </div>
            @elseif($envelopeNegative && $grandBalanceInCents > 0)
                <div class="mb-4 bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Você possui um ou mais envelopes com saldo negativo.<br>
                                <small>Mas seu saldo ainda está positivo! Isso significa que você tem saldo suficiente em outros envelopes que cobriram suas despesas.</small>
                            </p>
                        </div>
                    </div>
                </div>
            @elseif(!$envelopeNegative && $grandBalanceInCents < 0)
                <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                <strong>Cuidado!</strong> Seu saldo está negativo.
                                <small>Isso quer dizer que você gastou mais do que tinha somando todos os seus recursos.</small>
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Balance Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Saldo Não Alocado -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-700">Saldo Não Alocado</h3>
                        <button class="text-gray-400 hover:text-gray-600" title="Este saldo representa seus ganhos menos o dinheiro alocado nos envelopes. Note que isso não representa seu total em mãos!">
                            <i class="fas fa-question-circle"></i>
                        </button>
                    </div>
                    <p class="text-3xl font-bold {{ $balanceInCents < 0 ? 'text-red-600' : 'text-green-600' }} mb-4">
                        R$ {{ $balance }}
                    </p>
                    <div class="flex gap-2">
                        <button onclick="openModal('balanceModalEarning')" class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md transition">
                            <i class="fas fa-arrow-up mr-2"></i>
                            Ganho
                        </button>
                        <button onclick="openModal('balanceModalExpense')" class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md transition">
                            <i class="fas fa-arrow-down mr-2"></i>
                            Despesa
                        </button>
                    </div>
                </div>

                <!-- Saldo Em Mãos -->
                @if(count($envelopes) > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-700">Saldo Em Mãos</h3>
                        <button class="text-gray-400 hover:text-gray-600" title="Este é o total que você deve ter em mãos. É a soma do Seu SALDO NÃO ALOCADO e o Saldo dos Envelopes.">
                            <i class="fas fa-question-circle"></i>
                        </button>
                    </div>
                    <p class="text-3xl font-bold {{ $grandBalanceInCents < 0 ? 'text-red-600' : 'text-green-600' }}">
                        R$ {{ $grandBalance }}
                    </p>
                </div>
                @endif

                <!-- Quick Stats -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-md p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Envelopes Ativos</h3>
                        <i class="fas fa-envelope text-2xl opacity-50"></i>
                    </div>
                    <p class="text-4xl font-bold mb-2">{{ count($envelopes) }}</p>
                    <p class="text-sm opacity-80">categorias de gastos</p>
                </div>
            </div>

            <!-- Envelopes Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Envelopes</h2>
                    <button onclick="openModal('addEnvelopeModal')" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition">
                        <i class="fas fa-plus mr-2"></i>
                        Adicionar Envelope
                    </button>
                </div>

                @if(count($envelopes) == 0)
                    <div class="bg-white rounded-lg shadow-md p-12 text-center">
                        <div class="max-w-md mx-auto">
                            <i class="fas fa-envelope text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Nenhum envelope ainda</h3>
                            <p class="text-gray-600 mb-6">Crie seu primeiro envelope para começar a organizar suas finanças.</p>
                            <button onclick="openModal('addEnvelopeModal')" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition">
                                <i class="fas fa-plus mr-2"></i>
                                Criar Primeiro Envelope
                            </button>
                        </div>
                    </div>

                    <!-- Welcome Message -->
                    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-blue-900 mb-3">👋 Bem-vindo ao Enveloop!</h3>
                        <div class="space-y-2 text-sm text-blue-800">
                            <p><strong>Para começar:</strong></p>
                            <ol class="list-decimal list-inside space-y-1 ml-2">
                                <li>Clique em "Ganho" ao lado do Saldo e insira o seu saldo atual somado de todas as suas economias</li>
                                <li>Depois crie um envelope para cada categoria de gasto</li>
                                <li>Aplique dinheiro do saldo aos envelopes conforme necessário</li>
                            </ol>
                            <p class="mt-4"><strong>Como funciona?</strong></p>
                            <p>Cada envelope serve como uma poupança onde você pode dividir seu dinheiro por tipo de gasto e organizar suas finanças, evitando que você use o dinheiro do seguro do carro com as saídas no fim de semana, por exemplo.</p>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($envelopes as $envelope)
                        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    <a href="{{ route('envelope.show', ['id' => encrypt($envelope->id)]) }}" class="hover:text-blue-600 transition">
                                        {{ $envelope->name }}
                                    </a>
                                </h3>
                                <i class="fas fa-envelope text-gray-300"></i>
                            </div>
                            <p class="text-2xl font-bold {{ $envelope->balance_in_cents < 0 ? 'text-red-600' : 'text-green-600' }} mb-4">
                                R$ {{ $envelope->balance_formatted }}
                            </p>
                            <div class="flex gap-2">
                                <button onclick="openEnvelopeModal('earning', {{ $envelope->id }})" class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 text-sm font-medium rounded-md transition">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    Investir
                                </button>
                                <button onclick="openEnvelopeModal('expense', {{ $envelope->id }})" class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-red-50 hover:bg-red-100 text-red-700 text-sm font-medium rounded-md transition">
                                    <i class="fas fa-arrow-down mr-1"></i>
                                    Despesa
                                </button>
                                <a href="{{ route('envelope.show', ['id' => encrypt($envelope->id)]) }}" class="inline-flex items-center justify-center px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 text-sm font-medium rounded-md transition">
                                    <i class="fas fa-chart-line"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Recent Transactions -->
            @if(count($feed) > 0)
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold text-gray-900">Transações Recentes</h2>
                    <a href="{{ route('transactions') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                        Ver todas <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descrição</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Envelope</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Data</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($feed as $transaction)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($transaction->type == 1)
                                        <i class="fas fa-arrow-up text-green-600"></i>
                                    @elseif($transaction->type == 2)
                                        <i class="fas fa-circle text-blue-600 text-xs"></i>
                                    @else
                                        <i class="fas fa-arrow-down text-red-600"></i>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $transaction->name }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 hidden sm:table-cell">
                                    {{ $transaction->envelope_name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold {{ $transaction->value < 0 ? 'text-red-600' : 'text-green-600' }}">
                                        R$ {{ format_currency($transaction->value) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                                    {{ $transaction->valid_at->format('d/m/Y') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Charts -->
            @if(count($envelopes) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Chart 1 -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Ganhos vs Gastos (Últimos 6 meses)</h3>
                    <canvas id="earningsExpensesChart"></canvas>
                </div>

                <!-- Chart 2 -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Divisão do Dinheiro</h3>
                    <canvas id="envelopeDivisionChart"></canvas>
                </div>
            </div>
            @endif

        </div>
    </div>

    <!-- Modals -->
    @include('components.modals.balance-actions')
    @include('components.modals.add-envelope')
    @include('components.modals.envelope-actions')

    <!-- Scripts -->
    @push('scripts')
    <script>
        // Modal functions
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Charts
        @if(count($envelopes) > 0 && isset($report))
        // Ganhos vs Gastos
        const ctxEarnings = document.getElementById('earningsExpensesChart');
        if (ctxEarnings) {
            new Chart(ctxEarnings, {
                type: 'bar',
                data: {
                    labels: [@foreach(array_slice($report, -6) as $data)'{{ $data["month_name"] ?? $data["month"] }}',@endforeach],
                    datasets: [{
                        label: 'Ganhos',
                        data: [@foreach(array_slice($report, -6) as $data){{ $data["earn"]/100 }},@endforeach],
                        backgroundColor: 'rgba(34, 197, 94, 0.2)',
                        borderColor: 'rgba(34, 197, 94, 1)',
                        borderWidth: 2
                    }, {
                        label: 'Gastos',
                        data: [@foreach(array_slice($report, -6) as $data){{ $data["spent"]/100 }},@endforeach],
                        backgroundColor: 'rgba(239, 68, 68, 0.2)',
                        borderColor: 'rgba(239, 68, 68, 1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'R$ ' + value.toLocaleString('pt-BR');
                                }
                            }
                        }
                    }
                }
            });
        }

        // Divisão de Dinheiro
        const ctxDivision = document.getElementById('envelopeDivisionChart');
        if (ctxDivision) {
            new Chart(ctxDivision, {
                type: 'doughnut',
                data: {
                    labels: ['Saldo não alocado', @foreach($envelopes as $env)'{{ $env->name }}',@endforeach],
                    datasets: [{
                        data: [{{ $balanceInCents/100 }}, @foreach($envelopes as $env){{ $env->balance_in_cents/100 }},@endforeach],
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(34, 197, 94, 0.8)',
                            'rgba(168, 85, 247, 0.8)',
                            'rgba(251, 146, 60, 0.8)',
                            'rgba(236, 72, 153, 0.8)',
                            'rgba(14, 165, 233, 0.8)',
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
        @endif
    </script>
    @endpush
</x-app-layout>
