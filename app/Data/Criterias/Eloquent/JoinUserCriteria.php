<?php

namespace App\Data\Criterias\Eloquent;

use Prettus\Repository\Contracts\RepositoryInterface;

class JoinUserCriteria extends Criteria
{

    /**
     * Type
     *
     * @var string
     */
    private $type;

    /**
     * Constructor.
     *
     * @param string $type Type
     *
     * @return void
     */
    public function __construct(string $type = 'join')
    {
        $this->type = $type;
    }

    /**
     * Apply criteria in query repository
     *
     * @param mixed               $model      Model
     * @param RepositoryInterface $repository RepositoryInterface
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->{$this->type}(
            'users',
            'users.id',
            '=',
            "{$model->getTable()}.user_id"
        );
    }
}
