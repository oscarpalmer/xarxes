<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes\Test;

use oscarpalmer\Xarxes\Driver;
use oscarpalmer\Xarxes\Manager;
use PDO;
use PHPUnit\Framework\TestCase;
use Throwable;
use TypeError;

final class ManagerTest extends TestCase
{
	public function testConstructor(): void
	{
		$this->assertInstanceOf(Manager::class, new Manager(Driver::Sqlite, './test.db'));

		try {
			new Manager('x', 'y');
		} catch (Throwable $exception) {
			$this->assertInstanceOf(TypeError::class, $exception);
		}
	}

	public function testGetters(): void
	{
		$manager = new Manager(Driver::Sqlite, 'test.db');

		$this->assertInstanceOf(PDO::class, $manager->getPdo());
	}
}
