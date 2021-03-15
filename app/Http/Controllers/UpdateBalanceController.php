<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBalanceRequest;
use App\Repositories\NetAssetRepository;
use Illuminate\Http\JsonResponse;

class UpdateBalanceController extends Controller
{
    /**
     * Update Balance.
     *
     * @param \App\Http\Requests\UpdateBalanceRequest $request
     *
     * @return JsonResponse
    */
    public function update(UpdateBalanceRequest $request) {
        $netAsset = app(NetAssetRepository::class)
            ->updateBalance($request);

        return new JsonResponse([
            'code' => 200,
            'message' => 'Update Balance Success',
            'result' => $netAsset
        ]);
    }
}
