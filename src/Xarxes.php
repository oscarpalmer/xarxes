<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes;

final class Xarxes
{
	public const VERSION = '0.2.0';

	/**
	 * @param array<mixed, mixed> $options
	 */
	public static function mysql(
		string $database,
		?string $username = null,
		?string $password = null,
		?array $options = null,
	): Manager {
		return new Manager('mysql', $database, $username, $password, $options);
	}

	/**
	 * @param array<mixed, mixed> $options
	 */
	public static function postgresql(
		string $database,
		?string $username = null,
		?string $password = null,
		?array $options = null,
	): Manager {
		return new Manager('pgsql', $database, $username, $password, $options);
	}

	/**
	 * @param array<mixed, mixed> $options
	 */
	public static function sqlite(
		string $database,
		?string $username = null,
		?string $password = null,
		?array $options = null,
	): Manager {
		return new Manager('sqlite', $database, $username, $password, $options);
	}
}
