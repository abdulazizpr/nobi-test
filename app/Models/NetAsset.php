<?php

namespace App\Models;

use App\Models\Concerns\OldDateSerializer;
use Illuminate\Database\Eloquent\Model;

class NetAsset extends Model
{
    use OldDateSerializer;

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
        'nab',
        'current_amount',
    ];
}