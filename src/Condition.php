<?php

namespace TKuni\PhpNormalizer;

use TKuni\PhpNormalizer\Filters\ConditionalFilter;
use TKuni\PhpNormalizer\Filters\IntegerFilter;
use TKuni\PhpNormalizer\Filters\Contracts\FilterContract;
use TKuni\PhpNormalizer\Filters\ToNullFilter;

class Condition
{
    /**
     * @var \Closure
     */
    private $condition;

    public function __construct(\Closure $condition)
    {
        $this->condition = $condition;
    }

    public static function isEmpty() {
        return new Condition(function($in) {
            return empty($in);
        });
    }

    public static function isNotEmpty() {
        return new Condition(function($in) {
            return !empty($in);
        });
    }

    public static function isNotNull() {
        return new Condition(function($in) {
            return !is_null($in);
        });
    }

    public function toNull() {
        return new ConditionalFilter([$this->condition], new ToNullFilter());
    }

    public function toInt() {
        return new ConditionalFilter([$this->condition], new IntegerFilter());
    }
}