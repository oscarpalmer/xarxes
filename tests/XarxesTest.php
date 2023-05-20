<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes\Test;

use PHPUnit\Framework\TestCase;
use oscarpalmer\Xarxes\Xarxes;

final class XarxesTest extends TestCase
{
	public function testVersion(): void
	{
		$this->assertIsString(Xarxes::VERSION);
	}
}
