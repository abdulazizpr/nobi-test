<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $where = [];
        $limit = $request->limit ?? 20;

        $select = ['id', 'total_unit'];
        $appends = ['total_balance', 'current_nab'];
        $orderBy = 'id';
        $sort = 'ASC';

        if (isset($request->userid)) {
            $where['id'] = $request->userid;
        }

        $where['total_unit'] = ['condition' => '>', 'value' => 0];

        $result = app(UserRepository::class)
            ->paginate($limit, $select, $where, [], $appends, $orderBy, $sort);

        return new JsonResponse([
            'code' => 201,
            'message' => 'The new user has been saved.',
            'result' => $result,
        ], 201);
    }

    public function store(UserRequest $request, User $user)
    {
        $user->fill($request->only($user->offsetGet('fillable')));
        $user->save();

        return new JsonResponse([
            'code' => 201,
            'message' => 'The new user has been saved.',
            'result' => $user,
        ], 201);
    }
}