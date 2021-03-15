<?php

namespace App\Models;

use App\Models\Concerns\OldDateSerializer;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use OldDateSerializer;

    const TOPUP = 'topup';
    const WITHDRAW = 'withdraw';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var string[]
    */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'unit_value',
        'total_unit_value',
        'total_balance',
    ];

    /**
     * Transaction belongs to User
     *
     * @return BelongsTo
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}