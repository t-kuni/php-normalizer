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
    public function canUpdateByNestedKey()
    {
        $arr = [
            'users' => [
                'name' => 'hoge',
            ]
        ];

        $actual = Ope::update($arr, 'users.name', 'new val');

        $expect = [
            'users' => [
                'name' => 'new val',
            ]
        ];

        $this->assertEquals($expect, $actual);
    }

    /**
     * @test
     */
    public function canUpdateByWildCardSyntax()
    {
        $arr = [
            'users' => [
                [
                    'name' => 'hoge',
                ],
                [
                    'name' => 'fuga',
                ],
                'with_key' => [
                    'name' => null,
                ]
            ]
        ];

        $actual = Ope::update($arr, 'users.*.name', 'new val');

        $expect = [
            'users' => [
                [
                    'name' => 'new val',
                ],
                [
                    'name' => 'new val',
                ],
                'with_key' => [
                    'name' => 'new val',
                ]
            ]
        ];

        $this->assertEquals($expect, $actual);
    }

    /**
     * @test
     */
    public function canUpdateByWildCardSyntax2()
    {
        $arr = [
            'ids' => [
                1, 2, 4, 8, 16,
            ]
        ];

        $actual = Ope::update($arr, 'ids.*', function($in) {
            return $in * 2;
        });

        $expect = [
            'ids' => [
                2, 4, 8, 16, 32,
            ]
        ];

        $this->assertEquals($expect, $actual);
    }

    /**
     * @test
     */
    public function canUpdateByWildCardSyntax3()
    {
        $arr = [
            'productions' => [
                [
                    'name' => '765 Production',
                    'idols' => [
                        [
                            'name' => 'Haruka Amami',
                        ],
                        [
                            'name' => 'Chihaya Kisaragi',
                        ],
                        [
                            'name' => 'Yukiho Hagiwara',
                        ]
                    ]
                ],
                [
                    'name' => '876 Production',
                    'idols' => [
                        [
                            'name' => 'Ai Hidaka',
                        ],
                        [
                            'name' => 'Eri Mizutani',
                        ],
                    ]
                ],
                [
                    'name' => '961 Production',
                    'idols' => [
                        [
                            'name' => 'Tōma Amagase',
                        ],
                    ]
                ],
            ]
        ];

        $actual = Ope::update($arr, 'productions.*.idols.*.name', function($in) {
            return 'new val';
        });

        $expect = [
            'productions' => [
                [
                    'name' => '765 Production',
                    'idols' => [
                        [
                            'name' => 'new val',
                        ],
                        [
                            'name' => 'new val',
                        ],
                        [
                            'name' => 'new val',
                        ]
                    ]
                ],
                [
                    'name' => '876 Production',
                    'idols' => [
                        [
                            'name' => 'new val',
                        ],
                        [
                            'name' => 'new val',
                        ],
                    ]
                ],
                [
                    'name' => '961 Production',
                    'idols' => [
                        [
                            'name' => 'new val',
                        ],
                    ]
                ],
            ]
        ];

        $this->assertEquals($expect, $actual);
    }
}