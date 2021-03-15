<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\NetAssetRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NetAssetsController extends Controller
{
    /**
     * Get Net Asset List.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return JsonResponse
    */
    public function index(Request $request): JsonResponse
    {
        $limit = $request->limit ?? 20;
        $select = ['nab', 'created_at'];
        $netAsset = app(NetAssetRepository::class)
            ->paginate($limit, $select);

        return new JsonResponse([
            'code' => 200,
            'message' => 'Get Net Asset Success.',
            'result' => $netAsset,
        ], 200);
    }
}