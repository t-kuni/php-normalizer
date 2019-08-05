<?php

namespace TKuni\PhpNormalizer;

use PHPUnit\Framework\TestCase;
use TKuni\PhpNormalizer\Condition as Cond;
use TKuni\PhpNormalizer\Contracts\FilterProviderContract;
use TKuni\PhpNormalizer\Filters\Contracts\FilterContract;

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
        Container::container()->get(FilterProviderContract::class)
            ->addFilter('custom_filter_foo', new class implements FilterContract
            {
                public function apply($input)
                {
                    return $input . ' with foo';
                }
            })
            ->addFilter('custom_filter_bar', new class implements FilterContract
            {
                public function apply($input)
                {
                    return $input . ' with bar';
                }
            });

        $n = new Normalizer([
            'users.*.name' => ['trim', 'custom_filter_foo'],
            'users.*.age'  => ['trim', 'custom_filter_bar'],
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
                    'name' => 'hoge  fuga with foo',
                    'age'  => '20 with bar',
                ],
                [
                    'name' => ' with foo',
                    'age'  => '20 with bar',
                ],
            ]
        ];

        $this->assertEquals($expect, $actual);
    }

    /**
     * @test
     */
    public function canAddCustomFilters()
    {
        Container::container()->get(FilterProviderContract::class)
            ->addFilters([
                'custom_filter_foo' => new class implements FilterContract
                {
                    public function apply($input)
                    {
                        return $input . ' with foo';
                    }
                },
                'custom_filter_bar' => new class implements FilterContract
                {
                    public function apply($input)
                    {
                        return $input . ' with bar';
                    }
                }
            ]);

        $n = new Normalizer([
            'users.*.name' => ['trim', 'custom_filter_foo'],
            'users.*.age'  => ['trim', 'custom_filter_bar'],
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
                    'name' => 'hoge  fuga with foo',
                    'age'  => '20 with bar',
                ],
                [
                    'name' => ' with foo',
                    'age'  => '20 with bar',
                ],
            ]
        ];

        $this->assertEquals($expect, $actual);
    }

    /**
     * @test
     */
    public function canAddClosureFilter()
    {
        Container::container()->get(FilterProviderContract::class)
            ->addFilter('custom_filter_foo', function ($in) {
                return $in . ' with foo';
            });

        $n = new Normalizer([
            'users.*.name' => ['trim', 'custom_filter_foo'],
        ]);

        $actual = $n->normalize([
            'users' => [
                [
                    'name' => '    hoge  fuga ',
                ],
            ]
        ]);

        $expect = [
            'users' => [
                [
                    'name' => 'hoge  fuga with foo',
                ],
            ]
        ];

        $this->assertEquals($expect, $actual);
    }

    /**
     * @test
     */
    public function canAddClosureFilters()
    {
        Container::container()->get(FilterProviderContract::class)
            ->addFilters(['custom_filter_foo' => function ($in) {
                return $in . ' with foo';
            }]);

        $n = new Normalizer([
            'users.*.name' => ['trim', 'custom_filter_foo'],
        ]);

        $actual = $n->normalize([
            'users' => [
                [
                    'name' => '    hoge  fuga ',
                ],
            ]
        ]);

        $expect = [
            'users' => [
                [
                    'name' => 'hoge  fuga with foo',
                ],
            ]
        ];

        $this->assertEquals($expect, $actual);
    }
}