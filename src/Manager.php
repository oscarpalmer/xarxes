<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes;

use LogicException;
use oscarpalmer\Xarxes\Action\Create;
use oscarpalmer\Xarxes\Action\Delete;
use oscarpalmer\Xarxes\Action\Insert;
use oscarpalmer\Xarxes\Action\Query;
use oscarpalmer\Xarxes\Action\Select;
use oscarpalmer\Xarxes\Action\Update;
use PDO;

final class Manager
{
	private readonly PDO $pdo;

	/**
	 * @param array<mixed, mixed> $options
	 */
	public function __construct(
		Driver $driver,
		string $database,
		?string $username = null,
		?string $password = null,
		?array $options = null,
	) {
		// @codeCoverageIgnoreStart
		if (! in_array($driver->value, PDO::getAvailableDrivers())) {
			throw new LogicException(sprintf('The PDO-driver \'%s\' is not available', $driver->value));
		}
		// @codeCoverageIgnoreEnd

		$this->pdo = new PDO(sprintf('%s:%s', $driver->value, $database), $username, $password, $options);
	}

	/**
	 * Create a new table
	 */
	public function create(string $table): Create
	{
		return new Create($this, $table);
	}

	/**
	 * Delete rows from a table
	 */
	public function delete(string $table): Delete
	{
		return new Delete($this, $table);
	}

	/**
	 * Get the PDO instance
	 */
	public function getPdo(): PDO
	{
		return $this->pdo;
	}

	/**
	 * Execute a query
	 */
	public function query(string $query): Query
	{
		return new Query($this, $query);
	}

	/**
	 * Insert rows into a table
	 */
	public function insert(string $table): Insert
	{
		return new Insert($this, $table);
	}

	/**
	 * Select rows from a table
	 * @param array<string>|string $columns
	 */
	public function select(array|string $columns): Select
	{
		return new Select($this, $columns);
	}

	/**
	 * Update rows in a table
	 */
	public function update(string $table): Update
	{
		return new Update($this, $table);
	}
}

enum Driver: string
{
	case Mysql = 'mysql';
	case Postgresql = 'pgsql';
	case Sqlite = 'sqlite';
}
