<!-- Modal Adicionar Envelope -->
<div id="addEnvelopeModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Adicionar Novo Envelope</h3>
            <button onclick="closeModal('addEnvelopeModal')" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('envelope.create') }}" class="space-y-4">
            @csrf
            
            <div>
                <p class="text-sm text-gray-600 mb-4">
                    Adicione um envelope para cada categoria de gastos em sua vida, seja do dia a dia ou para um investimento maior.
                </p>
            </div>

            <div>
                <label for="envelope_name" class="block text-sm font-medium text-gray-700 mb-1">Nome do Envelope</label>
                <input 
                    type="text" 
                    id="envelope_name" 
                    name="name" 
                    placeholder="Ex: Alimentação, Transporte, Lazer..." 
                    required 
                    maxlength="225"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <p class="mt-1 text-xs text-gray-500">Escolha um nome descritivo para a categoria de gasto</p>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-md p-3">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs text-blue-700">
                            <strong>Dica:</strong> Crie envelopes para diferentes áreas como Moradia, Alimentação, Transporte, Saúde, Lazer, Emergências, Poupança, etc.
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex gap-2 pt-4">
                <button type="button" onclick="closeModal('addEnvelopeModal')" class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-md transition">
                    Cancelar
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition">
                    <i class="fas fa-plus mr-2"></i>
                    Criar Envelope
                </button>
            </div>
        </form>
    </div>
</div>
