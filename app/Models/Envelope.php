<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Envelope extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Relacionamento: Um envelope pertence a um usuário
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento: Um envelope tem muitas transações (feed)
     */
    public function feeds(): HasMany
    {
        return $this->hasMany(Feed::class);
    }

    /**
     * Scope: Apenas envelopes do usuário autenticado
     */
    public function scopeOwned($query)
    {
        return $query->where('user_id', auth()->id());
    }

    /**
     * Accessor: Retorna o saldo formatado do envelope
     * 
     * @return string
     */
    public function getBalanceAttribute(): string
    {
        $earnings = $this->feeds()
            ->where('type', 2) // Envelope earnings
            ->sum('value');

        $expenses = $this->feeds()
            ->where('type', 4) // Envelope expenses
            ->sum('value');

        $balance = $earnings - $expenses;
        
        return number_format($balance / 100, 2, ',', ' ');
    }

    /**
     * Retorna o saldo do envelope em centavos (inteiro)
     * 
     * @return int
     */
    public function getBalanceInCents(): int
    {
        $earnings = $this->feeds()
            ->where('type', 2)
            ->sum('value');

        $expenses = $this->feeds()
            ->where('type', 4)
            ->sum('value');

        return $earnings - $expenses;
    }
}
