<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashMovement extends Model
{
    /**
     * Campos que se pueden rellenar desde formularios/controladores.
     */
    protected $fillable = [
        'cash_closure_id',
        'user_id',
        'created_by',
        'type',
        'category',
        'payment_method',
        'description',
        'amount',
        'notes',
        'stripe_payment_id',
        'stripe_status',
        'stripe_metadata',
    ];

    /**
     * Conversión automática del importe.
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'stripe_metadata' => 'array',
    ];

    /**
     * Caja diaria a la que pertenece el movimiento.
     */
    public function cashClosure(): BelongsTo
    {
        return $this->belongsTo(CashClosure::class);
    }

    /**
     * Cliente relacionado con el movimiento, si existe.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Admin que creó el movimiento.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}