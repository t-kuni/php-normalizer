<?php

namespace TKuni\PhpNormalizer;

use TKuni\PhpNormalizer\contracts\PipelineContract;
use TKuni\PhpNormalizer\Filters\interfaces\Filter;

class Pipeline implements PipelineContract
{

    /**
     * @var Filter[]
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