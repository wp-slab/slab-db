<?php

use Mockery as m;

use Slab\DB\Connections\WpdbConnection;

/**
 * Test WpdbConnection
 *
 * @package default
 * @author Luke Lanchester
 **/
class WpdbConnectionTest extends PHPUnit_Framework_TestCase {


	/**
	 * Test can instantiate connection
	 *
	 * @return void
	 **/
	public function testCanInstantiateConnection() {

		$wpdb = m::mock('wpdb');

		$conn = new WpdbConnection($wpdb);

		$this->assertInstanceOf('Slab\DB\Connections\WpdbConnection', $conn);

	}



	/**
	 * Test can get the underlying wpdb connection
	 *
	 * @return void
	 **/
	public function testCanGetUnderlyingConnection() {

		$wpdb = m::mock('wpdb');

		$conn = new WpdbConnection($wpdb);

		$this->assertEquals($wpdb, $conn->getConnection());

	}



	/**
	 * Test can get connection compiler
	 *
	 * @return void
	 **/
	public function testCanGetCompiler() {

		$wpdb = m::mock('wpdb');

		$conn = new WpdbConnection($wpdb);

		$this->assertInstanceOf('Slab\DB\Compilers\MysqlCompiler', $conn->getCompiler());

	}



	 * Tear down tests
	 *
	 * @return void
	 **/
	public function tearDown() {

		m::close();

	}



}
