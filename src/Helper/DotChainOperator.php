<?php


namespace TKuni\PhpNormalizer\Helper;

use Closure;

class DotChainOperator
{
    public static function update(&$arr, $key, $val)
    {
        $separetedKeys = explode('.*.', $key);
        self::_v($arr, $separetedKeys, function($in) use ($val) {
            return $val;
        });
    }

    private static function _v(&$arr, array $keys, Closure $filter, $i = 0)
    {
        if (empty($keys[$i])) {
            $arr = $filter($arr);
            return;
        }

        $currKey = $keys[$i];

        if (is_array($arr[$currKey])) {
            self::_h($arr[$currKey], $keys, $filter, $i);
        } else {
            self::_v($arr[$currKey], $keys, $filter, $i + 1);
        }
    }

    private static function _h(&$arr, array $keys, Closure $filter, $i)
    {
        foreach ($arr as &$item) {
            self::_v($item, $keys, $filter, $i + 1);
        }
    }
}