<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feed extends Model
{
    use HasFactory;

    /**
     * A tabela associada ao modelo
     *
     * @var string
     */
    protected $table = 'feed';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
        'value',
        'envelope_id',
        'user_id',
        'valid_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'value' => 'integer',
            'type' => 'integer',
            'valid_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Constantes para os tipos de transação
     */
    const TYPE_BALANCE_EARNING = 1;   // Ganho no saldo
    const TYPE_ENVELOPE_EARNING = 2;  // Aplicação em envelope
    const TYPE_BALANCE_EXPENSE = 3;   // Despesa no saldo
    const TYPE_ENVELOPE_EXPENSE = 4;  // Despesa no envelope

    /**
     * Relacionamento: Uma transação pertence a um usuário
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento: Uma transação pode pertencer a um envelope
     */
    public function envelope(): BelongsTo
    {
        return $this->belongsTo(Envelope::class);
    }

    /**
     * Scope: Apenas transações do usuário autenticado
     */
    public function scopeOwned($query)
    {
        return $query->where('user_id', auth()->id());
    }

    /**
     * Scope: Filtra por tipo de transação
     */
    public function scopeOfType($query, int $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope: Filtra por envelope
     */
    public function scopeForEnvelope($query, int $envelopeId)
    {
        return $query->where('envelope_id', $envelopeId);
    }

    /**
     * Scope: Filtra transações de um período específico
     */
    public function scopeInPeriod($query, Carbon $start, Carbon $end)
    {
        return $query->whereBetween('valid_at', [$start, $end]);
    }

    /**
     * Scope: Filtra transações de um mês/ano específico
     */
    public function scopeInMonth($query, int $month, int $year)
    {
        return $query->whereMonth('valid_at', $month)
                    ->whereYear('valid_at', $year);
    }

    /**
     * Scope: Apenas ganhos (tipos 1 e 2)
     */
    public function scopeEarnings($query)
    {
        return $query->whereIn('type', [self::TYPE_BALANCE_EARNING, self::TYPE_ENVELOPE_EARNING]);
    }

    /**
     * Scope: Apenas despesas (tipos 3 e 4)
     */
    public function scopeExpenses($query)
    {
        return $query->whereIn('type', [self::TYPE_BALANCE_EXPENSE, self::TYPE_ENVELOPE_EXPENSE]);
    }

    /**
     * Accessor: Retorna o valor formatado
     */
    public function getFormattedValueAttribute(): string
    {
        return number_format($this->value / 100, 2, ',', ' ');
    }

    /**
     * Verifica se é um ganho
     */
    public function isEarning(): bool
    {
        return in_array($this->type, [self::TYPE_BALANCE_EARNING, self::TYPE_ENVELOPE_EARNING]);
    }

    /**
     * Verifica se é uma despesa
     */
    public function isExpense(): bool
    {
        return in_array($this->type, [self::TYPE_BALANCE_EXPENSE, self::TYPE_ENVELOPE_EXPENSE]);
    }

    /**
     * Retorna a descrição do tipo de transação
     */
    public function getTypeDescription(): string
    {
        return match($this->type) {
            self::TYPE_BALANCE_EARNING => 'Ganho no saldo',
            self::TYPE_ENVELOPE_EARNING => 'Aplicação em envelope',
            self::TYPE_BALANCE_EXPENSE => 'Despesa no saldo',
            self::TYPE_ENVELOPE_EXPENSE => 'Despesa no envelope',
            default => 'Desconhecido'
        };
    }
}
