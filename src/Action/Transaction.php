<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes\Action;

/**
 * Run actions in a transaction
 */
final class Transaction
{
	public function __construct(private \oscarpalmer\Xarxes\Manager $manager)
	{
	}

	public function run(callable $callback): bool
	{
		$this->manager->getPdo()->beginTransaction();

		$commit = false;

		try {
			$commit = call_user_func($callback);
		} catch (\Exception $exception) {
			$this->manager->getPdo()->rollBack();

			throw $exception;
		}

		if (is_bool($commit) && $commit === true) {
			return $this->manager->getPdo()->commit();
		}

		return $this->manager->getPdo()->rollBack();
	}
}
