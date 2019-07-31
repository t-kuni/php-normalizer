<?php

namespace TKuni\PhpNormalizer;

use PHPUnit\Framework\TestCase;
use TKuni\PhpNormalizer\Condition as Cond;
use TKuni\PhpNormalizer\Helper\DotChainOperator;
use TKuni\PhpNormalizer\Helper\DotChainOperator as Ope;

class DotChainOperatorTest extends TestCase
{
    /**
     * @test
     */
    public function canFillValueSpecifyNestedArray()
    {
        $arr = [
            'users' => [
                [
                    'name' => 'hoge',
                ],
                [
                    'name' => 'fuga',
                ]
            ]
        ];

        Ope::update($arr, 'users.*.name', 'new val');

        $expect = [
            'users' => [
                [
                    'name' => 'new val',
                ],
                [
                    'name' => 'new val',
                ]
            ]
        ];

        $this->assertEquals($expect, $arr);
    }
}