<?php

use Mockery as m;

use Slab\DB\QueryBuilder\SelectQueryBuilder;

/**
 * Test SelectQuery
 *
 * @package default
 * @author Luke Lanchester
 **/
class SelectQueryTest extends PHPUnit_Framework_TestCase {


	/**
	 * Test can instantiate query
	 *
	 * @return void
	 **/
	public function testCanInstantiateQuery() {

		$db = m::mock('Slab\DB\Connections\ConnectionInterface');
		$compiler = m::mock('Slab\DB\QueryCompilers\QueryCompilerInterface');

		$query = new SelectQueryBuilder($db, $compiler);

		$this->assertInstanceOf('Slab\DB\QueryBuilder\SelectQueryBuilder', $query);

	}



	/**
	 * Test a basic query
	 *
	 * @return void
	 **/
	public function testSelect() {

		$db = m::mock('Slab\DB\Connections\ConnectionInterface');
		$compiler = m::mock('Slab\DB\QueryCompilers\QueryCompilerInterface');

		$query = new SelectQueryBuilder($db, $compiler);
		$query->select('id', 'name');

		$this->assertAttributeEquals(['id', 'name'], 'selects', $query);

	}



	/**
	 * Test a basic query
	 *
	 * @return void
	 **/
	public function testBasicQuery() {

		$db = m::mock('Slab\DB\Connections\ConnectionInterface');

		$compiler = m::mock('Slab\DB\QueryCompilers\QueryCompilerInterface');
		$compiler->shouldReceive('compileSelect')->once()->andReturn('select `id`, `name` from my_table');

		$query = new SelectQueryBuilder($db, $compiler);
		$query->select('id', 'name');
		$query->from('my_table');

		$this->assertEquals('select `id`, `name` from my_table', $query->sql());

	}



	/**
	 * Tear down tests
	 *
	 * @return void
	 **/
	public function tearDown() {

		m::close();

	}



}
