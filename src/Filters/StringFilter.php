<?php

namespace TKuni\PhpNormalizer\Filters;

use TKuni\PhpNormalizer\Filters\Contracts\FilterContract;

class StringFilter implements FilterContract {

    public function apply($input)
    {
        return (string) $input;
    }
}