<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes;

use LogicException;
use PDO;

final class Manager
{
	private readonly PDO $pdo;

	/**
	 * @param array<mixed, mixed> $options
	 */
	public function __construct(
		string $driver,
		string $database,
		?string $username = null,
		?string $password = null,
		?array $options = null,
	) {
		if (! in_array($driver, PDO::getAvailableDrivers())) {
			throw new LogicException(sprintf('The PDO-driver \'%s\' is not available', $driver));
		}

		$this->pdo = new PDO(sprintf('%s:%s', $driver, $database), $username, $password, $options);
	}

	public function getPdo(): PDO
	{
		return $this->pdo;
	}
}
