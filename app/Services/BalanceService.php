<?php

namespace App\Services;

use App\Helpers\CurrencyHelper;
use App\Models\Envelope;
use App\Models\Feed;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BalanceService
{
    /**
     * Calcula o saldo não alocado do usuário
     * (ganhos totais - despesas totais - valor alocado em envelopes)
     *
     * @param int $userId ID do usuário
     * @return array ['balance_in_cents' => int, 'balance_formatted' => string]
     */
    public function calculateUnallocatedBalance(int $userId): array
    {
        // Ganhos totais (tipo 1: balance earning)
        $totalEarnings = Feed::where('user_id', $userId)
            ->where('type', Feed::TYPE_BALANCE_EARNING)
            ->sum('value');

        // Despesas totais (tipo 3: balance expense)
        $totalExpenses = Feed::where('user_id', $userId)
            ->where('type', Feed::TYPE_BALANCE_EXPENSE)
            ->sum('value');

        // Total alocado em envelopes (tipo 2: envelope earning)
        $totalAllocated = Feed::where('user_id', $userId)
            ->where('type', Feed::TYPE_ENVELOPE_EARNING)
            ->sum('value');

        $balanceInCents = $totalEarnings - $totalExpenses - $totalAllocated;

        return [
            'balance_in_cents' => $balanceInCents,
            'balance_formatted' => CurrencyHelper::formatCurrency($balanceInCents),
        ];
    }

    /**
     * Calcula o saldo total em mãos do usuário
     * (saldo não alocado + soma de todos os envelopes)
     *
     * @param int $userId ID do usuário
     * @return array ['balance_in_cents' => int, 'balance_formatted' => string]
     */
    public function calculateTotalBalance(int $userId): array
    {
        $unallocated = $this->calculateUnallocatedBalance($userId);
        
        $envelopes = Envelope::where('user_id', $userId)->get();
        $envelopesTotal = 0;

        foreach ($envelopes as $envelope) {
            $envelopesTotal += $envelope->getBalanceInCents();
        }

        $totalInCents = $unallocated['balance_in_cents'] + $envelopesTotal;

        return [
            'balance_in_cents' => $totalInCents,
            'balance_formatted' => CurrencyHelper::formatCurrency($totalInCents),
        ];
    }

    /**
     * Verifica se o usuário tem algum envelope com saldo negativo
     *
     * @param int $userId ID do usuário
     * @return bool
     */
    public function hasNegativeEnvelopes(int $userId): bool
    {
        $envelopes = Envelope::where('user_id', $userId)->get();

        foreach ($envelopes as $envelope) {
            if ($envelope->getBalanceInCents() < 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Retorna estatísticas gerais do usuário
     *
     * @param int $userId ID do usuário
     * @return array
     */
    public function getUserStatistics(int $userId): array
    {
        $unallocated = $this->calculateUnallocatedBalance($userId);
        $total = $this->calculateTotalBalance($userId);
        $hasNegativeEnvelopes = $this->hasNegativeEnvelopes($userId);

        $envelopesCount = Envelope::where('user_id', $userId)->count();

        return [
            'unallocated_balance' => $unallocated,
            'total_balance' => $total,
            'has_negative_envelopes' => $hasNegativeEnvelopes,
            'envelopes_count' => $envelopesCount,
        ];
    }
}
