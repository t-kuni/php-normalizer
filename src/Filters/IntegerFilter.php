<?php

namespace TKuni\PhpNormalizer\Filters;

use TKuni\PhpNormalizer\Filters\Contracts\FilterContract;

class IntegerFilter implements FilterContract {

    public function apply($input)
    {
        return intval($input);
    }
}