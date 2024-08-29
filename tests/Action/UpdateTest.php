<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes\Action;

use oscarpalmer\Xarxes\Manager;
use oscarpalmer\Xarxes\Xarxes;
use PHPUnit\Framework\TestCase;

final class UpdateTest extends TestCase
{
	private Manager $manager;

	public function setUp(): void
	{
		$this->manager = Xarxes::sqlite(__DIR__ . '/../test.db');
	}

	public function testRun(): void
	{
		$affected = $this->manager
			->update('person')
			->set('name = :name')
			->where('id = :id')
			->parameters([
				':id' => 1,
				':name' => 'Oscar',
			])
			->run();

		$this->assertSame(1, $affected);
	}
}
