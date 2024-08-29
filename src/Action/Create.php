<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes\Action;

use oscarpalmer\Xarxes\Manager;

final class Create extends Runnable
{
	/** @var array<string> */
	private array $columns = [];

	public function __construct(Manager $manager, private readonly string $table)
	{
		parent::__construct($manager);
	}

	/**
	 * Define the columns for the new table
	 * @param array<string> $columns
	 */
	public function columns(array $columns): Create
	{
		array_push($this->columns, ...$columns);

		return $this;
	}

	/**
	 * Get the query to create the table
	 */
	public function getQuery(): string
	{
		$columns = join(', ', $this->columns);

		return sprintf('create table if not exists %s (%s)', $this->table, $columns);
	}

	/**
	 * Execute the query to create the table
	 */
	public function run(): bool
	{
		return $this->prepare()->execute();
	}
}
