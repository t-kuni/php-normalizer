<?php

namespace TKuni\PhpNormalizer\Filters;

use TKuni\PhpNormalizer\Filters\interfaces\Filter;

class EmptyToNullFilter implements Filter {

    public function apply($input)
    {
        return empty($input) ? null : $input;
    }
}