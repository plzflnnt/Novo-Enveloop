<?php

namespace App\Services;

use App\Helpers\CurrencyHelper;
use App\Models\Envelope;
use App\Models\Feed;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EnvelopeService
{
    /**
     * Cria um novo envelope para o usuário
     *
     * @param int $userId ID do usuário
     * @param string $name Nome do envelope
     * @return Envelope
     */
    public function createEnvelope(int $userId, string $name): Envelope
    {
        return Envelope::create([
            'name' => $name,
            'user_id' => $userId,
        ]);
    }

    /**
     * Aplica dinheiro do saldo em um envelope
     *
     * @param int $userId ID do usuário
     * @param int $envelopeId ID do envelope
     * @param int $valueInCents Valor em centavos
     * @param Carbon|null $validAt Data da transação
     * @return Feed
     */
    public function applyToEnvelope(
        int $userId,
        int $envelopeId,
        int $valueInCents,
        ?Carbon $validAt = null
    ): Feed {
        return Feed::create([
            'name' => 'Aplicação ao envelope',
            'type' => Feed::TYPE_ENVELOPE_EARNING,
            'value' => $valueInCents,
            'envelope_id' => $envelopeId,
            'user_id' => $userId,
            'valid_at' => $validAt ?? Carbon::now(),
        ]);
    }

    /**
     * Registra uma despesa em um envelope
     *
     * @param int $userId ID do usuário
     * @param int $envelopeId ID do envelope
     * @param string $description Descrição da despesa
     * @param int $valueInCents Valor em centavos
     * @param Carbon|null $validAt Data da transação
     * @return Feed
     */
    public function addExpenseToEnvelope(
        int $userId,
        int $envelopeId,
        string $description,
        int $valueInCents,
        ?Carbon $validAt = null
    ): Feed {
        return Feed::create([
            'name' => $description,
            'type' => Feed::TYPE_ENVELOPE_EXPENSE,
            'value' => $valueInCents,
            'envelope_id' => $envelopeId,
            'user_id' => $userId,
            'valid_at' => $validAt ?? Carbon::now(),
        ]);
    }

    /**
     * Registra um ganho no saldo
     *
     * @param int $userId ID do usuário
     * @param string $description Descrição do ganho
     * @param int $valueInCents Valor em centavos
     * @param Carbon|null $validAt Data da transação
     * @return Feed
     */
    public function addBalanceEarning(
        int $userId,
        string $description,
        int $valueInCents,
        ?Carbon $validAt = null
    ): Feed {
        return Feed::create([
            'name' => $description,
            'type' => Feed::TYPE_BALANCE_EARNING,
            'value' => $valueInCents,
            'envelope_id' => 1, // ID especial para saldo
            'user_id' => $userId,
            'valid_at' => $validAt ?? Carbon::now(),
        ]);
    }

    /**
     * Registra uma despesa no saldo
     *
     * @param int $userId ID do usuário
     * @param string $description Descrição da despesa
     * @param int $valueInCents Valor em centavos
     * @param Carbon|null $validAt Data da transação
     * @return Feed
     */
    public function addBalanceExpense(
        int $userId,
        string $description,
        int $valueInCents,
        ?Carbon $validAt = null
    ): Feed {
        return Feed::create([
            'name' => $description,
            'type' => Feed::TYPE_BALANCE_EXPENSE,
            'value' => $valueInCents,
            'envelope_id' => 1, // ID especial para saldo
            'user_id' => $userId,
            'valid_at' => $validAt ?? Carbon::now(),
        ]);
    }

    /**
     * Remove (soft delete) uma transação
     *
     * @param int $feedId ID da transação
     * @param int $userId ID do usuário (verificação de ownership)
     * @return bool
     */
    public function deleteTransaction(int $feedId, int $userId): bool
    {
        $feed = Feed::where('id', $feedId)
            ->where('user_id', $userId)
            ->first();

        if (!$feed) {
            return false;
        }

        return $feed->delete();
    }

    /**
     * Lista todos os envelopes do usuário com seus saldos
     *
     * @param int $userId ID do usuário
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserEnvelopesWithBalance(int $userId)
    {
        $envelopes = Envelope::where('user_id', $userId)->get();

        foreach ($envelopes as $envelope) {
            $envelope->balance_in_cents = $envelope->getBalanceInCents();
            $envelope->balance_formatted = $envelope->balance;
        }

        return $envelopes;
    }
}
