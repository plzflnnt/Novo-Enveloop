<?php

namespace App\Http\Controllers;

use App\Helpers\CurrencyHelper;
use App\Models\Envelope;
use App\Services\BalanceService;
use App\Services\EnvelopeService;
use App\Services\ReportService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class EnvelopeController extends Controller
{
    public function __construct(
        private EnvelopeService $envelopeService,
        private BalanceService $balanceService,
        private ReportService $reportService
    ) {
        // No Laravel 11, o middleware é aplicado nas rotas (web.php)
    }

    /**
     * Cria um novo envelope
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function createEnvelope(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:225',
        ]);

        try {
            $this->envelopeService->createEnvelope(
                auth()->id(),
                $request->name
            );

            return redirect()->back()->with('success', 'Envelope criado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao criar envelope: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erro ao criar envelope.');
        }
    }

    /**
     * Adiciona um ganho (ao saldo ou envelope)
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function createEarning(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:225',
            'value' => 'required|string',
            'envelope_id' => 'required',
            'valid_at' => 'nullable|date',
        ]);

        try {
            $valueInCents = CurrencyHelper::parseCurrency($request->value);
            $validAt = $request->valid_at ? Carbon::parse($request->valid_at) : null;
            $isBalance = ($request->envelope_id === 'sd');

            if ($isBalance) {
                // Ganho no saldo
                $feed = $this->envelopeService->addBalanceEarning(
                    auth()->id(),
                    $request->name,
                    $valueInCents,
                    $validAt
                );

                $message = sprintf(
                    'Você inseriu %s ao seu saldo não alocado. <a href="%s" class="alert-link">Desfazer</a>',
                    CurrencyHelper::formatWithSymbol($valueInCents),
                    route('undo-earning', ['id' => Crypt::encryptString($feed->id)])
                );
            } else {
                // Aplicação em envelope
                $feed = $this->envelopeService->applyToEnvelope(
                    auth()->id(),
                    (int) $request->envelope_id,
                    $valueInCents,
                    $validAt
                );

                $envelope = Envelope::find($request->envelope_id);
                $message = sprintf(
                    'Você inseriu %s ao envelope %s. <a href="%s" class="alert-link">Desfazer</a>',
                    CurrencyHelper::formatWithSymbol($valueInCents),
                    $envelope->name,
                    route('undo-earning', ['id' => Crypt::encryptString($feed->id)])
                );
            }

            return redirect()->back()->with('flash_message', $message);
        } catch (\Exception $e) {
            Log::error('Erro ao criar ganho: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erro ao registrar ganho.');
        }
    }

    /**
     * Adiciona uma despesa (ao saldo ou envelope)
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function createExpense(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:225',
            'value' => 'required|string',
            'envelope_id' => 'required',
            'valid_at' => 'nullable|date',
        ]);

        try {
            $valueInCents = CurrencyHelper::parseCurrency($request->value);
            $validAt = $request->valid_at ? Carbon::parse($request->valid_at) : null;
            $isBalance = ($request->envelope_id === 'sd');

            if ($isBalance) {
                // Despesa no saldo
                $feed = $this->envelopeService->addBalanceExpense(
                    auth()->id(),
                    $request->name,
                    $valueInCents,
                    $validAt
                );

                $message = sprintf(
                    'Você inseriu um gasto de %s ao saldo. <a href="%s" class="alert-link">Desfazer</a>',
                    CurrencyHelper::formatWithSymbol($valueInCents),
                    route('undo-earning', ['id' => Crypt::encryptString($feed->id)])
                );
            } else {
                // Despesa em envelope
                $feed = $this->envelopeService->addExpenseToEnvelope(
                    auth()->id(),
                    (int) $request->envelope_id,
                    $request->name,
                    $valueInCents,
                    $validAt
                );

                $envelope = Envelope::find($request->envelope_id);
                $message = sprintf(
                    'Você inseriu um gasto de %s ao envelope %s. <a href="%s" class="alert-link">Desfazer</a>',
                    CurrencyHelper::formatWithSymbol($valueInCents),
                    $envelope->name,
                    route('undo-earning', ['id' => Crypt::encryptString($feed->id)])
                );
            }

            return redirect()->back()->with('flash_message', $message);
        } catch (\Exception $e) {
            Log::error('Erro ao criar despesa: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erro ao registrar despesa.');
        }
    }

    /**
     * Desfaz (deleta) uma transação
     *
     * @param string $id ID encriptado da transação
     * @return RedirectResponse
     */
    public function undoEarning(string $id): RedirectResponse
    {
        try {
            $feedId = (int) Crypt::decryptString($id);
            
            $feed = \App\Models\Feed::where('id', $feedId)
                ->where('user_id', auth()->id())
                ->first();

            if (!$feed) {
                return redirect()->back()->with('error', 'Transação não encontrada.');
            }

            $deletedName = $feed->name;
            
            $this->envelopeService->deleteTransaction($feedId, auth()->id());

            return redirect()->back()->with('flash_message', "Você apagou <b>{$deletedName}</b>.");
        } catch (\Exception $e) {
            Log::error('Erro ao desfazer transação: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erro ao desfazer transação.');
        }
    }

    /**
     * Exibe todas as transações do usuário
     *
     * @return View
     */
    public function transactions(): View
    {
        $transactions = $this->reportService->getRecentTransactions(auth()->id(), 0);

        return view('transactions', [
            'feed' => $transactions,
        ]);
    }

    /**
     * Exibe detalhes de um envelope específico
     *
     * @param string $id ID encriptado do envelope
     * @return View
     */
    public function envelope(string $id): View
    {
        $envelopeId = (int) Crypt::decrypt($id);
        $envelope = Envelope::where('id', $envelopeId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Transações do envelope
        $transactions = $this->reportService->getRecentTransactions(auth()->id(), 0, $envelopeId);

        // Relatório mensal do envelope
        $report = $this->reportService->generateMonthlyReport(
            auth()->id(),
            Carbon::now(),
            13,
            $envelopeId
        );

        // Saldo do usuário
        $userBalance = $this->balanceService->calculateUnallocatedBalance(auth()->id());

        return view('envelope', [
            'envelope' => $envelope,
            'balance' => $envelope->balance,
            'userBalanceInCents' => $envelope->getBalanceInCents(),
            'balanceInCents' => $envelope->getBalanceInCents(),
            'feed' => $transactions,
            'report' => $report,
            'userBalance' => $userBalance['balance_formatted'],
        ]);
    }

    /**
     * Exibe relatório geral
     *
     * @return View
     */
    public function report(): View
    {
        $report = $this->reportService->generateMonthlyReport(
            auth()->id(),
            Carbon::now(),
            12,
            null
        );

        return view('report', [
            'report' => $report,
        ]);
    }

    /**
     * Exibe changelog
     *
     * @return View
     */
    public function changelog(): View
    {
        return view('changelog');
    }
}