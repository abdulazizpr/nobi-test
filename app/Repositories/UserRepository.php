<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function find($userId)
    {
        return $this->model->find($userId);
    }

    public function getTotalUnit()
    {
        return $this->model->sum('total_unit');
    }
}
