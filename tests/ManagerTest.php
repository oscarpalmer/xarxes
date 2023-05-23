<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes\Test;

use LogicException;
use oscarpalmer\Xarxes\Manager;
use PDO;
use PHPUnit\Framework\TestCase;
use Throwable;

final class ManagerTest extends TestCase
{
	public function testConstructor(): void
	{
		$this->assertInstanceOf(Manager::class, new Manager('sqlite', './test.db'));

		try {
			new Manager('x', 'y');
		} catch (Throwable $exception) {
			$this->assertInstanceOf(LogicException::class, $exception);
		}
	}

	public function testGetters(): void
	{
		$manager = new Manager('sqlite', 'test.db');

		$this->assertInstanceOf(PDO::class, $manager->getPdo());
	}
}
