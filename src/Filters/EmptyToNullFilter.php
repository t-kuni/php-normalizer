<?php

namespace TKuni\PhpNormalizer\Filters;

use TKuni\PhpNormalizer\Filters\Contracts\FilterContract;

class EmptyToNullFilter implements FilterContract {

    public function apply($input)
    {
        return empty($input) ? null : $input;
    }
}