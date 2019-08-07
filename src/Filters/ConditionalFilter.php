<?php


namespace TKuni\PhpNormalizer\Filters;


use TKuni\PhpNormalizer\Filters\Contracts\FilterContract;

class ConditionalFilter implements FilterContract
{
    /**
     * @var null|\Closure
     */
    private $condition;
    /**
     * @var FilterContract
     */
    private $filter;

    public function __construct($condition, FilterContract $filter)
    {
        $this->condition = $condition;
        $this->filter    = $filter;
    }

    public function apply($input)
    {
        if ($this->hasCondition() && !($this->condition)($input)) {
            return $input;
        }

        return $this->filter->apply($input);
    }

    private function hasCondition() {
        return $this->condition !== null;
    }
}