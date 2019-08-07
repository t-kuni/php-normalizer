<?php

namespace TKuni\PhpNormalizer\Filters;

use TKuni\PhpNormalizer\Filters\Contracts\FilterContract;

class FloatFilter implements FilterContract {

    public function apply($input)
    {
        return floatval($input);
    }
}