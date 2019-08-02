<?php

namespace TKuni\PhpNormalizer\Filters;

use TKuni\PhpNormalizer\Filters\Contracts\FilterContract;

class TrimFilter implements FilterContract {

    public function apply($input)
    {
        return trim($input);
    }
}