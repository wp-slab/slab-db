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



	/**
	 * Test the most basic type of query
	 *
	 * @return void
	 **/
	public function testBasicQuery() {

		$raw_sql = 'select name from people';
		$expected_results = 1;

		$wpdb = m::mock('wpdb');
		$wpdb->shouldReceive('query')->once()->with($raw_sql)->andReturn($expected_results);

		$conn = new WpdbConnection($wpdb);
		$output_results = $conn->query($raw_sql);

		$this->assertEquals($expected_results, $output_results);

	}



	/**
	 * Test the most basic type of query
	 *
	 * @return void
	 **/
	public function testBasicQueryParams() {

		$raw_sql = 'select name from people where name = %s and age = %d';
		$raw_params = ['john', 19];
		$expected_sql = 'select name from people where name = "john" and age = 19';
		$expected_results = 1;

		$wpdb = m::mock('wpdb');
		$wpdb->shouldReceive('prepare')->once()->with($raw_sql, $raw_params)->andReturn($expected_sql);
		$wpdb->shouldReceive('query')->once()->with($expected_sql)->andReturn($expected_results);

		$conn = new WpdbConnection($wpdb);
		$output_results = $conn->query($raw_sql, $raw_params);

		$this->assertEquals($expected_results, $output_results);

	}



	/**
	 * Test a select query
	 *
	 * @return void
	 **/
	public function testSelectQuery() {

		$raw_sql = 'select name from people';
		$expected_results = [['one']];

		$wpdb = m::mock('wpdb');
		$wpdb->shouldReceive('get_results')->once()->with($raw_sql)->andReturn($expected_results);

		$conn = new WpdbConnection($wpdb);
		$output_results = $conn->select($raw_sql);

		$this->assertEquals($expected_results, $output_results);

	}



	/**
	 * Test a select query with params
	 *
	 * @return void
	 **/
	public function testSelectQueryParams() {

		$raw_sql = 'select name from people where name = %s and age = %d';
		$raw_params = ['john', 19];
		$expected_sql = 'select name from people where name = "john" and age = 19';
		$expected_results = [['one']];

		$wpdb = m::mock('wpdb');
		$wpdb->shouldReceive('prepare')->once()->with($raw_sql, $raw_params)->andReturn($expected_sql);
		$wpdb->shouldReceive('get_results')->once()->with($expected_sql)->andReturn($expected_results);

		$conn = new WpdbConnection($wpdb);
		$output_results = $conn->select($raw_sql, $raw_params);

		$this->assertEquals($expected_results, $output_results);

	}



	/**
	 * Test an insert query
	 *
	 * @return void
	 **/
	public function testInsertQuery() {

		$raw_sql = 'insert into people (name, age) values ("john", 19), ("andy", 17)';
		$expected_results = [2, 123];

		$wpdb = m::mock('wpdb');
		$wpdb->shouldReceive('query')->once()->with($raw_sql)->andSet('insert_id', $expected_results[1])->andReturn($expected_results[0]);

		$conn = new WpdbConnection($wpdb);
		$output_results = $conn->insert($raw_sql);

		$this->assertEquals($expected_results, $output_results);

	}



	/**
	 * Test an insert query with params
	 *
	 * @return void
	 **/
	public function testInsertQueryParams() {

		$raw_sql = 'insert into people (name, age) values (%s, %d), (%s, %d)';
		$raw_params = ['john', 19, 'andy', 17];
		$expected_sql = 'insert into people (name, age) values ("john", 19), ("andy", 17)';
		$expected_results = [2, 123];

		$wpdb = m::mock('wpdb');
		$wpdb->shouldReceive('prepare')->once()->with($raw_sql, $raw_params)->andReturn($expected_sql);
		$wpdb->shouldReceive('query')->once()->with($expected_sql)->andSet('insert_id', $expected_results[1])->andReturn($expected_results[0]);

		$conn = new WpdbConnection($wpdb);
		$output_results = $conn->insert($raw_sql, $raw_params);

		$this->assertEquals($expected_results, $output_results);

	}



	/**
	 * Test an insert query with params but no insert id
	 *
	 * @return void
	 **/
	public function testInsertQueryParamsNoId() {

		$raw_sql = 'insert into people (name, age) values (%s, %d), (%s, %d)';
		$raw_params = ['john', 19, 'andy', 17];
		$expected_sql = 'insert into people (name, age) values ("john", 19), ("andy", 17)';
		$expected_results = [2, null];

		$wpdb = m::mock('wpdb');
		$wpdb->shouldReceive('prepare')->once()->with($raw_sql, $raw_params)->andReturn($expected_sql);
		$wpdb->shouldReceive('query')->once()->with($expected_sql)->andReturn($expected_results[0]);

		$conn = new WpdbConnection($wpdb);
		$output_results = $conn->insert($raw_sql, $raw_params, false);

		$this->assertEquals($expected_results, $output_results);

	}



	/**
	 * Test an update query
	 *
	 * @return void
	 **/
	public function testUpdateQuery() {

		$raw_sql = 'update people set age = 17 where age > 21';
		$expected_results = 2;

		$wpdb = m::mock('wpdb');
		$wpdb->shouldReceive('query')->once()->with($raw_sql)->andReturn($expected_results);

		$conn = new WpdbConnection($wpdb);
		$output_results = $conn->update($raw_sql);

		$this->assertEquals($expected_results, $output_results);

	}



	/**
	 * Test an update query with params
	 *
	 * @return void
	 **/
	public function testUpdateQueryParams() {

		$raw_sql = 'update people set age = %d where age > %d';
		$raw_params = [17, 21];
		$expected_sql = 'update people set age = 17 where age > 21';
		$expected_results = 2;

		$wpdb = m::mock('wpdb');
		$wpdb->shouldReceive('prepare')->once()->with($raw_sql, $raw_params)->andReturn($expected_sql);
		$wpdb->shouldReceive('query')->once()->with($expected_sql)->andReturn($expected_results);

		$conn = new WpdbConnection($wpdb);
		$output_results = $conn->query($raw_sql, $raw_params);

		$this->assertEquals($expected_results, $output_results);

	}



	/**
	 * Test a delete query
	 *
	 * @return void
	 **/
	public function testDeleteQuery() {

		$raw_sql = 'delete from people where age > 21';
		$expected_results = 2;

		$wpdb = m::mock('wpdb');
		$wpdb->shouldReceive('query')->once()->with($raw_sql)->andReturn($expected_results);

		$conn = new WpdbConnection($wpdb);
		$output_results = $conn->delete($raw_sql);

		$this->assertEquals($expected_results, $output_results);

	}



	/**
	 * Test a delete query with params
	 *
	 * @return void
	 **/
	public function testDeleteQueryParams() {

		$raw_sql = 'delete from people where age > %d';
		$raw_params = [21];
		$expected_sql = 'delete from people where age > 21';
		$expected_results = 2;

		$wpdb = m::mock('wpdb');
		$wpdb->shouldReceive('prepare')->once()->with($raw_sql, $raw_params)->andReturn($expected_sql);
		$wpdb->shouldReceive('query')->once()->with($expected_sql)->andReturn($expected_results);

		$conn = new WpdbConnection($wpdb);
		$output_results = $conn->delete($raw_sql, $raw_params);

		$this->assertEquals($expected_results, $output_results);

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
