<?php

namespace TKuni\PhpNormalizer;

use TKuni\PhpNormalizer\Filters\BooleanFilter;
use TKuni\PhpNormalizer\Filters\ClosureFilter;
use TKuni\PhpNormalizer\Filters\ConditionalFilter;
use TKuni\PhpNormalizer\Filters\FloatFilter;
use TKuni\PhpNormalizer\Filters\IntegerFilter;
use TKuni\PhpNormalizer\Filters\Contracts\FilterContract;
use TKuni\PhpNormalizer\Filters\StringFilter;
use TKuni\PhpNormalizer\Filters\ToNullFilter;
use TKuni\PhpNormalizer\Filters\ToValueFilter;

class Condition
{
    /**
     * @var null|\Closure
     */
    private $condition;

    public function __construct($condition)
    {
        $this->condition = $condition;
    }

    public static function is($value) {
        if (is_callable($value)) {
            return new Condition($value);
        } else {
            return new Condition(function($in) use ($value) {
                return $in == $value;
            });
        }
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

    public static function isAny() {
        return new Condition(null);
    }

    public static function isContains($text) {
        return new Condition(function($in) use ($text) {
            return strpos($in, $text) !== false;
        });
    }

    public static function isRegexp($regexp) {
        return new Condition(function($in) use ($regexp) {
            return preg_match($regexp, $in);
        });
    }

    public function to($value) {
        if (is_callable($value)) {
            return new ConditionalFilter($this->condition, new ClosureFilter($value));
        } else if (is_object($value) && $value instanceof FilterContract) {
            return new ConditionalFilter($this->condition, $value);
        } else {
            return new ConditionalFilter($this->condition, new ToValueFilter($value));
        }
    }

    public function toNull() {
        return new ConditionalFilter($this->condition, new ToNullFilter());
    }

    public function toInt() {
        return new ConditionalFilter($this->condition, new IntegerFilter());
    }

    public function toFloat() {
        return new ConditionalFilter($this->condition, new FloatFilter());
    }

    public function toBoolean() {
        return new ConditionalFilter($this->condition, new BooleanFilter());
    }

    public function toString() {
        return new ConditionalFilter($this->condition, new StringFilter());
    }
}