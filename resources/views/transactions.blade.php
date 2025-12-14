<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Todas as Transações</h1>
                        <p class="mt-1 text-sm text-gray-600">Histórico completo de ganhos e despesas</p>
                    </div>
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-md transition">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Voltar
                    </a>
                </div>
            </div>

            <!-- Transactions Table -->
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
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                    Envelope
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
                                    @if($transaction->type == 1)
                                        <div class="flex items-center">
                                            <i class="fas fa-arrow-up text-green-600 text-lg"></i>
                                            <span class="ml-2 text-xs text-gray-500 hidden lg:inline">Ganho</span>
                                        </div>
                                    @elseif($transaction->type == 2)
                                        <div class="flex items-center">
                                            <i class="fas fa-circle text-blue-600"></i>
                                            <span class="ml-2 text-xs text-gray-500 hidden lg:inline">Aplicação</span>
                                        </div>
                                    @elseif($transaction->type == 3)
                                        <div class="flex items-center">
                                            <i class="fas fa-arrow-down text-red-600 text-lg"></i>
                                            <span class="ml-2 text-xs text-gray-500 hidden lg:inline">Despesa</span>
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
                                        <div class="text-xs text-gray-500 italic">Aplicação em envelope</div>
                                    @endif
                                </td>

                                <!-- Envelope -->
                                <td class="px-6 py-4 text-sm text-gray-500 hidden sm:table-cell">
                                    @if(isset($transaction->envelope_name) && $transaction->envelope_id != 1)
                                        <a href="{{ route('envelope.show', ['id' => encrypt($transaction->envelope_id)]) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                            {{ $transaction->envelope_name }}
                                        </a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>

                                <!-- Valor -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold {{ $transaction->type == 1 || $transaction->type == 2 ? 'text-green-600' : 'text-red-600' }}">
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
                                    <div class="flex items-center gap-2">
                                        @if($transaction->envelope_id != 1 && isset($transaction->envelope_id))
                                            <a href="{{ route('envelope.show', ['id' => encrypt($transaction->envelope_id)]) }}" 
                                               class="text-blue-600 hover:text-blue-800" 
                                               title="Ver envelope">
                                                <i class="fas fa-share"></i>
                                            </a>
                                        @endif
                                        <button onclick="confirmDelete({{ $transaction->id }}, '{{ $transaction->name }}', '{{ format_currency($transaction->value) }}')" 
                                                class="text-red-600 hover:text-red-800" 
                                                title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
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
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Nenhuma transação encontrada</h3>
                <p class="text-gray-600 mb-6">Comece adicionando ganhos ou despesas para vê-los aqui.</p>
                <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Voltar ao Dashboard
                </a>
            </div>
            @endif

        </div>
    </div>

    <!-- Delete Confirmation Modal -->
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
    </script>
</x-app-layout>
