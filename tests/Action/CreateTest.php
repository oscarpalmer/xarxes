<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes\Test\Action;

use oscarpalmer\Xarxes\Manager;
use oscarpalmer\Xarxes\Xarxes;
use PHPUnit\Framework\TestCase;

final class CreateTest extends TestCase
{
	private Manager $manager;

	public function setUp(): void
	{
		$this->manager = Xarxes::sqlite(__DIR__ . '/../test.db');
	}

	public function testRun(): void
	{
		$success = $this->manager
			->create('blah')
			->columns(['id integer'])
			->run();

		$this->assertSame(true, $success);
	}
}
