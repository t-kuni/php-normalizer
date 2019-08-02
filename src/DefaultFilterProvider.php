<?php


namespace TKuni\PhpNormalizer;


use TKuni\PhpNormalizer\Contracts\FilterProviderContract;
use TKuni\PhpNormalizer\Filters\CamelToSnakeFilter;
use TKuni\PhpNormalizer\Filters\EmptyToNullFilter;
use TKuni\PhpNormalizer\Filters\IntegerFilter;
use TKuni\PhpNormalizer\Filters\TrimFilter;

class DefaultFilterProvider implements FilterProviderContract
{
    private $filters;

    public function __construct()
    {
        $this->filters = [
            TrimFilter::class,
            EmptyToNullFilter::class,
            CamelToSnakeFilter::class,
            IntegerFilter::class,
        ];
    }

    public function provideFilters() {
        return $this->filters;
    }
}