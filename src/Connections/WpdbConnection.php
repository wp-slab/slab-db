<?php

namespace Slab\DB\Connections;

use RuntimeException;
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
	 * @return int|false Rows affected
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
	 * @return array|false Rows
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
	 * @param bool Return insert ID
	 * @return array|false [int Rows affected, int Insert ID]
	 **/
	public function insert($sql, array $params = null, $fetch_insert_id = true) {

		if($params !== null) {
			$sql = $this->escapeQuery($sql, $params);
		}

		$conn = $this->getConnection();

		$result = $conn->query($sql);

		if($result === false) {
			return false;
		}

		$insert_id = $fetch_insert_id ? (int) $conn->insert_id : null;

		return [(int) $result, $insert_id];

	}



	/**
	 * Execute an UPDATE query
	 *
	 * @param string SQL
	 * @param array Query params
	 * @return int|false Rows affected
	 **/
	public function update($sql, array $params = null) {

		if($params !== null) {
			$sql = $this->escapeQuery($sql, $params);
		}

		$conn = $this->getConnection();

		return $conn->query($sql);

	}



	/**
	 * Execute a DELETE query
	 *
	 * @param string SQL
	 * @param array Query params
	 * @return int|false Rows affected
	 **/
	public function delete($sql, array $params = null) {

		if($params !== null) {
			$sql = $this->escapeQuery($sql, $params);
		}

		$conn = $this->getConnection();

		return $conn->query($sql);

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

		if(is_a($table, 'Closure')) {
			return $table->__invoke($this);
		}

		if(is_array($table)) {
			if(!empty($table[0]) and !empty($table[1])) {
				return "`{$table[0]}` as `{$table[1]}`";
			} else {
				throw new RuntimeException('Table aliases must have two parameters');
			}
		}

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

		if(is_a($column, 'Closure')) {
			return $column->__invoke($this);
		}

		if(is_array($column)) {
			if(!empty($column[0]) and !empty($column[1])) {
				return "`{$column[0]}` as `{$column[1]}`";
			} else {
				throw new RuntimeException('Column aliases must have two parameters');
			}
		}

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
