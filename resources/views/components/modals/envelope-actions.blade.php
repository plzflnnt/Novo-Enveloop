<!-- Modals dinâmicos de envelope (abertos via JavaScript) -->
<div id="envelopeEarningModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900" id="envelopeEarningTitle">Investir em Envelope</h3>
            <button onclick="closeModal('envelopeEarningModal')" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('earning.create') }}" class="space-y-4">
            @csrf
            
            <div>
                <p class="text-sm text-gray-600 mb-2">Aplicar dinheiro do saldo ao envelope.</p>
                <p class="text-sm text-gray-500">Seu saldo não alocado: <span class="font-semibold {{ $balanceInCents < 0 ? 'text-red-600' : 'text-green-600' }}">R$ {{ $balance }}</span></p>
            </div>

            <input type="hidden" name="name" value="Aplicação ao envelope">

            <div>
                <label for="envelope_earning_value" class="block text-sm font-medium text-gray-700 mb-1">Valor</label>
                <div class="relative">
                    <span class="absolute left-3 top-2 text-gray-500">R$</span>
                    <input 
                        type="text" 
                        id="envelope_earning_value" 
                        name="value" 
                        placeholder="0,00" 
                        required 
                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        oninput="formatCurrency(this)"
                    >
                </div>
            </div>

            <div>
                <label for="envelope_earning_date" class="block text-sm font-medium text-gray-700 mb-1">Data (opcional)</label>
                <input 
                    type="date" 
                    id="envelope_earning_date" 
                    name="valid_at" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <input type="hidden" name="envelope_id" id="envelope_earning_id" value="">

            <div class="flex gap-2 pt-4">
                <button type="button" onclick="closeModal('envelopeEarningModal')" class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-md transition">
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

<div id="envelopeExpenseModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900" id="envelopeExpenseTitle">Despesa em Envelope</h3>
            <button onclick="closeModal('envelopeExpenseModal')" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('expense.create') }}" class="space-y-4">
            @csrf
            
            <div>
                <p class="text-sm text-gray-600 mb-4">Adicionar um gasto ao envelope.</p>
            </div>

            <div>
                <label for="envelope_expense_name" class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                <input 
                    type="text" 
                    id="envelope_expense_name" 
                    name="name" 
                    placeholder="Ex: Compras do mês..." 
                    required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div>
                <label for="envelope_expense_value" class="block text-sm font-medium text-gray-700 mb-1">Valor</label>
                <div class="relative">
                    <span class="absolute left-3 top-2 text-gray-500">R$</span>
                    <input 
                        type="text" 
                        id="envelope_expense_value" 
                        name="value" 
                        placeholder="0,00" 
                        required 
                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        oninput="formatCurrency(this)"
                    >
                </div>
            </div>

            <div>
                <label for="envelope_expense_date" class="block text-sm font-medium text-gray-700 mb-1">Data (opcional)</label>
                <input 
                    type="date" 
                    id="envelope_expense_date" 
                    name="valid_at" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <input type="hidden" name="envelope_id" id="envelope_expense_id" value="">

            <div class="flex gap-2 pt-4">
                <button type="button" onclick="closeModal('envelopeExpenseModal')" class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-md transition">
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

<script>
    function openEnvelopeModal(type, envelopeId) {
        if (type === 'earning') {
            document.getElementById('envelope_earning_id').value = envelopeId;
            openModal('envelopeEarningModal');
        } else {
            document.getElementById('envelope_expense_id').value = envelopeId;
            openModal('envelopeExpenseModal');
        }
    }
</script>
