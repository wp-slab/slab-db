<?php

use Mockery as m;

use Slab\DB\Query\SelectQuery;

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

		$query = new SelectQuery($db);

		$this->assertInstanceOf('Slab\DB\Query\SelectQuery', $query);

	}



	/**
	 * Test a basic query
	 *
	 * @return void
	 **/
	public function testSelect() {

		$db = m::mock('Slab\DB\Connections\ConnectionInterface');

		$query = new SelectQuery($db);
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

		$query = new SelectQuery($db);
		$query->select('id', 'name');
		$query->from('my_table');

		$this->assertEquals('select id, name from my_table', $query->sql());

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
