<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes\Action;

use InvalidArgumentException;

trait Where
{
	/** @var array<array<string>|string> */
	private array $where = [];

	/**
	 * Define the where clauses
	 * @param array<string>|string $where
	 */
	public function where(array|string $where): static
	{
		if (is_array($where)) {
			$count = count(array_filter($where, function ($condition) {
				return ! is_string($condition);
			}));

			if ($count > 0) {
				throw new InvalidArgumentException('meh');
			}
		}

		array_push($this->where, $where);

		return $this;
	}

	private function getWhereQueryPart(): string
	{
		if (count($this->where) === 0) {
			return '';
		}

		$where = [];

		foreach ($this->where as $condition) {
			if (is_string($condition)) {
				$where[] = $condition;
			} else {
				$where[] = join(' and ', $condition);
			}
		}

		if (count($where) === 1) {
			return sprintf(' where %s', $where[0]);
		}

		return sprintf(' where %s', join(' or ', array_map(function ($condition) {
			return sprintf('(%s)', $condition);
		}, $where)));
	}
}
