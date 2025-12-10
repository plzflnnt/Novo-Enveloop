<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Relatórios Financeiros</h1>
                        <p class="mt-1 text-sm text-gray-600">Análise detalhada dos últimos 12 meses</p>
                    </div>
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-md transition">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Voltar
                    </a>
                </div>
            </div>

            @if(isset($report) && count($report) > 0)
            
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                @php
                    $totalEarnings = 0;
                    $totalExpenses = 0;
                    $currentBalance = 0;
                    foreach($report as $month) {
                        $totalEarnings += $month['earn'];
                        $totalExpenses += $month['spent'];
                    }
                    $currentBalance = $report[count($report) - 1]['balanceProgression'] ?? 0;
                    $netResult = $totalEarnings - $totalExpenses;
                @endphp

                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-md p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm opacity-80">Total de Ganhos</p>
                        <i class="fas fa-arrow-up text-2xl opacity-50"></i>
                    </div>
                    <p class="text-3xl font-bold">R$ {{ format_currency($totalEarnings) }}</p>
                    <p class="text-xs opacity-80 mt-1">Últimos 12 meses</p>
                </div>

                <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-md p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm opacity-80">Total de Gastos</p>
                        <i class="fas fa-arrow-down text-2xl opacity-50"></i>
                    </div>
                    <p class="text-3xl font-bold">R$ {{ format_currency($totalExpenses) }}</p>
                    <p class="text-xs opacity-80 mt-1">Últimos 12 meses</p>
                </div>

                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-md p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm opacity-80">Resultado Líquido</p>
                        <i class="fas fa-chart-line text-2xl opacity-50"></i>
                    </div>
                    <p class="text-3xl font-bold">R$ {{ format_currency($netResult) }}</p>
                    <p class="text-xs opacity-80 mt-1">Ganhos - Gastos</p>
                </div>

                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-md p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm opacity-80">Saldo Atual</p>
                        <i class="fas fa-wallet text-2xl opacity-50"></i>
                    </div>
                    <p class="text-3xl font-bold">R$ {{ format_currency($currentBalance) }}</p>
                    <p class="text-xs opacity-80 mt-1">Saldo acumulado</p>
                </div>
            </div>

            <!-- Main Charts -->
            <div class="space-y-6 mb-8">
                <!-- Ganhos vs Gastos -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Ganhos vs Gastos (12 meses)</h2>
                    <canvas id="earningsExpensesChart" class="w-full" style="max-height: 400px;"></canvas>
                </div>

                <!-- Resultado Mensal -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Resultado Mensal</h2>
                    <p class="text-sm text-gray-600 mb-4">Diferença entre ganhos e gastos por mês</p>
                    <canvas id="monthlyResultChart" class="w-full" style="max-height: 400px;"></canvas>
                </div>

                <!-- Progressão do Saldo -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Progressão do Saldo Total</h2>
                    <p class="text-sm text-gray-600 mb-4">Evolução do seu saldo ao longo do tempo</p>
                    <canvas id="balanceProgressionChart" class="w-full" style="max-height: 400px;"></canvas>
                </div>
            </div>

            <!-- Monthly Data Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Dados Mensais Detalhados</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Mês
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ganhos
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Gastos
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Resultado
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Saldo Acumulado
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($report as $monthData)
                            @php
                                $result = $monthData['earn'] - $monthData['spent'];
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $monthData['month_name'] ?? $monthData['month'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-semibold">
                                    R$ {{ format_currency($monthData['earn']) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-semibold">
                                    R$ {{ format_currency($monthData['spent']) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold {{ $result >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    R$ {{ format_currency($result) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold {{ $monthData['balanceProgression'] >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                                    R$ {{ format_currency($monthData['balanceProgression']) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 font-semibold">
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900">TOTAL</td>
                                <td class="px-6 py-4 text-sm text-green-600">R$ {{ format_currency($totalEarnings) }}</td>
                                <td class="px-6 py-4 text-sm text-red-600">R$ {{ format_currency($totalExpenses) }}</td>
                                <td class="px-6 py-4 text-sm {{ $netResult >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    R$ {{ format_currency($netResult) }}
                                </td>
                                <td class="px-6 py-4 text-sm {{ $currentBalance >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                                    R$ {{ format_currency($currentBalance) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            @else
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-chart-bar text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Sem dados suficientes</h3>
                <p class="text-gray-600 mb-6">Adicione transações para visualizar relatórios completos.</p>
                <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Voltar ao Dashboard
                </a>
            </div>
            @endif

        </div>
    </div>

    @if(isset($report) && count($report) > 0)
    <script>
        // Ganhos vs Gastos
        const ctxEarningsExpenses = document.getElementById('earningsExpensesChart');
        new Chart(ctxEarningsExpenses, {
            type: 'bar',
            data: {
                labels: [@foreach($report as $data)'{{ $data["month_name"] ?? $data["month"] }}',@endforeach],
                datasets: [{
                    label: 'Ganhos',
                    data: [@foreach($report as $data){{ $data["earn"]/100 }},@endforeach],
                    backgroundColor: 'rgba(34, 197, 94, 0.6)',
                    borderColor: 'rgba(34, 197, 94, 1)',
                    borderWidth: 2
                }, {
                    label: 'Gastos',
                    data: [@foreach($report as $data){{ $data["spent"]/100 }},@endforeach],
                    backgroundColor: 'rgba(239, 68, 68, 0.6)',
                    borderColor: 'rgba(239, 68, 68, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'R$ ' + value.toLocaleString('pt-BR');
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += 'R$ ' + context.parsed.y.toLocaleString('pt-BR', {minimumFractionDigits: 2});
                                return label;
                            }
                        }
                    }
                }
            }
        });

        // Resultado Mensal
        const ctxMonthlyResult = document.getElementById('monthlyResultChart');
        new Chart(ctxMonthlyResult, {
            type: 'bar',
            data: {
                labels: [@foreach($report as $data)'{{ $data["month_name"] ?? $data["month"] }}',@endforeach],
                datasets: [{
                    label: 'Resultado (Ganhos - Gastos)',
                    data: [@foreach($report as $data){{ ($data["earn"] - $data["spent"])/100 }},@endforeach],
                    backgroundColor: [
                        @foreach($report as $data)
                        '{{ ($data["earn"] - $data["spent"]) >= 0 ? "rgba(34, 197, 94, 0.6)" : "rgba(239, 68, 68, 0.6)" }}',
                        @endforeach
                    ],
                    borderColor: [
                        @foreach($report as $data)
                        '{{ ($data["earn"] - $data["spent"]) >= 0 ? "rgba(34, 197, 94, 1)" : "rgba(239, 68, 68, 1)" }}',
                        @endforeach
                    ],
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
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'R$ ' + context.parsed.y.toLocaleString('pt-BR', {minimumFractionDigits: 2});
                            }
                        }
                    }
                }
            }
        });

        // Progressão do Saldo
        const ctxBalanceProgression = document.getElementById('balanceProgressionChart');
        new Chart(ctxBalanceProgression, {
            type: 'line',
            data: {
                labels: [@foreach($report as $data)'{{ $data["month_name"] ?? $data["month"] }}',@endforeach],
                datasets: [{
                    label: 'Saldo Acumulado',
                    data: [@foreach($report as $data){{ $data["balanceProgression"]/100 }},@endforeach],
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'R$ ' + value.toLocaleString('pt-BR');
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Saldo: R$ ' + context.parsed.y.toLocaleString('pt-BR', {minimumFractionDigits: 2});
                            }
                        }
                    }
                }
            }
        });
    </script>
    @endif
</x-app-layout>
