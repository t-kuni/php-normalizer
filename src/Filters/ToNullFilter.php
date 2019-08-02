<?php

namespace TKuni\PhpNormalizer\Filters;

use TKuni\PhpNormalizer\Filters\Contracts\FilterContract;

class ToNullFilter implements FilterContract {

    public function apply($input)
    {
        return null;
    }
}