<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\NetAssetRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NetAssetsController extends Controller
{
    public function index(Request $request)
    {
        $netAssetRepo = app(NetAssetRepository::class);

        $limit = $request->limit ?? 20;
        $select = ['nab', 'created_at'];
        $netAsset = $netAssetRepo->paginate($limit, $select);

        return new JsonResponse([
            'code' => 200,
            'message' => 'Get Net Asset Success.',
            'result' => $netAsset,
        ], 200);
    }
}
