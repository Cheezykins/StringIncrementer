<?php


namespace Cheezykins\StringIncrementer\Tests;


use Cheezykins\StringIncrementer\Exceptions\InvalidSymbolException;
use Cheezykins\StringIncrementer\IncrementalString;

class IncrementalStringTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructorRequiresNoArguments()
    {
        $inc = new IncrementalString();
    }
    
    public function testConstructorStartMustBeValid()
    {
        $this->expectException(InvalidSymbolException::class);
        $inc = new IncrementalString('abc!');
    }

    public function testToStringMethod()
    {
        $inc = new IncrementalString('abc');
        $this->assertEquals('abc', $inc->output());
        $this->assertEquals($inc->output(), (string)$inc);
    }

    public function testSettingCurrentString()
    {
        $inc = new IncrementalString('abc');
        $this->assertEquals('abc', (string)$inc);

        $inc->setCurrentString('def');
        $this->assertEquals('def', (string)$inc);
    }

    public function testSetAlphabetChangesAlphabet()
    {
        $inc = new IncrementalString();
        $inc->setAlphabet('abcdefghijklmnopqrstuvwxyz');

        $this->expectException(InvalidSymbolException::class);
        $inc->setCurrentString('A');
    }

    public function testSetAlphabetClearsCurrentString()
    {
        $inc = new IncrementalString();
        $inc->setCurrentString('ABCDE');
        $inc->setAlphabet('abcdefghijklmnopqrstuvwxyz');
        $this->assertEquals('a', (string)$inc);
    }
    
    public function testSimpleIncrement()
    {
        $inc = new IncrementalString();
        $this->assertEquals('a', (string)$inc);
        $inc->increment();
        $this->assertEquals('b', (string)$inc);
    }

    public function testComplexIncrement()
    {
        $inc = new IncrementalString('zz', 'abcdefghijklmnopqrstuvwxyz');
        $this->assertEquals('zz', (string)$inc);
        $inc->increment();
        $this->assertEquals('aaa', (string)$inc);
    }

    public function testMultiIncrement()
    {
        $inc = new IncrementalString();
        $this->assertEquals('a', (string)$inc);
        $inc->increment(3);
        $this->assertEquals('d', (string)$inc);
    }

    public function testComplexMultiIncrement()
    {
        $inc = new IncrementalString('zz', 'abcdefghijklmnopqrstuvwxyz');
        $this->assertEquals('zz', (string)$inc);
        $inc->increment(3);
        $this->assertEquals('aac', (string)$inc);
    }

    public function testIncrementReturnsNewValue()
    {
        $inc = new IncrementalString();
        $this->assertEquals('a', (string)$inc);
        $newVal = $inc->increment();
        $this->assertEquals('b', $newVal);
    }

    public function testPaddedOutput()
    {
        $inc = new IncrementalString('zz', 'abcdefghijklmnopqrstuvwxyz');

        $this->assertEquals('aaazz', $inc->padOutput(5));
    }
}
