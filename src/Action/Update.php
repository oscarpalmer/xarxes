<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes\Action;

use oscarpalmer\Xarxes\Manager;

/**
 * Update rows in a table
 */
final class Update extends Runnable
{
	use Where;

	/** @var array<string> */
	private array $set = [];

	public function __construct(Manager $manager, private readonly string $table)
	{
		parent::__construct($manager);
	}

	/**
	 * Get the query to update the table
	 */
	public function getQuery(): string
	{
		$set = join(', ', $this->set);

		return sprintf('update %s set %s%s', $this->table, $set, $this->getWhereQueryPart());
	}

	/**
	 * Execute the query to update the table
	 */
	public function run(): int
	{
		$prepared = $this->prepare();

		return $prepared->execute() === true ? $prepared->rowCount() : 0;
	}

	/**
	 * Define the columns to update
	 * @param array<string>|string $set
	 */
	public function set(array|string $set): Update
	{
		array_push($this->set, ...(is_array($set) ? $set : [$set]));

		return $this;
	}
}
