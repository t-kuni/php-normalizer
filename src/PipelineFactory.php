<?php

namespace TKuni\PhpNormalizer;

use TKuni\PhpNormalizer\contracts\PipelineFactoryContract;
use TKuni\PhpNormalizer\Filters\CamelToSnakeFilter;
use TKuni\PhpNormalizer\Filters\interfaces\Filter;

class PipelineFactory implements PipelineFactoryContract
{
    private $filterDict = [];

    public function registerFilter(Filter $filter) : PipelineFactoryContract
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

    private function detectName(Filter $filter) {
        $key = preg_replace('/Filter$/', '', $this->getClassName($filter));
        return (new CamelToSnakeFilter())->apply($key);
    }

    private function getClassName($obj) {
        return (new \ReflectionClass($obj))->getShortName();
    }
}