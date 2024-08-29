<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes\Action;

use oscarpalmer\Xarxes\Manager;
use PDOStatement;

/**
 * Run an SQL query
 */
final class Query extends Runnable
{
	public function __construct(Manager $manager, private readonly string $query)
	{
		parent::__construct($manager);
	}

	/**
	 * Get the query to run
	 */
	public function getQuery(): string
	{
		return $this->query;
	}

	/**
	 * Execute the query
	 */
	public function run(): PDOStatement
	{
		$prepared = $this->prepare();

		$prepared->execute();

		return $prepared;
	}
}
