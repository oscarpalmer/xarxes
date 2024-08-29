<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes\Action;

use InvalidArgumentException;
use LogicException;
use oscarpalmer\Xarxes\Manager;

final class Select extends Runnable
{
	use Where;

	/** @var array<string> */
	private array $columns = [];

	/** @var array<string> */
	private array $tables = [];

	/**
	 * @param array<string>|string $columns
	 */
	public function __construct(Manager $manager, array|string $columns)
	{
		parent::__construct($manager);

		if (is_array($columns)) {
			$count = count(array_filter($columns, function ($column) {
				return ! is_string($column);
			}));

			if ($count > 0) {
				throw new InvalidArgumentException('meh');
			}
		}

		array_push($this->columns, ...(is_array($columns) ? $columns : [$columns]));
	}

	/**
	 * @param array<string>|string $tables
	 */
	public function from(array|string $tables): Select
	{
		if (count($this->tables) > 0) {
			throw new LogicException('');
		}

		if (is_array($tables)) {
			$count = count(array_filter($tables, function ($table) {
				return ! is_string($table);
			}));

			if ($count > 0) {
				throw new InvalidArgumentException('Select tables must be strings');
			}
		}

		array_push($this->tables, ...(is_array($tables) ? $tables : [$tables]));

		return $this;
	}

	/**
	 * Get the query to select columns from tables
	 */
	public function getQuery(): string
	{
		$columns = join(', ', $this->columns);
		$tables = join(', ', $this->tables);

		return sprintf('select %s from %s%s', $columns, $tables, $this->getWhereQueryPart());
	}

	/**
	 * - Execute the query to select columns from tables
	 * - Returns an array of rows
	 * @return array<mixed>
	 */
	public function run(): array
	{
		$prepared = $this->prepare();

		$prepared->execute();

		return $prepared->fetchAll();
	}
}
