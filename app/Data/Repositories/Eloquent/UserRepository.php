<?php

namespace App\Data\Repositories\Eloquent;

use App\Models\User;

class UserRepository extends AppBaseRepository
{
    /**
     * Attribute searchable
     *
     * @var array
     */
    protected $fieldSearchable = [
        'email'  => ['column' => 'users.email', 'operator' => 'like', 'type' => 'normal'],
        'status' => ['column' => 'users.status', 'operator' => '=', 'type' => 'normal'],
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return User::class;
    }
}
