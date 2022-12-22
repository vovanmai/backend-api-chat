<?php

namespace App\Data\Repositories\Criterias;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchTestatorFullnameCriteria implements CriteriaInterface
{
    /**
     * @var string|null
     */
    private $fullname;

    public function __construct($fullname)
    {
        $this->fullname = $fullname;
    }
    public function apply($model, RepositoryInterface $repository)
    {
        if (trim($this->fullname) !== '') {
            $fullname = strtolower($this->fullname);

            return $model->where(function ($query) use ($fullname) {
                $query->whereRaw("testators.first_name LIKE '%{$fullname}%'")
                    ->orWhereRaw("LOWER(testators.first_name) LIKE '%{$fullname}%'")
                    ->orWhereRaw("testators.last_name LIKE '%{$fullname}%'")
                    ->orWhereRaw("LOWER(testators.last_name) LIKE '%{$fullname}%'")
                    ->orWhereRaw("LOWER(CONCAT(testators.first_name, ' ', testators.last_name)) LIKE '%{$fullname}%'")
                    ->orWhereRaw("CONCAT(testators.first_name, ' ', testators.last_name) LIKE '%{$fullname}%'");
            });
        }

        return $model;
    }
}
