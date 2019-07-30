<?php

namespace TKuni\PhpNormalizer\contracts;

use TKuni\PhpNormalizer\Filters\interfaces\Filter;

interface PipelineFactoryContract
{
    public function registerFilter(Filter $filter);

    public function make($filterNames);
}