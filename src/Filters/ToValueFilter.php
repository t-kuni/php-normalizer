<?php

namespace TKuni\PhpNormalizer\Filters;

use TKuni\PhpNormalizer\Filters\Contracts\FilterContract;

class ToValueFilter implements FilterContract {

    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function apply($input)
    {
        return $this->value;
    }
}