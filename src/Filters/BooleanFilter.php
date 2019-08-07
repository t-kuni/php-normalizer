<?php

namespace TKuni\PhpNormalizer\Filters;

use TKuni\PhpNormalizer\Filters\Contracts\FilterContract;

class BooleanFilter implements FilterContract {

    public function apply($input)
    {
        return boolval($input);
    }
}