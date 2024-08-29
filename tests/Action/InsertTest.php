<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes\Test\Action;

use Exception;
use InvalidArgumentException;
use LogicException;
use oscarpalmer\Xarxes\Manager;
use oscarpalmer\Xarxes\Xarxes;
use PHPUnit\Framework\TestCase;
use Throwable;

final class InsertTest extends TestCase
{
	private Manager $manager;

	public function setUp(): void
	{
		$this->manager = Xarxes::sqlite(__DIR__ . '/../test.db');
	}

	public function testColumns(): void
	{
		try {
			$insert = $this->manager->insert('a')->columns(['x']);
			$insert->columns(['y']);
		} catch (Throwable $exception) {
			$this->assertInstanceOf(LogicException::class, $exception);
		}

		try {
			$this->manager->insert('a')->columns([1]);
		} catch (Throwable $exception) {
			$this->assertInstanceOf(InvalidArgumentException::class, $exception);
		}
	}

	public function testEmpty(): void
	{
		try {
			$this->manager->insert('a')->columns(['x'])->run();
		} catch (Exception $exception) {
			$this->assertInstanceOf(LogicException::class, $exception);
		}
	}

	public function testRun(): void
	{
		$inserted = $this->manager
			->insert('person')
			->columns(['id', 'name', 'age'])
			->values([2, ':name', 99])
			->parameters([
				':name' => 'Blah Blah',
			])
			->run();

		$this->assertSame($inserted, true);
	}

	public function testValues(): void
	{
		try {
			$insert = $this->manager->insert('a')->values(['x']);
			$insert->values(['y']);
		} catch (Throwable $exception) {
			$this->assertInstanceOf(LogicException::class, $exception);
		}
	}
}
