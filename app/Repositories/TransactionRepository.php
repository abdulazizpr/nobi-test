<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\BaseRepository;
use App\Repositories\NetAssetRepository;
use App\Repositories\UserRepository;

class TransactionRepository extends BaseRepository
{
    public function __construct(Transaction $model)
    {
        parent::__construct($model);
    }

    /**
     * Create Transaction
     *
     * @return \Illuminate\Database\Eloquent\Model
    */
    public function create($request, $type = 'topup')
    {
        $netAssetRepo = app(NetAssetRepository::class);
        $userRepo = app(UserRepository::class);

        $netAsset = $netAssetRepo->getLastNetAsset();
        $user = $userRepo->find($request->user_id);

        $model = $this->model;
        $model->user_id = $request->user_id;
        $model->type = $type;
        $model->amount = $request->amount;
        $model->unit_value = round($model->amount / $netAsset->nab, 4, PHP_ROUND_HALF_DOWN);

        if ($model->type === Transaction::TOPUP) {
            $user->total_unit += $model->unit_value;
        }

        if ($model->type === Transaction::WITHDRAW) {
            $user->total_unit -= $model->unit_value;
        }

        $model->total_unit_value = round($user->total_unit, 4, PHP_ROUND_HALF_DOWN);
        $model->total_balance = round($model->total_unit_value * $netAsset->nab, 4, PHP_ROUND_HALF_DOWN);

        $user->save();
        $model->save();

        return $model;
    }
}
