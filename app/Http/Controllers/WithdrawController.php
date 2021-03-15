<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\WithdrawRequest;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use Illuminate\Http\JsonResponse;
use Throwable;

class WithdrawController extends Controller
{
    /**
     * Create Withdraw.
     *
     * @param \App\Http\Requests\WithdrawRequest $request
     *
     * @return JsonResponse
    */
    public function create(WithdrawRequest $request)
    {
        \DB::beginTransaction();

        try {
            $result = app(TransactionRepository::class)
                ->create($request, Transaction::WITHDRAW);
        } catch (Throwable $e) {
            \DB::rollback();

            return new JsonResponse([
                'code' => 400,
                'message' => 'Withdraw has been failed.',
                'result' => [],
            ], 400);
        }

        \DB::commit();

        return new JsonResponse([
            'code' => 201,
            'message' => 'Withdraw has been success.',
            'result' => $result,
        ], 201);
    }
}