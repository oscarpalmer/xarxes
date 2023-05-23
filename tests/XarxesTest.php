<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes\Test;

use Exception;
use LogicException;
use oscarpalmer\Xarxes\Manager;
use oscarpalmer\Xarxes\Xarxes;
use PDOException;
use PHPUnit\Framework\TestCase;

final class XarxesTest extends TestCase
{
	public function testFactories(): void
	{
		$this->assertInstanceOf(Manager::class, Xarxes::sqlite('./test.db'));

		foreach (['mysql', 'postgresql'] as $method) {
			try {
				call_user_func(sprintf('oscarpalmer\\Xarxes\\Xarxes::%s', $method), './test.db');
			} catch (PDOException $exception) {
				// Expected
			} catch (Exception $exception) {
				$this->assertInstanceOf(LogicException::class, $exception);
			}
		}
	}

	public function testVersion(): void
	{
		$this->assertIsString(Xarxes::VERSION);
	}
}
