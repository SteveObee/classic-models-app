<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

abstract class AbstractBuilder extends Builder
{
    public function whereLike($column, $value) : Self
    {
        return $this->where($column, 'like', '%'.$value.'%');
    }

    public function orWhereLike($column, $value) : Self
    {
        return $this->orWhere($column, 'like', '%'.$value.'%');
    }
}

