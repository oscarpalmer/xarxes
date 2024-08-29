<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes\Action;

use oscarpalmer\Xarxes\Manager;
use oscarpalmer\Xarxes\Xarxes;
use PHPUnit\Framework\TestCase;

final class DeleteTest extends TestCase
{
	private Manager $manager;

	public function setUp(): void
	{
		$this->manager = Xarxes::sqlite(__DIR__ . '/../test.db');
	}

	public function testRun(): void
	{
		$affected = $this->manager
			->delete('person')
			->where('id = :id')
			->parameters([
				':id' => 2,
			])
			->run();

		$this->assertSame(0, $affected);
	}
}
