<?php

namespace App\Data\Repositories\Traits;

trait JoinEloquent
{

    /**
     * Union Query
     *
     * @param mixed $query Query.
     *
     * @return $this
     */
    public function union($query)
    {
        $this->model = $this->model->union($query);

        return $this;
    }

    /**
     * Union all Query
     *
     * @param mixed $query Query.
     *
     * @return $this
     */
    public function unionAll($query)
    {
        $this->model = $this->model->unionAll($query);

        return $this;
    }
}
