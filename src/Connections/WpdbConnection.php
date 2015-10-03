<?php

namespace Slab\DB\Connections;

use wpdb;

use Slab\DB\Compilers\MysqlCompiler;

/**
 * WPDB Connection
 *
 * @package default
 * @author Luke Lanchester
 **/
class WpdbConnection implements ConnectionInterface {


	/**
	 * @var WPDB Connection
	 **/
	protected $connection;


	/**
	 * Constructor
	 *
	 * @param wpdb WPDB instance
	 * @return void
	 **/
	public function __construct(wpdb $wpdb) {

		$this->connection = $wpdb;

	}



	/**
	 * Get compiler for this connection
	 *
	 * @return Slab\DB\Compilers\MysqlCompiler
	 **/
	public function getCompiler() {

		return new MysqlCompiler($this);

	}



	/**
	 * Execute a general query
	 *
	 * @param string SQL
	 * @param array Query params
	 * @return bool Result
	 **/
	public function query($sql, array $params = null) {

		if($params !== null) {
			$sql = $this->escapeQuery($sql, $params);
		}

		return $this->getConnection()->get_results($sql);

	}



	/**
	 * Execute a SELECT query
	 *
	 * @param string SQL
	 * @param array Query params
	 * @return array Rows
	 **/
	public function select($sql, array $params = null) {

		if($params !== null) {
			$sql = $this->escapeQuery($sql, $params);
		}

		return $this->getConnection()->get_results($sql);

	}



	/**
	 * Execute an INSERT query
	 *
	 * @param string SQL
	 * @param array Query params
	 * @return array [int Rows affected, int Insert ID]
	 * @todo stub
	 **/
	public function insert($sql, array $params = null) {

	}



	/**
	 * Execute an UPDATE query
	 *
	 * @param string SQL
	 * @param array Query params
	 * @return int Rows affected
	 * @todo stub
	 **/
	public function update($sql, array $params = null) {

	}



	/**
	 * Execute a DELETE query
	 *
	 * @param string SQL
	 * @param array Query params
	 * @return int Rows affected
	 * @todo stub
	 **/
	public function delete($sql, array $params = null) {

	}



	/**
	 * Escape an sql query
	 *
	 * @param string Query
	 * @param array Params
	 * @return string Escaped query
	 **/
	public function escapeQuery($sql, array $params = null) {

		if($params === null or empty($params)) {
			return $sql;
		}

		return $this->getConnection()->prepare($sql, $params);

	}



	/**
	 * Escape a param ref
	 *
	 * @param string Param
	 * @return string Escaped param
	 **/
	public function escapeParam($param) {

		return $this->getConnection()->_real_escape($param);

	}



	/**
	 * Escape a table ref
	 *
	 * @param string Table
	 * @return string Escaped table
	 * @todo stub
	 * @todo handle alias
	 **/
	public function escapeTable($table) {

		return "`$table`";

	}



	/**
	 * Escape a column ref
	 *
	 * @param string Column
	 * @return string Escaped column
	 * @todo stub
	 * @todo handle alias
	 **/
	public function escapeColumn($column) {

		return "`$column`";

	}



	/**
	 * Get a connection
	 *
	 * @return WPDB connection
	 **/
	public function getConnection() {

		return $this->connection;

	}



}
