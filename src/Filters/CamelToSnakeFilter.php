<?php

namespace TKuni\PhpNormalizer\Filters;

use TKuni\PhpNormalizer\Filters\Contracts\FilterContract;

class CamelToSnakeFilter implements FilterContract {

    public function apply($in)
    {
        $out = $in;
        $out = preg_replace('/(.)(?=[A-Z])/u', '$1_', $out);
        return mb_strtolower($out, 'UTF-8');
    }
}