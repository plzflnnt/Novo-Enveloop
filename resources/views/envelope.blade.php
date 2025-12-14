<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="mb-6">
                <a href="{{ route('home') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 mb-4">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Voltar ao Dashboard
                </a>
                
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="mb-4 md:mb-0">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $envelope->name }}</h1>
                            <p class="text-sm text-gray-600">Envelope de controle financeiro</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600 mb-1">Saldo atual</p>
                            <p class="text-4xl font-bold {{ $balanceInCents < 0 ? 'text-red-600' : 'text-green-600' }}">
                                R$ {{ $balance }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-2 mt-6">
                        <button onclick="openModal('envelopeEarningModalPage')" class="flex-1 md:flex-none inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition">
                            <i class="fas fa-arrow-up mr-2"></i>
                            Investir
                        </button>
                        <button onclick="openModal('envelopeExpenseModalPage')" class="flex-1 md:flex-none inline-flex items-center justify-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-md transition">
                            <i class="fas fa-arrow-down mr-2"></i>
                            Despesa
                        </button>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Investido</p>
                            <p class="text-2xl font-bold text-blue-600">R$ {{ $totalInvested ?? '0,00' }}</p>
                        </div>
                        <i class="fas fa-arrow-up text-3xl text-blue-200"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Gasto</p>
                            <p class="text-2xl font-bold text-red-600">R$ {{ $totalSpent ?? '0,00' }}</p>
                        </div>
                        <i class="fas fa-arrow-down text-3xl text-red-200"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Transações</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $feed->total() ?? 0 }}</p>
                        </div>
                        <i class="fas fa-receipt text-3xl text-gray-200"></i>
                    </div>
                </div>
            </div>

            <!-- Transactions -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Transações</h2>
                
                @if(count($feed) > 0)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tipo
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Descrição
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Valor
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                        Data
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($feed as $transaction)
                                <tr class="hover:bg-gray-50 transition">
                                    <!-- Tipo -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($transaction->type == 2)
                                            <div class="flex items-center">
                                                <i class="fas fa-circle text-blue-600"></i>
                                                <span class="ml-2 text-xs text-gray-500 hidden lg:inline">Aplicação</span>
                                            </div>
                                        @else
                                            <div class="flex items-center">
                                                <i class="fas fa-arrow-down text-red-600 text-lg"></i>
                                                <span class="ml-2 text-xs text-gray-500 hidden lg:inline">Despesa</span>
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Descrição -->
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $transaction->name }}
                                        </div>
                                        @if($transaction->type == 2)
                                            <div class="text-xs text-gray-500 italic">Investimento no envelope</div>
                                        @endif
                                    </td>

                                    <!-- Valor -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-semibold {{ $transaction->type == 2 ? 'text-blue-600' : 'text-red-600' }}">
                                            R$ {{ format_currency($transaction->value) }}
                                        </span>
                                    </td>

                                    <!-- Data -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                                        {{ $transaction->valid_at->format('d/m/Y') }}
                                        <div class="text-xs text-gray-400">{{ $transaction->valid_at->format('H:i') }}</div>
                                    </td>

                                    <!-- Ações -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <button onclick="confirmDelete({{ $transaction->id }}, '{{ $transaction->name }}', '{{ format_currency($transaction->value) }}')" 
                                                class="text-red-600 hover:text-red-800" 
                                                title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 bg-gray-50">
                        {{ $feed->links() }}
                    </div>
                </div>
                @else
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <i class="fas fa-receipt text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Nenhuma transação ainda</h3>
                    <p class="text-gray-600 mb-6">Comece clicando em "Investir" para adicionar dinheiro a este envelope.</p>
                    <button onclick="openModal('envelopeEarningModalPage')" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition">
                        <i class="fas fa-arrow-up mr-2"></i>
                        Investir Agora
                    </button>
                </div>
                @endif
            </div>

            <!-- Charts -->
            @if(count($feed) > 0 && isset($report))
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Chart 1: Ganhos vs Gastos -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Investimentos vs Gastos</h3>
                    <canvas id="envelopeChart"></canvas>
                </div>

                <!-- Chart 2: Progressão do Saldo -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Progressão do Saldo</h3>
                    <canvas id="balanceProgressionChart"></canvas>
                </div>
            </div>
            @endif

        </div>
    </div>

    <!-- Modals -->
    <div id="envelopeEarningModalPage" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Investir em {{ $envelope->name }}</h3>
                <button onclick="closeModal('envelopeEarningModalPage')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('earning.create') }}" class="space-y-4">
                @csrf
                
                <div>
                    <p class="text-sm text-gray-600 mb-2">Aplicar dinheiro do saldo ao envelope.</p>
                    <p class="text-sm text-gray-500">Seu saldo não alocado: <span class="font-semibold {{ $userBalanceInCents < 0 ? 'text-red-600' : 'text-green-600' }}">R$ {{ $userBalance }}</span></p>
                </div>

                <input type="hidden" name="name" value="Aplicação ao envelope">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Valor</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-gray-500">R$</span>
                        <input 
                            type="text" 
                            name="value" 
                            placeholder="0,00" 
                            required 
                            class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            oninput="formatCurrency(this)"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data (opcional)</label>
                    <input 
                        type="date" 
                        name="valid_at" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                <input type="hidden" name="envelope_id" value="{{ $envelope->id }}">

                <div class="flex gap-2 pt-4">
                    <button type="button" onclick="closeModal('envelopeEarningModalPage')" class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-md transition">
                        Cancelar
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition">
                        <i class="fas fa-arrow-up mr-2"></i>
                        Aplicar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="envelopeExpenseModalPage" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Despesa em {{ $envelope->name }}</h3>
                <button onclick="closeModal('envelopeExpenseModalPage')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('expense.create') }}" class="space-y-4">
                @csrf
                
                <div>
                    <p class="text-sm text-gray-600 mb-4">Adicionar um gasto ao envelope.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                    <input 
                        type="text" 
                        name="name" 
                        placeholder="Ex: Compras do mês..." 
                        required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Valor</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-gray-500">R$</span>
                        <input 
                            type="text" 
                            name="value" 
                            placeholder="0,00" 
                            required 
                            class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            oninput="formatCurrency(this)"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data (opcional)</label>
                    <input 
                        type="date" 
                        name="valid_at" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                <input type="hidden" name="envelope_id" value="{{ $envelope->id }}">

                <div class="flex gap-2 pt-4">
                    <button type="button" onclick="closeModal('envelopeExpenseModalPage')" class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-md transition">
                        Cancelar
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-md transition">
                        <i class="fas fa-plus mr-2"></i>
                        Adicionar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Confirmar Exclusão</h3>
                <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-4">Deseja realmente excluir esta transação?</p>
                <div class="bg-gray-50 border border-gray-200 rounded-md p-3">
                    <p class="text-sm font-medium text-gray-900" id="deleteItemName"></p>
                    <p class="text-sm text-gray-600" id="deleteItemValue"></p>
                </div>
                <p class="text-xs text-red-600 mt-2">⚠️ Esta ação não pode ser desfeita.</p>
            </div>

            <div class="flex gap-2">
                <button onclick="closeDeleteModal()" class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-md transition">
                    Cancelar
                </button>
                <a href="#" id="deleteConfirmBtn" class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-md text-center transition">
                    Excluir
                </a>
            </div>
        </div>
    </div>

    <script>
        // Mapping of visible transaction IDs to their encrypted values
        const ENCRYPTED_FEED_IDS = @json(collect($feed->items())->mapWithKeys(function($t) { return [$t->id => Crypt::encryptString($t->id)]; })->toArray());

        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function formatCurrency(input) {
            let value = input.value.replace(/\D/g, '');
            value = (value / 100).toFixed(2);
            input.value = value.replace('.', ',').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
        }

        function confirmDelete(id, name, value) {
            document.getElementById('deleteItemName').textContent = name;
            document.getElementById('deleteItemValue').textContent = 'R$ ' + value;
            
            /*
            TODO: a correção aplicada à criptografia dos IDs das transações deve ser revista. pois tem um backup com bota()
            que não é compatível com Laravel Crypt::...
            */
            // Use encrypted id from the mapping when available, fallback to btoa(id)
            const encrypted = ENCRYPTED_FEED_IDS[id] ?? null;
            const idForRoute = encrypted ? encrypted : btoa(id);
            const deleteUrl = "{{ route('undo-earning', ['id' => ':id']) }}".replace(':id', idForRoute);
            document.getElementById('deleteConfirmBtn').href = deleteUrl;
            
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Charts
        @if(count($feed) > 0 && isset($report))
        const ctxEnvelope = document.getElementById('envelopeChart');
        if (ctxEnvelope) {
            new Chart(ctxEnvelope, {
                type: 'bar',
                data: {
                    labels: [@foreach(array_slice($report, -6) as $data)'{{ $data["month"] ?? "Mês" }}',@endforeach],
                    datasets: [{
                        label: 'Investimentos',
                        data: [@foreach(array_slice($report, -6) as $data){{ $data["earn"]/100 }},@endforeach],
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderColor: 'rgba(59, 130, 246, 1)',
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

        const ctxProgression = document.getElementById('balanceProgressionChart');
        if (ctxProgression) {
            new Chart(ctxProgression, {
                type: 'line',
                data: {
                    labels: [@foreach(array_slice($report, -6) as $data)'{{ $data["month"] ?? "Mês" }}',@endforeach],
                    datasets: [{
                        label: 'Saldo',
                        data: [@foreach(array_slice($report, -6) as $data){{ $data["balanceProgression"]/100 }},@endforeach],
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        borderColor: 'rgba(34, 197, 94, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
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
        @endif
    </script>
</x-app-layout>
