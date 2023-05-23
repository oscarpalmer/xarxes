<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes\Action;

use oscarpalmer\Xarxes\Manager;
use PDOStatement;

final class Query extends Runnable
{
	public function __construct(Manager $manager, private readonly string $query)
	{
		parent::__construct($manager);
	}

	public function getQuery(): string
	{
		return $this->query;
	}

	public function run(): PDOStatement
	{
		return $this->execute();
	}
}
