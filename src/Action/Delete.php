<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes\Action;

use oscarpalmer\Xarxes\Manager;

final class Delete extends Runnable
{
	use Where;

	public function __construct(Manager $manager, private readonly string $table)
	{
		parent::__construct($manager);
	}

	/**
	 * Get the query to delete rows from the table
	 */
	public function getQuery(): string
	{
		return sprintf('delete from %s%s', $this->table, $this->getWhereQueryPart());
	}

	/**
	 * Execute the query to delete rows from the table
	 */
	public function run(): int
	{
		$prepared = $this->prepare();

		$prepared->execute();

		return $prepared->rowCount();
	}
}
