<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes;

final class Xarxes
{
	public const VERSION = '0.4.0';

	/**
	 * @param array<mixed, mixed> $options
	 */
	public static function mysql(
		string $database,
		?string $username = null,
		?string $password = null,
		?array $options = null,
	): Manager {
		return new Manager(Driver::Mysql, $database, $username, $password, $options);
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
		return new Manager(Driver::Postgresql, $database, $username, $password, $options);
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
		return new Manager(Driver::Sqlite, $database, $username, $password, $options);
	}
}
