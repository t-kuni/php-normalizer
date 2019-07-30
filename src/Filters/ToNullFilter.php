<?php

namespace TKuni\PhpNormalizer\Filters;

use TKuni\PhpNormalizer\Filters\interfaces\Filter;

class ToNullFilter implements Filter {

    public function apply($input)
    {
        return null;
    }
}