<?php

use Mockery as m;

/**
 * Test DB
 *
 * @package default
 * @author Luke Lanchester
 **/
class DbTest extends PHPUnit_Framework_TestCase {


	/**
	 * Stub test
	 *
	 * @return void
	 **/
	public function testTest() {

		$this->assertTrue(true);

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
