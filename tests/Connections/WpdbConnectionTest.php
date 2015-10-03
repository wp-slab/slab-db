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



	/**
	 * Test escape query
	 *
	 * Note this doesn't actually test escaping or parsing
	 *
	 * @return void
	 **/
	public function testEscapeQuery() {

		$raw_sql = 'select * from people where name = %s and age > %d';
		$raw_params = ['john', 20];
		$expected_sql = 'select * from people where name = %s and age > %d';

		$wpdb = m::mock('wpdb');
		$wpdb->shouldReceive('prepare')->once()->with($raw_sql, $raw_params)->andReturn($expected_sql);

		$conn = new WpdbConnection($wpdb);
		$output_sql = $conn->escapeQuery($raw_sql, $raw_params);

		$this->assertEquals($expected_sql, $output_sql);

	}



	/**
	 * Test escape query with no params
	 *
	 * Note this doesn't actually test escaping or parsing
	 *
	 * @return void
	 **/
	public function testEscapeQueryNoParams() {

		$raw_sql = 'select * from people where name = "me"';
		$raw_params = null;
		$expected_sql = 'select * from people where name = "me"';

		$wpdb = m::mock('wpdb');
		$wpdb->shouldNotReceive('prepare');

		$conn = new WpdbConnection($wpdb);
		$output_sql = $conn->escapeQuery($raw_sql, $raw_params);

		$this->assertEquals($expected_sql, $output_sql);

	}



	/**
	 * Test escape a param
	 *
	 * Note this doesn't actually test escaping
	 *
	 * @return void
	 **/
	public function testEscapeParam() {

		$raw_param = 'value';
		$expected_param = 'value';

		$wpdb = m::mock('wpdb');
		$wpdb->shouldReceive('_real_escape')->once()->with($raw_param)->andReturn($expected_param);

		$conn = new WpdbConnection($wpdb);
		$output_param = $conn->escapeParam($raw_param);

		$this->assertEquals($expected_param, $output_param);

	}



	/**
	 * Test escaping a table reference
	 *
	 * @return void
	 * @dataProvider tableProvider
	 **/
	public function testEscapeTable($raw_table, $expected_table) {

		$wpdb = m::mock('wpdb');

		$conn = new WpdbConnection($wpdb);
		$output_table = $conn->escapeTable($raw_table);

		$this->assertEquals($expected_table, $output_table);

	}



	/**
	 * Data provider for escape tables
	 *
	 * @return array Tables
	 **/
	public function tableProvider() {

		return [
			['tbl', '`tbl`'],
			[['tbl', 't'], '`tbl` as `t`'],
			[function(){ return 'tbl'; }, 'tbl'],
		];

	}



	/**
	 * Test escaping a column reference
	 *
	 * @return void
	 * @dataProvider columnProvider
	 **/
	public function testEscapeColumn($raw_column, $expected_column) {

		$wpdb = m::mock('wpdb');

		$conn = new WpdbConnection($wpdb);
		$output_column = $conn->escapeColumn($raw_column);

		$this->assertEquals($expected_column, $output_column);

	}



	/**
	 * Data provider for escape columns
	 *
	 * @return array Columns
	 **/
	public function columnProvider() {

		return [
			['col', '`col`'],
			[['col', 'c'], '`col` as `c`'],
			[function(){ return 'col'; }, 'col'],
		];

	}


	 * Tear down tests
	 *
	 * @return void
	 **/
	public function tearDown() {

		m::close();

	}



}
