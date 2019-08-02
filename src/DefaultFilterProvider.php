<?php


namespace TKuni\PhpNormalizer;


use TKuni\PhpNormalizer\Contracts\FilterProviderContract;
use TKuni\PhpNormalizer\Filters\CamelToSnakeFilter;
use TKuni\PhpNormalizer\Filters\ClosureFilter;
use TKuni\PhpNormalizer\Filters\Contracts\FilterContract;
use TKuni\PhpNormalizer\Filters\EmptyToNullFilter;
use TKuni\PhpNormalizer\Filters\IntegerFilter;
use TKuni\PhpNormalizer\Filters\TrimFilter;

class DefaultFilterProvider implements FilterProviderContract
{
    private $filters;

    public function __construct()
    {
        $this->filters = [
            'trim'           => new TrimFilter,
            'empty_to_null'  => new EmptyToNullFilter,
            'camel_to_snake' => new CamelToSnakeFilter,
            'integer'        => new IntegerFilter,
        ];
    }

    public function provideFilters()
    {
        return $this->filters;
    }

    /**
     * @param string $name
     * @param FilterContract|\Closure $filter
     * @return DefaultFilterProvider
     */
    public function addFilter(string $name, $filter)
    {
        if (is_object($filter) && $filter instanceof \Closure) {
            $filter = new ClosureFilter($filter);
        }

        $this->filters[$name] = $filter;

        return $this;
    }

    /**
     * @param array $filters
     * @return $this
     */
    public function addFilters(array $filters)
    {
        foreach ($filters as $name => $filter) {
            $this->addFilter($name, $filter);
        }

        return $this;
    }
}