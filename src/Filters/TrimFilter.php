<?php

namespace TKuni\PhpNormalizer\Filters;

use TKuni\PhpNormalizer\Filters\interfaces\Filter;

class TrimFilter implements Filter {

    public function apply($input)
    {
        return trim($input);
    }
}