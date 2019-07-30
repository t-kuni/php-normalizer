<?php

namespace TKuni\PhpNormalizer\Filters;

use TKuni\PhpNormalizer\Filters\interfaces\Filter;

class IntegerFilter implements Filter {

    public function apply($input)
    {
        return intval($input);
    }
}