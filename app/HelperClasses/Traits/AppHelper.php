<?php

namespace App\HelperClasses\Traits;


trait AppHelper
{
    public $defaultPaginationNo = 12;


    public function getPaginationNo($paginationNo)
    {
        if (isStringEmpty($paginationNo)) {
            return $this->defaultPaginationNo;
        }

        return max((int)$paginationNo, $this->defaultPaginationNo);
    }

}
