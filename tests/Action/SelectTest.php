<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes\Test\Action;

use InvalidArgumentException;
use LogicException;
use oscarpalmer\Xarxes\Manager;
use oscarpalmer\Xarxes\Xarxes;
use PHPUnit\Framework\TestCase;
use Throwable;

final class SelectTest extends TestCase
{
	private Manager $manager;

	public function setUp(): void
	{
		$this->manager = Xarxes::sqlite(__DIR__ . '/../test.db');
	}

	public function testConstructor(): void
	{
		$string = $this->manager->select('*');
		$array = $this->manager->select(['a', 'b']);

		$this->assertSame('select * from ', (string) $string);
		$this->assertSame('select a, b from ', (string) $array);

		try {
			$this->manager->select([1]);
		} catch (Throwable $throwable) {
			$this->assertInstanceOf(InvalidArgumentException::class, $throwable);
		}
	}

	public function testFrom(): void
	{
		$string = $this->manager->select('*')->from('a');
		$array = $this->manager->select('*')->from(['a', 'b']);

		$this->assertSame('select * from a', $string->getQuery());
		$this->assertSame('select * from a, b', $array->getQuery());

		try {
			$this->manager->select('*')->from([1]);
		} catch (Throwable $throwable) {
			$this->assertInstanceOf(InvalidArgumentException::class, $throwable);
		}

		try {
			$string->from('b');
		} catch (Throwable $throwable) {
			$this->assertInstanceOf(LogicException::class, $throwable);
		}
	}

	public function testParameters(): void
	{
		$select = $this->manager
			->select('*')
			->from('a')
			->parameters([':p' => 'v']);

		$parameters = $select->getParameters();

		$this->assertIsArray($parameters);
		$this->assertCount(1, $parameters);
	}

	public function testRun(): void
	{
		$persons = $this->manager
			->select('*')
			->from('person')
			->where('age > :age')
			->parameters([
				':age' => 30,
			])
			->run();

		$this->assertIsArray($persons);
		$this->assertCount(2, $persons);
		$this->assertSame('Oscar Palmér', $persons[0]['name']);
	}

	public function testWhere(): void
	{
		$string = $this->manager->select('*')->from('a')->where('x = 1');
		$array = $this->manager->select('*')->from('a')->where(['x = 1', 'y = 2']);

		$this->assertSame('select * from a where x = 1', $string->getQuery());
		$this->assertSame('select * from a where x = 1 and y = 2', $array->getQuery());

		try {
			$this->manager->select('*')->from('a')->where([1]);
		} catch (Throwable $throwable) {
			$this->assertInstanceOf(InvalidArgumentException::class, $throwable);
		}
	}
}
