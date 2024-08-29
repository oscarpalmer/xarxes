<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes\Action;

use InvalidArgumentException;
use LogicException;
use oscarpalmer\Xarxes\Manager;

final class Insert extends Runnable
{
	/** @var array<string> */
	private array $columns = [];

	/** @var array<scalar> */
	private array $values = [];

	public function __construct(Manager $manager, private readonly string $table)
	{
		parent::__construct($manager);
	}

	/**
	 * Define the columns to insert into
	 * @param array<string> $columns
	 */
	public function columns(array $columns): Insert
	{
		if (count($this->columns) > 0) {
			throw new LogicException('Insert columns can only be set once');
		}

		$count = count(array_filter($columns, function ($column) {
			return ! is_string($column);
		}));

		if ($count > 0) {
			throw new InvalidArgumentException('Insert columns must be strings');
		}

		array_push($this->columns, ...$columns);

		return $this;
	}

	/**
	 * Get the query to insert rows into the table
	 */
	public function getQuery(): string
	{
		return sprintf(
			'insert into %s (%s) values (%s)',
			$this->table,
			join(', ', $this->columns),
			$this->getValuesQueryPart(),
		);
	}

	/**
	 * Execute the query to insert rows into the table
	 */
	public function run(): bool
	{
		$prepared = $this->prepare();

		$prepared->execute();

		return $prepared->rowCount() === 1;
	}

	/**
	 * Define the values to insert into the columns
	 * @param array<scalar> $values
	 */
	public function values(array $values): Insert
	{
		if (count($this->values) > 0) {
			throw new LogicException('Insert values can only be set once');
		}

		array_push($this->values, ...$values);

		return $this;
	}

	private function getValuesQueryPart(): string
	{
		if (count($this->values) !== count($this->columns)) {
			throw new LogicException('Insert values must match the number of columns');
		}

		return join(', ', array_map(function ($value) {
			return is_string($value) && ! str_starts_with($value, ':') ? sprintf("'%s'", $value) : $value;
		}, $this->values));
	}
}
