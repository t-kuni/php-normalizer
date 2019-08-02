<?php

namespace TKuni\PhpNormalizer\Contracts;

use TKuni\PhpNormalizer\Filters\Contracts\FilterContract;

interface PipelineBuilderContract
{
    public function registerFilter(FilterContract $filter);

    public function registerFilters(array $filters);

    public function make($filterNames);
}