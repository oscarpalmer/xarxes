<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes\Test\Action;

use oscarpalmer\Xarxes\Manager;
use PHPUnit\Framework\TestCase;

final class QueryTest extends TestCase
{
	private Manager $manager;

	public function setUp(): void
	{
		$this->manager = new Manager('sqlite', __DIR__ . '/../test.db');
	}

	public function testGetters(): void
	{
		$this->assertSame('select * from a', $this->manager->query('select * from a')->getQuery());
	}

	public function testRun(): void
	{
		$query = $this->manager->query('select * from person');

		$statement = $query->run();
		$persons = $statement->fetchAll();

		$this->assertCount(1, $persons);
		$this->assertSame('Oscar', $persons[0]['name']);
	}
}
