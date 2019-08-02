<?php


namespace TKuni\PhpNormalizer\Filters;


use TKuni\PhpNormalizer\Filters\Contracts\FilterContract;

class ConditionalFilter implements FilterContract
{
    /**
     * @var array
     */
    private $conditions;
    /**
     * @var FilterContract
     */
    private $filter;

    public function __construct(array $conditions, FilterContract $filter)
    {
        $this->conditions = $conditions;
        $this->filter = $filter;
    }

    public function apply($input)
    {
        foreach ($this->conditions as $condition) {
            if (!$condition($input)) {
                return $input;
            }
        }

        return $this->filter->apply($input);
    }
}