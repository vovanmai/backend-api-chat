<?php

namespace App\Data\Repositories\Traits;

trait WhereEloquent
{

    /**
     * Search by basic where clause to the query.
     *
     * @param array  $searchData Data to search
     * @param string $searchAble Attribute name
     * @param bool   $isSearchOr Search "or"
     *
     * @return $this
     */
    public function search($searchData, string $searchAble = 'fieldSearchable', bool $isSearchOr = false)
    {
        $condition = $isSearchOr ? 'orWhere' : 'where';

        foreach ($searchData as $field => $value) {
            if (!empty($value)) {
                $searchable = $this->$searchAble[$field];
                if (!empty($searchable)) {
                    $column = array_key_exists('column', $searchable) ? $searchable['column'] : $field;
                    $operator = array_key_exists('operator', $searchable) ? $searchable['operator'] : '=';
                    $type = array_key_exists('type', $searchable) ? $searchable['type'] : 'normal';
                } else {
                    $column = $field;
                    $operator = '=';
                    $type = 'normal';
                }

                if ($type === 'raw') {
                    $column = \DB::raw($column);
                }

                if (isset($searchable['column_type'])) {
                    $column = \DB::raw($column . '::' . $searchable['column_type']);
                }
                if ('in' == $operator) {
                    $value = is_string($value) ? explode(",", $value) : $value;
                    $value = array_filter($value, function ($element) {
                        return !(is_null($element) || $element === '');
                    });
                    if ($value) {
                        $this->model = $this->model->{$condition . 'In'}($column, $value);
                    }
                } elseif ('notIn' == $operator) {
                    $value = is_string($value) ? explode(",", $value) : $value;
                    $value = array_filter($value, function ($element) {
                        return !(is_null($element) || $element === '');
                    });
                    if ($value) {
                        $this->model = $this->model->{$condition . 'NotIn'}($column, $value);
                    }
                } else {
                    if ('date' == $type) {
                        $this->model = $this->model->{$condition . 'Date'}($column, $operator, $value);
                    } else {
                        if ('like' == $operator || 'ilike' == $operator) {
                            $value = '%' . $value . '%';
                        }
                        $this->model = $this->model->$condition($column, $operator, $value);
                    }
                }
            }
        }
        return $this;
    }

    /**
     * Where not null
     *
     * @param string $columns Columns.
     *
     * @return $this
     */
    public function whereNotNull(string $columns)
    {
        $this->model = $this->model->whereNotNull($columns);

        return $this;
    }

    /**
     * Where null
     *
     * @param string $columns Columns.
     *
     * @return $this
     */
    public function whereNull(string $columns)
    {
        $this->model = $this->model->whereNull($columns);

        return $this;
    }

    /**
     * Where data by field and value
     *
     * @param string $field    Field.
     * @param mixed  $value    Value.
     * @param string $operator Operator.
     *
     * @return $this
     */
    public function whereByField(string $field, $value = null, string $operator = '=')
    {
        $this->model = $this->model->where($field, $operator, $value);

        return $this;
    }
}
