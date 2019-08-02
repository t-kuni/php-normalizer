<?php

namespace TKuni\PhpNormalizer;

use TKuni\PhpNormalizer\Contracts\PipelineBuilderContract;
use TKuni\PhpNormalizer\Filters\CamelToSnakeFilter;
use TKuni\PhpNormalizer\Filters\Contracts\FilterContract;

class PipelineBuilder implements PipelineBuilderContract
{
    private $filterDict = [];

    public function registerFilter(FilterContract $filter) : PipelineBuilderContract
    {
        $name = $this->detectName($filter);
        $this->filterDict[$name] = $filter;
        return $this;
    }

    public function make($filterNames){
        $filters = array_map(function($name) {
            if (is_string($name)) {
                return $this->filterDict[$name];
            } else {
                return $name;
            }
        }, $filterNames);

        return new Pipeline($filters);
    }

    private function detectName(FilterContract $filter) {
        $key = preg_replace('/Filter$/', '', $this->getClassName($filter));
        return (new CamelToSnakeFilter())->apply($key);
    }

    private function getClassName($obj) {
        return (new \ReflectionClass($obj))->getShortName();
    }

    public function registerFilters(array $filters)
    {
        foreach ($filters as $filter) {
            $this->registerFilter($filter);
        }
    }
}