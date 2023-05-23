<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes\Action;

use InvalidArgumentException;
use LogicException;
use oscarpalmer\Xarxes\Manager;

final class Select extends Runnable
{
	private array $columns = [];
	private array $conditions = [];
	private array $tables = [];

	public function __construct(Manager $manager, array|string $columns)
	{
		parent::__construct($manager);

		if (is_array($columns) && count(array_filter($columns, function ($column) { return ! is_string($column); })) > 0) {
			throw new InvalidArgumentException('meh');
		}

		array_push($this->columns, ...(is_array($columns) ? $columns : [$columns]));
	}

	public function __toString(): string
	{
		return $this->getQuery();
	}

	public function from(array|string $tables): Select
	{
		if (count($this->tables) > 0) {
			throw new LogicException('');
		}

		if (is_array($tables) && count(array_filter($tables, function ($table) { return ! is_string($table); })) > 0) {
			throw new InvalidArgumentException('meh');
		}

		array_push($this->tables, ...(is_array($tables) ? $tables : [$tables]));

		return $this;
	}

	public function getQuery(): string
	{
		$columns = join(', ', $this->columns);
		$tables = join(', ', $this->tables);

		$conditions = count($this->conditions) > 0
			? sprintf(' where %s', join(' or ', $this->conditions))
			: '';

		return sprintf('select %s from %s%s', $columns, $tables, $conditions);
	}

	public function run(): array
	{
		return $this->execute()->fetchAll();
	}

	public function where(array|string $conditions): Select
	{
		if (is_array($conditions) && count(array_filter($conditions, function ($condition) { return ! is_string($condition); })) > 0) {
			throw new InvalidArgumentException('meh');
		}

		array_push($this->conditions, ...(is_array($conditions) ? $conditions : [$conditions]));

		return $this;
	}
}
