<?php

namespace App\Http\Controllers;

use App\Services\BalanceService;
use App\Services\EnvelopeService;
use App\Services\ReportService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private BalanceService $balanceService,
        private EnvelopeService $envelopeService,
        private ReportService $reportService
    ) {
        // No Laravel 11, o middleware é aplicado nas rotas (web.php)
        // Não precisa mais do $this->middleware('auth')
    }

    /**
     * Exibe a página inicial (dashboard)
     *
     * @return View
     */
    public function index(): View
    {
        $userId = auth()->id();

        // Busca estatísticas gerais
        $statistics = $this->balanceService->getUserStatistics($userId);

        // Busca envelopes com saldos
        $envelopes = $this->envelopeService->getUserEnvelopesWithBalance($userId);

        // Busca transações recentes
        $recentTransactions = $this->reportService->getRecentTransactions($userId, 5);

        // Gera relatório dos últimos 13 meses
        $monthlyReport = $this->reportService->generateMonthlyReport(
            $userId,
            Carbon::now(),
            13,
            null
        );

        return view('home', [
            'balance' => $statistics['unallocated_balance']['balance_formatted'],
            'balanceInCents' => $statistics['unallocated_balance']['balance_in_cents'],
            'grandBalance' => $statistics['total_balance']['balance_formatted'],
            'grandBalanceInCents' => $statistics['total_balance']['balance_in_cents'],
            'envelopes' => $envelopes,
            'envelopeNegative' => $statistics['has_negative_envelopes'],
            'feed' => $recentTransactions,
            'report' => $monthlyReport,
        ]);
    }
}
