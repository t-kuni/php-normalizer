<?php


namespace TKuni\PhpNormalizer\Filters;


use TKuni\PhpNormalizer\Filters\interfaces\Filter;

class ConditionalFilter implements Filter
{
    /**
     * @var array
     */
    private $conditions;
    /**
     * @var Filter
     */
    private $filter;

    public function __construct(array $conditions, Filter $filter)
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