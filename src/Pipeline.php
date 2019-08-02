<?php

namespace TKuni\PhpNormalizer;

use TKuni\PhpNormalizer\Contracts\PipelineContract;
use TKuni\PhpNormalizer\Filters\Contracts\FilterContract;

class Pipeline implements PipelineContract
{

    /**
     * @var FilterContract[]
     */
    private $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function apply($input)
    {
        $out = $input;

        foreach ($this->filters as $filter) {
            $out = $filter->apply($out);
        }

        return $out;
    }
}