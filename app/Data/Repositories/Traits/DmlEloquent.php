<?php

namespace App\Data\Repositories\Traits;

trait DmlEloquent
{

    /**
     * Delete multiple entities by given id.
     *
     * @param string $field Field.
     * @param array  $ids   Ids.
     *
     * @return integer
     */
    public function deletes(string $field, array $ids)
    {
        $this->applyScope();
        $this->applyCriteria();

        $model = $this->model->whereIn($field, $ids);

        $this->resetModel();
        $this->resetScope();
        $this->resetCriteria();

        return $model->delete();
    }

    /**
     * Force delete.
     *
     * @param array $where Condition.
     *
     * @return mixed
     */
    public function forceDelete(array $where)
    {
        $this->applyScope();
        $this->applyCriteria();
        $this->applyConditions($where);
        $model = $this->model->forceDelete();

        $this->resetModel();
        $this->resetScope();
        return $this->parserResult($model);
    }
}
