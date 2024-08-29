<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes\Action;

use oscarpalmer\Xarxes\Manager;
use PDOStatement;

abstract class Runnable
{
	/** @var array<int|string, mixed> */
	private array $parameters = [];

	public function __construct(private readonly Manager $manager)
	{
	}

	/**
	 * Get the query to run
	 */
	public function __toString(): string
	{
		return $this->getQuery();
	}

	/**
	 * Add parameters to the query
	 * @param array<int|string, mixed> $parameters
	 */
	public function parameters(array $parameters): static
	{
		$this->parameters = array_merge($this->parameters, $parameters);

		return $this;
	}

	abstract public function getQuery(): string;

	/**
	 * Get the parameters for the query
	 * @return array<int|string, mixed>
	 */
	public function getParameters(): array
	{
		return $this->parameters;
	}

	abstract public function run(): mixed;

	protected function prepare(): PDOStatement
	{
		$statement = $this->manager
			->getPdo()
			->prepare($this->getQuery());

		foreach ($this->parameters as $key => $value) {
			$statement->bindValue($key, $value);
		}

		return $statement;
	}
}
