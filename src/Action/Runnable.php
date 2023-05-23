<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes\Action;

use oscarpalmer\Xarxes\Manager;
use PDOStatement;

abstract class Runnable
{
	private array $parameters = [];

	public function __construct(private readonly Manager $manager)
	{
	}

	public function parameters(array $parameters): static
	{
		$this->parameters = array_merge($this->parameters, $parameters);

		return $this;
	}

	protected function execute(): PDOStatement
	{
		$statement = $this->manager
			->getPdo()
			->prepare($this->getQuery());

		foreach ($this->parameters as $key => $value) {
			$statement->bindParam($key, $value);
		}

		$statement->execute();

		return $statement;
	}

	abstract public function getQuery(): string;

	public function getParameters(): array
	{
		return $this->parameters;
	}
}
