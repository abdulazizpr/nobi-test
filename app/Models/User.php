<?php

namespace App\Models;

use App\Models\Concerns\OldDateSerializer;
use App\Models\Transaction;
use App\Repositories\NetAssetRepository;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use OldDateSerializer;
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var string[]
    */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'total_unit',
    ];

    /**
     * User has many Transactions
     *
     * @return HasMany
    */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get Total Balance Attribute
     *
     * @return float
    */
    public function getTotalBalanceAttribute(): float
    {
        return round($this->current_nab * $this->total_unit, 4, PHP_ROUND_HALF_DOWN);
    }

    /**
     * Get Current Balance Attribute
     *
     * @return float
    */
    public function getCurrentNabAttribute(): float
    {
        $netAsset = app(NetAssetRepository::class)->getLastNetAsset();

        return $netAsset->nab ?? 0;
    }
}