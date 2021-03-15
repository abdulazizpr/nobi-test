<?php

namespace App\Repositories;

use App\Models\NetAsset;
use App\Repositories\BaseRepository;

class NetAssetRepository extends BaseRepository
{
    public function __construct(NetAsset $model)
    {
        parent::__construct($model);
    }

    /**
     * Get Last Net Asset
     *
     * @return \Illuminate\Database\Eloquent\Model
    */
    public function getLastNetAsset()
    {
        return $this->model
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * Update Balance
     *
     * @return \Illuminate\Database\Eloquent\Model
    */
    public function updateBalance($request)
    {
        $model = $this->model;

        $userRepo = app(UserRepository::class);
        $totalUnit = $userRepo->getTotalUnit();

        $model->nab = 1;
        if ($totalUnit > 0) {
            $model->nab = round($request->current_amount / $totalUnit, 4, PHP_ROUND_HALF_DOWN);
        }

        $model->current_amount = $request->current_amount;
        $model->save();

        return $model;
    }
}
