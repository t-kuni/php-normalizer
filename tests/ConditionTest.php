<?php

namespace TKuni\PhpNormalizer;

use PHPUnit\Framework\TestCase;
use TKuni\PhpNormalizer\Condition as Cond;
use TKuni\PhpNormalizer\Filters\Contracts\FilterContract;

class ConditionTest extends TestCase
{
    /**
     * @test
     */
    public function canSpecifyValue()
    {
        $actual = Cond::is(0)->to(1)->apply(0);
        $expect = 1;
        $this->assertEquals($expect, $actual);

        $actual = Cond::is('target_value')->to('new_value')->apply('target_value');
        $expect = 'new_value';
        $this->assertEquals($expect, $actual);

        $actual = Cond::is('target_value')->to('new_value')->apply('not match');
        $expect = 'not match';
        $this->assertEquals($expect, $actual);
    }

    /**
     * @test
     */
    public function canUseConditionEmpty()
    {
        $actual = Cond::isEmpty()->to(null)->apply('');
        $expect = null;
        $this->assertEquals($expect, $actual);

        $actual = Cond::isEmpty()->to('default value')->apply(null);
        $expect = 'default value';
        $this->assertEquals($expect, $actual);

        $actual = Cond::isEmpty()->to('default value')->apply('not match');
        $expect = 'not match';
        $this->assertEquals($expect, $actual);
    }

    /**
     * @test
     */
    public function canUseClosureAsCondition()
    {
        $actual = Cond::is(function($in) {
            return $in === 'target';
        })->to('new')->apply('target');
        $expect = 'new';
        $this->assertEquals($expect, $actual);

        $actual = Cond::is(function($in) {
            return $in === 'target';
        })->to('new')->apply('not_match');
        $expect = 'not_match';
        $this->assertEquals($expect, $actual);
    }

    /**
     * @test
     */
    public function canUseAnyCondition()
    {
        $actual = Cond::isAny()->to('new')->apply('target');
        $expect = 'new';
        $this->assertEquals($expect, $actual);
    }

    /**
     * @test
     */
    public function canUseContains()
    {
        $actual = Cond::isContains('bob')->to('carol')->apply('alice bob');
        $expect = 'carol';
        $this->assertEquals($expect, $actual);

        $actual = Cond::isContains('bob')->to('carol')->apply('alice bo');
        $expect = 'alice bo';
        $this->assertEquals($expect, $actual);
    }

    /**
     * @test
     */
    public function canUseRegexp()
    {
        $actual = Cond::isRegexp('/\.txt$/')->to('dummy.json')->apply('blank.txt');
        $expect = 'dummy.json';
        $this->assertEquals($expect, $actual);

        $actual = Cond::isRegexp('/\.txt$/')->to('dummy.json')->apply('blank.ttt');
        $expect = 'blank.ttt';
        $this->assertEquals($expect, $actual);
    }

    /**
     * @test
     */
    public function canCastType()
    {
        $actual = Cond::isAny()->toInt()->apply('0');
        $expect = 0;
        $this->assertSame($expect, $actual);

        $actual = Cond::isAny()->toInt()->apply('aaa');
        $expect = 0;
        $this->assertSame($expect, $actual);

        $actual = Cond::isAny()->toBoolean()->apply('true');
        $expect = true;
        $this->assertSame($expect, $actual);

        $actual = Cond::isAny()->toBoolean()->apply('false');
        $expect = true; // MEMO: should wrap behavior?
        $this->assertSame($expect, $actual);

        $actual = Cond::isAny()->toFloat()->apply('1.1');
        $expect = 1.1;
        $this->assertSame($expect, $actual);

        $actual = Cond::isAny()->toFloat()->apply('aaa');
        $expect = 0.0;
        $this->assertSame($expect, $actual);

        $actual = Cond::isAny()->toString()->apply(123);
        $expect = '123';
        $this->assertSame($expect, $actual);

        $actual = Cond::isAny()->toString()->apply(true);
        $expect = '1';
        $this->assertSame($expect, $actual);
    }

    /**
     * @test
     */
    public function canUseClosureAsOutput()
    {
        $actual = Cond::isAny()->to(function($in) {
            return $in . '-suffix';
        })->apply('bob');
        $expect = 'bob-suffix';
        $this->assertEquals($expect, $actual);
    }

    /**
     * @test
     */
    public function canSpecifyFilterNameAtOutput()
    {
        $this->markTestSkipped();

        $actual = Cond::isAny()->toFilter('trim')->apply('  bob  ');
        $expect = 'bob';
        $this->assertEquals($expect, $actual);
    }

    /**
     * @test
     */
    public function canUseFilterAsOutput()
    {
        $actual = Cond::isAny()->to(new class implements FilterContract
        {
            public function apply($input)
            {
                return $input . '-suffix';
            }
        })->apply('bob');
        $expect = 'bob-suffix';
        $this->assertEquals($expect, $actual);
    }
}