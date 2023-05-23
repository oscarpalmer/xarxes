<?php

require(__DIR__ . '/../vendor/autoload.php');

$pdo = new PDO(sprintf('sqlite:%s', __DIR__ . '/test.db'));

$pdo->exec('drop table if exists person');

$pdo->exec(
	'create table person(' .
	' id integer auto_increment primarykey,' .
	' name text not null,' .
	' age integer not null' .
	');'
);

$pdo->exec("insert into person(id, name, age) values(1, 'Oscar', 31)");
