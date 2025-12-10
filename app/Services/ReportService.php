<?php

namespace App\Services;

use App\Models\Envelope;
use App\Models\Feed;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportService
{
    /**
     * Gera relatório mensal de ganhos e gastos
     *
     * @param int $userId ID do usuário
     * @param Carbon $startDate Data inicial
     * @param int $monthsCount Quantidade de meses
     * @param int|null $envelopeId ID do envelope (null para todos)
     * @return array
     */
    public function generateMonthlyReport(
        int $userId,
        Carbon $startDate,
        int $monthsCount,
        ?int $envelopeId = null
    ): array {
        $dataArray = [];
        $currentDate = $startDate->copy();

        for ($i = 0; $i < $monthsCount; $i++) {
            $balanceSpent = 0;
            $balanceEarn = 0;

            if ($envelopeId === null) {
                // Relatório geral de todos os envelopes
                $feeds = Feed::where('user_id', $userId)
                    ->whereMonth('valid_at', $currentDate->month)
                    ->whereYear('valid_at', $currentDate->year)
                    ->get();

                foreach ($feeds as $feed) {
                    if ($feed->type == Feed::TYPE_BALANCE_EARNING) {
                        $balanceEarn += $feed->value;
                    } elseif (in_array($feed->type, [Feed::TYPE_BALANCE_EXPENSE, Feed::TYPE_ENVELOPE_EXPENSE])) {
                        $balanceSpent += $feed->value;
                    }
                }

                // Calcula progressão do saldo até o fim do mês
                $endOfMonth = $currentDate->copy()->endOfMonth();
                $balanceProgression = $this->calculateBalanceProgression($userId, $endOfMonth, null);

            } else {
                // Relatório de um envelope específico
                $feeds = Feed::where('envelope_id', $envelopeId)
                    ->whereMonth('valid_at', $currentDate->month)
                    ->whereYear('valid_at', $currentDate->year)
                    ->get();

                foreach ($feeds as $feed) {
                    if ($feed->type == Feed::TYPE_ENVELOPE_EARNING) {
                        $balanceEarn += $feed->value;
                    } elseif ($feed->type == Feed::TYPE_ENVELOPE_EXPENSE) {
                        $balanceSpent += $feed->value;
                    }
                }

                // Calcula progressão do saldo até o fim do mês
                $endOfMonth = $currentDate->copy()->endOfMonth();
                $balanceProgression = $this->calculateBalanceProgression($userId, $endOfMonth, $envelopeId);
            }

            $dataArray[] = [
                'spent' => $balanceSpent,
                'earn' => $balanceEarn,
                'month' => $currentDate->month,
                'year' => $currentDate->year,
                'month_name' => $currentDate->translatedFormat('M/Y'),
                'balanceProgression' => $balanceProgression,
            ];

            $currentDate->subMonth();
        }

        return array_reverse($dataArray);
    }

    /**
     * Calcula a progressão do saldo até uma data específica
     *
     * @param int $userId ID do usuário
     * @param Carbon $untilDate Data limite
     * @param int|null $envelopeId ID do envelope (null para todos)
     * @return int Saldo em centavos
     */
    private function calculateBalanceProgression(
        int $userId,
        Carbon $untilDate,
        ?int $envelopeId = null
    ): int {
        $query = Feed::where('user_id', $userId)
            ->where('valid_at', '<=', $untilDate);

        if ($envelopeId !== null) {
            $query->where('envelope_id', $envelopeId);
        }

        $feeds = $query->get();
        $balance = 0;

        foreach ($feeds as $feed) {
            if ($envelopeId === null) {
                // Cálculo para relatório geral
                if ($feed->type == Feed::TYPE_BALANCE_EARNING) {
                    $balance += $feed->value;
                } elseif (in_array($feed->type, [Feed::TYPE_BALANCE_EXPENSE, Feed::TYPE_ENVELOPE_EXPENSE])) {
                    $balance -= $feed->value;
                }
            } else {
                // Cálculo para envelope específico
                if ($feed->type == Feed::TYPE_ENVELOPE_EARNING) {
                    $balance += $feed->value;
                } elseif ($feed->type == Feed::TYPE_ENVELOPE_EXPENSE) {
                    $balance -= $feed->value;
                }
            }
        }

        return $balance;
    }

    /**
     * Gera dados para o gráfico de divisão de dinheiro entre envelopes
     *
     * @param int $userId ID do usuário
     * @return array
     */
    public function generateEnvelopeDivisionData(int $userId): array
    {
        $balanceService = new BalanceService();
        $unallocated = $balanceService->calculateUnallocatedBalance($userId);

        $envelopes = Envelope::where('user_id', $userId)->get();

        $data = [
            'labels' => ['Saldo não alocado'],
            'values' => [$unallocated['balance_in_cents'] / 100], // Convertendo para reais
        ];

        foreach ($envelopes as $envelope) {
            $data['labels'][] = $envelope->name;
            $data['values'][] = $envelope->getBalanceInCents() / 100;
        }

        return $data;
    }

    /**
     * Retorna transações recentes do usuário
     *
     * @param int $userId ID do usuário
     * @param int $limit Quantidade de transações
     * @param int|null $envelopeId ID do envelope (null para todos)
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getRecentTransactions(int $userId, int $limit = 5, ?int $envelopeId = null)
    {
        $query = Feed::where('feed.user_id', $userId)
            ->join('envelopes', 'feed.envelope_id', '=', 'envelopes.id')
            ->select('feed.*', 'envelopes.name as envelope_name', 'envelopes.id as envelope_id')
            ->orderBy('valid_at', 'desc');

        if ($envelopeId !== null) {
            $query->where('feed.envelope_id', $envelopeId);
        }

        if ($limit > 0) {
            return $query->limit($limit)->get();
        }

        return $query->paginate(30);
    }
}
