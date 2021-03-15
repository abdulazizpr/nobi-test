<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TopUpRequest;
use App\Repositories\TransactionRepository;
use Illuminate\Http\JsonResponse;
use Throwable;

class TopUpController extends Controller
{
    public function create(TopUpRequest $request)
    {
        \DB::beginTransaction();

        $transactionRepo = app(TransactionRepository::class);
        try {
            $result = $transactionRepo->create($request);
        } catch (Throwable $e) {
            \DB::rollback();

            return new JsonResponse([
                'code' => 400,
                'message' => 'Top Up has been failed.',
                'result' => [],
            ], 400);
        }

        \DB::commit();

        return new JsonResponse([
            'code' => 200,
            'message' => 'Top Up has been success.',
            'result' => $result,
        ], 200);
    }
}
