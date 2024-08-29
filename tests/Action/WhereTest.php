<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes\Action;

use oscarpalmer\Xarxes\Manager;
use oscarpalmer\Xarxes\Xarxes;
use PHPUnit\Framework\TestCase;

final class WhereTest extends TestCase
{
	private Manager $manager;

	public function setUp(): void
	{
		$this->manager = Xarxes::sqlite(__DIR__ . '/../test.db');
	}

	public function testAdd(): void
	{
		$simple = $this->manager
			->select('a')
			->from('b')
			->where([
				'c = d',
				'e = f',
			]);

		$nested = $this->manager
			->select('a')
			->from('b')
			->where('c = d');

		$nested->where([
			'e = f',
			'g = h',
		]);

		$this->assertSame('select a from b where c = d and e = f', $simple->getQuery());
		$this->assertSame('select a from b where (c = d) or (e = f and g = h)', $nested->getQuery());
	}
}
