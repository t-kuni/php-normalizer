<?php

namespace TKuni\PhpNormalizer;

use PHPUnit\Framework\TestCase;
use TKuni\PhpNormalizer\Condition as Cond;
use TKuni\PhpNormalizer\Contracts\FilterProviderContract;

class NormalizerTest extends TestCase
{

    /**
     * @test
     */
    public function canNormalizeMultiple()
    {
        $n = new Normalizer([
            'name'   => ['trim', 'empty_to_null'],
            'age'    => ['trim', 'empty_to_null', 'integer'],
            'gender' => ['trim', 'empty_to_null', 'integer'],
        ]);

        $actual = $n->normalize([
            'name' => '    hoge  fuga ',
            'age'  => ' 20 ',
        ]);

        $expect = [
            'name'   => 'hoge  fuga',
            'age'    => 20,
            'gender' => null,
        ];

        $this->assertEquals($expect, $actual);
    }

    /**
     * @test
     */
    public function canUseConditionalFilters()
    {
        $n = new Normalizer([
            'name'   => ['trim', Cond::isEmpty()->toNull()],
            'age'    => ['trim', Cond::isEmpty()->toNull(), Cond::isNotNull()->toInt()],
            'gender' => ['trim', Cond::isEmpty()->toNull(), Cond::isNotNull()->toInt()],
        ]);

        $actual = $n->normalize([
            'name' => '    hoge  fuga ',
            'age'  => ' 20 ',
        ]);

        $expect = [
            'name'   => 'hoge  fuga',
            'age'    => 20,
            'gender' => null,
        ];

        $this->assertEquals($expect, $actual);
    }

    /**
     * @test
     */
    public function canNormalizeNestedArray()
    {
        $n = new Normalizer([
            'users.*.name' => ['trim', 'empty_to_null'],
            'users.*.age'  => ['trim', 'empty_to_null', 'integer'],
        ]);

        $actual = $n->normalize([
            'users' => [
                [
                    'name' => '    hoge  fuga ',
                    'age'  => ' 20 ',
                ],
                [
                    'name' => '',
                    'age'  => ' 20 ',
                ],
            ]
        ]);

        $expect = [
            'users' => [
                [
                    'name' => 'hoge  fuga',
                    'age'  => 20,
                ],
                [
                    'name' => null,
                    'age'  => 20,
                ],
            ]
        ];

        $this->assertEquals($expect, $actual);
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function throwExceptionIfUnknownFilter()
    {
        $this->markTestSkipped();

        $n = new Normalizer([
            'age' => ['trim', 'unknown', 'integer'],
        ]);

        $actual = $n->normalize([
            'name' => '    hoge  fuga ',
            'age'  => ' 20 ',
        ]);
    }

    /**
     * @test
     */
    public function canAddCustomFilter()
    {
        $this->markTestSkipped();

        Container::container()->extend(FilterProviderContract::class)->setConcrete(function() {
            return new class implements FilterProviderContract {
                public function provideFilters()
                {
                    return [

                    ];
                }
            };
        });

        $n = new Normalizer([
            'users.*.name' => ['trim', 'empty_to_null'],
            'users.*.age'  => ['trim', 'empty_to_null', 'integer'],
        ]);

        $actual = $n->normalize([
            'users' => [
                [
                    'name' => '    hoge  fuga ',
                    'age'  => ' 20 ',
                ],
                [
                    'name' => '',
                    'age'  => ' 20 ',
                ],
            ]
        ]);

        $expect = [
            'users' => [
                [
                    'name' => 'hoge  fuga',
                    'age'  => 20,
                ],
                [
                    'name' => null,
                    'age'  => 20,
                ],
            ]
        ];

        $this->assertEquals($expect, $actual);
    }
}