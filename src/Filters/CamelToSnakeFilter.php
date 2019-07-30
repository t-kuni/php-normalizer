<?php

namespace TKuni\PhpNormalizer\Filters;

use TKuni\PhpNormalizer\Filters\interfaces\Filter;

class CamelToSnakeFilter implements Filter {

    public function apply($in)
    {
        $out = $in;
        $out = preg_replace('/(.)(?=[A-Z])/u', '$1_', $out);
        return mb_strtolower($out, 'UTF-8');
    }
}