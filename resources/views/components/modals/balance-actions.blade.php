<!-- Modal Ganho no Saldo -->
<div id="balanceModalEarning" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Adicionar Ganho</h3>
            <button onclick="closeModal('balanceModalEarning')" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('earning.create') }}" class="space-y-4">
            @csrf
            <div>
                <p class="text-sm text-gray-600 mb-4">Adicione um ganho ao seu saldo sempre que você receber algum dinheiro.</p>
            </div>

            <div>
                <label for="earning_name" class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                <input 
                    type="text" 
                    id="earning_name" 
                    name="name" 
                    placeholder="Ex: Salário, Freelance..." 
                    required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div>
                <label for="earning_value" class="block text-sm font-medium text-gray-700 mb-1">Valor</label>
                <div class="relative">
                    <span class="absolute left-3 top-2 text-gray-500">R$</span>
                    <input 
                        type="text" 
                        id="earning_value" 
                        name="value" 
                        placeholder="0,00" 
                        required 
                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        oninput="formatCurrency(this)"
                    >
                </div>
            </div>

            <div>
                <label for="earning_date" class="block text-sm font-medium text-gray-700 mb-1">Data (opcional)</label>
                <input 
                    type="date" 
                    id="earning_date" 
                    name="valid_at" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <input type="hidden" name="envelope_id" value="sd">

            <div class="flex gap-2 pt-4">
                <button type="button" onclick="closeModal('balanceModalEarning')" class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-md transition">
                    Cancelar
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition">
                    <i class="fas fa-plus mr-2"></i>
                    Adicionar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Despesa no Saldo -->
<div id="balanceModalExpense" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Adicionar Despesa ao Saldo</h3>
            <button onclick="closeModal('balanceModalExpense')" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('expense.create') }}" class="space-y-4">
            @csrf
            <div>
                <p class="text-sm text-gray-600 mb-4">
                    Essa despesa não será vinculada a um envelope. Para adicionar uma despesa referente a uma categoria de envelope, clique em "Despesa" dentro do envelope desejado.
                </p>
            </div>

            <div>
                <label for="expense_name" class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                <input 
                    type="text" 
                    id="expense_name" 
                    name="name" 
                    placeholder="Ex: Gasto imprevisto..." 
                    required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div>
                <label for="expense_value" class="block text-sm font-medium text-gray-700 mb-1">Valor</label>
                <div class="relative">
                    <span class="absolute left-3 top-2 text-gray-500">R$</span>
                    <input 
                        type="text" 
                        id="expense_value" 
                        name="value" 
                        placeholder="0,00" 
                        required 
                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        oninput="formatCurrency(this)"
                    >
                </div>
            </div>

            <div>
                <label for="expense_date" class="block text-sm font-medium text-gray-700 mb-1">Data (opcional)</label>
                <input 
                    type="date" 
                    id="expense_date" 
                    name="valid_at" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <input type="hidden" name="envelope_id" value="sd">

            <div class="flex gap-2 pt-4">
                <button type="button" onclick="closeModal('balanceModalExpense')" class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-md transition">
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
    function formatCurrency(input) {
        let value = input.value.replace(/\D/g, '');
        value = (value / 100).toFixed(2);
        input.value = value.replace('.', ',').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
    }
</script>
