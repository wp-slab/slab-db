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
	 * Tear down tests
	 *
	 * @return void
	 **/
	public function tearDown() {

		m::close();

	}



}
