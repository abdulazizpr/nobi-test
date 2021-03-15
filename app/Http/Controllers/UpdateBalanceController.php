<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBalanceRequest;
use App\Repositories\NetAssetRepository;
use Illuminate\Http\JsonResponse;

class UpdateBalanceController extends Controller
{
    public function update(UpdateBalanceRequest $request) {
        $netAssetRepo = app(NetAssetRepository::class);
        $netAsset = $netAssetRepo->updateBalance($request);

        return new JsonResponse([
            'code' => 200,
            'message' => 'Update Balance Success',
            'result' => $netAsset
        ]);
    }
}
