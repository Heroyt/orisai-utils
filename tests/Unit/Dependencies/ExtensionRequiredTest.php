<?php declare(strict_types = 1);

namespace Tests\Orisai\Utils\Unit\Dependencies;

use Orisai\Utils\Dependencies\ExtensionRequired;
use PHPUnit\Framework\TestCase;
use Tests\Orisai\Utils\Doubles\TestClass;

final class ExtensionRequiredTest extends TestCase
{

	public function testFunction(): void
	{
		$this->expectException(ExtensionRequired::class);
		$this->expectExceptionMessage(<<<'MSG'
Context: Trying to use function testFunction().
Problem: Required php extension foo is not installed.
MSG);

		throw ExtensionRequired::forFunction(['foo'], __FUNCTION__);
	}

	public function testMethod(): void
	{
		$this->expectException(ExtensionRequired::class);
		$this->expectExceptionMessage(<<<'MSG'
Context: Trying to use method
         Tests\Orisai\Utils\Unit\Dependencies\ExtensionRequiredTest->testMethod().
Problem: Required php extension foo is not installed.
MSG);

		throw ExtensionRequired::forMethod(['foo'], self::class, __FUNCTION__);
	}

	public function testClassWithSingular(): void
	{
		$this->expectException(ExtensionRequired::class);
		$this->expectExceptionMessage(<<<'MSG'
Context: Trying to use class
         Tests\Orisai\Utils\Unit\Dependencies\ExtensionRequiredTest.
Problem: Required php extension foo is not installed.
MSG);

		throw ExtensionRequired::forClass(['foo'], self::class);
	}

	public function testClassWithPlural(): void
	{
		$this->expectException(ExtensionRequired::class);
		$this->expectExceptionMessage(<<<'MSG'
Context: Trying to use class
         Tests\Orisai\Utils\Unit\Dependencies\ExtensionRequiredTest.
Problem: Required php extensions foo, bar are not installed.
MSG);

		throw ExtensionRequired::forClass(['foo', 'bar'], self::class);
	}

	public function testUndefinedClass(): void
	{
		$this->expectException(ExtensionRequired::class);
		$this->expectExceptionMessage(<<<'MSG'
Context: Trying to use method NonExistent::undefined().
Problem: Required php extension foo is not installed.
MSG);

		throw ExtensionRequired::forMethod(['foo'], 'NonExistent', 'undefined');
	}

	public function testUndefinedMethod(): void
	{
		$this->expectException(ExtensionRequired::class);
		$this->expectExceptionMessage(<<<'MSG'
Context: Trying to use method Tests\Orisai\Utils\Doubles\TestClass::undefined().
Problem: Required php extension foo is not installed.
MSG);

		throw ExtensionRequired::forMethod(['foo'], TestClass::class, 'undefined');
	}

	public function testStaticMethod(): void
	{
		$this->expectException(ExtensionRequired::class);
		$this->expectExceptionMessage(<<<'MSG'
Context: Trying to use method
         Tests\Orisai\Utils\Doubles\TestClass::staticMethod().
Problem: Required php extension foo is not installed.
MSG);

		throw ExtensionRequired::forMethod(['foo'], TestClass::class, 'staticMethod');
	}

	public function testDynamicMethod(): void
	{
		$this->expectException(ExtensionRequired::class);
		$this->expectExceptionMessage(<<<'MSG'
Context: Trying to use method
         Tests\Orisai\Utils\Doubles\TestClass->dynamicMethod().
Problem: Required php extension foo is not installed.
MSG);

		throw ExtensionRequired::forMethod(['foo'], TestClass::class, 'dynamicMethod');
	}

}
