<?php

use oscarpalmer\Xarxes\Xarxes;

require(__DIR__ . '/../vendor/autoload.php');

$manager = Xarxes::sqlite(__DIR__ . '/test.db');

foreach (['blah', 'person'] as $table) {
	$manager
	->query(sprintf('drop table if exists %s', $table))
	->run();
}

$manager
	->create('person')
	->columns([
		'id integer auto_increment primarykey',
		'name text not null',
		'age integer not null',
	])
	->run();

$manager
	->insert('person')
	->columns(['id', 'name', 'age'])
	->values([':id', ':name', ':age'])
	->parameters([
		':id' => 1,
		':name' => 'Oscar',
		':age' => -1,
	])
	->run();

$manager
	->update('person')
	->set([
		'name = :name',
		'age = :age'
	])
	->where('id = :id')
	->parameters([
		':id' => 1,
		':name' => 'Oscar Palmér',
		':age' => 31
	])
	->run();
