<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashClosure extends Model
{
    /**
     * Campos que se pueden rellenar de forma masiva.
     */
    protected $fillable = [
        'cash_date',
        'opening_amount',
        'closing_amount',
        'status',
        'opened_by',
        'closed_by',
        'closed_at',
        'notes',
    ];

    /**
     * Convierte automáticamente estos campos a tipos útiles.
     */
    protected $casts = [
        'cash_date' => 'date',
        'closed_at' => 'datetime',
        'opening_amount' => 'decimal:2',
        'closing_amount' => 'decimal:2',
    ];

    /**
     * Movimientos registrados en esta caja diaria.
     */
    public function movements(): HasMany
    {
        return $this->hasMany(CashMovement::class);
    }

    /**
     * Admin que abrió la caja.
     */
    public function openedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'opened_by');
    }

    /**
     * Admin que cerró la caja.
     */
    public function closedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'closed_by');
    }
}