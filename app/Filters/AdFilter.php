<?php
namespace App\Filters;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class AdFilter
{
    protected $request;
    protected $builder;

    protected $filters = [
        'operator',
        'location',
        'is_featured',
        'min_price',
        'max_price',
        'active_only'
    ];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    protected function getFilters()
    {
        return array_filter($this->request->only($this->filters));
    }

    protected function operator($value)
    {
        return $this->builder->byOperator($value);
    }

    protected function location($value)
    {
        return $this->builder->byLocation($value);
    }

    protected function is_featured($value)
    {
        if (filter_var($value, FILTER_VALIDATE_BOOLEAN)) {
            return $this->builder->featured();
        }
        return $this->builder;
    }

    protected function min_price($value)
    {
        return $this->builder->where('price', '>=', $value);
    }

    protected function max_price($value)
    {
        return $this->builder->where('price', '<=', $value);
    }

    protected function active_only($value)
    {
        if (filter_var($value, FILTER_VALIDATE_BOOLEAN)) {
            return $this->builder->active();
        }
        return $this->builder;
    }
}