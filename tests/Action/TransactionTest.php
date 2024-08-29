<?php

declare(strict_types=1);

namespace oscarpalmer\Xarxes\Test\Action;

use oscarpalmer\Xarxes\Manager;
use oscarpalmer\Xarxes\Xarxes;
use PHPUnit\Framework\TestCase;

final class TransactionTest extends TestCase
{
	private Manager $manager;

	public function setUp(): void
	{
		$this->manager = Xarxes::sqlite(__DIR__ . '/../test.db');
	}

	public function testError(): void
	{
		try {
			$this->manager->transaction(function () {
				$this->manager->insert('person')
					->columns(['id', 'name', 'age'])
					->values([':id', ':name', ':age'])
					->parameters([
						':id' => 3,
						':name' => 'Test',
						':age' => 123
					])
					->run();

				throw new \Exception('Halting transaction');
			});
		} catch (\Exception $exception) {
			$this->assertInstanceOf(\Exception::class, $exception);
			$this->assertEquals('Halting transaction', $exception->getMessage());

			$this->assertCount(2, $this->manager->select('*')->from('person')->run());
		}
	}

	public function testFalse(): void
	{
		$this->manager->transaction(function () {
			$this->manager->insert('person')
				->columns(['id', 'name', 'age'])
				->values([':id', ':name', ':age'])
				->parameters([
					':id' => 3,
					':name' => 'Test',
					':age' => 123
				])
				->run();

			return false;
		});

		$this->assertCount(2, $this->manager->select('*')->from('person')->run());
	}

	public function testTrue(): void
	{
		$this->manager->transaction(function () {
			$this->manager->insert('person')
				->columns(['id', 'name', 'age'])
				->values([':id', ':name', ':age'])
				->parameters([
					':id' => 3,
					':name' => 'Test',
					':age' => 123
				])
				->run();

			return true;
		});

		$persons = $this->manager->select('*')->from('person')->run();

		$this->assertCount(3, $persons);
		$this->assertEquals('Test', $persons[2]['name']);
		$this->assertEquals(123, $persons[2]['age']);
	}
}
