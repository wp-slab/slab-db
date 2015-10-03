<?php

namespace Slab\DB;

use Slab\DB\Connections\WpdbConnection;
use Slab\DB\QueryBuilder\SelectQueryBuilder;

/**
 * Database Connection Manager
 *
 * @package default
 * @author Luke Lanchester
 **/
class DatabaseManager {


	/**
	 * Get a database connection
	 *
	 * @return Slab\DB\DatabaseConnection
	 * @todo set default to be global wpdb connection
	 **/
	public function connection($group = null) {

		global $wpdb;

		return new WpdbConnection($wpdb);

	}



	/**
	 * Make a Select Query
	 *
	 * @return Slab\DB\QueryBuilder\SelectQueryBuilder
	 **/
	public function select($field = null) {

		$connection = $this->connection();
		$compiler = $connection->getCompiler();

		$query = new SelectQueryBuilder($connection, $compiler);

		if($field !== null) {
			$query->addSelects(func_get_args());
		}

		return $query;

	}






	/**
	 * Perform a raw query
	 *
	 * @param string SQL
	 * @param array Query params
	 * @return bool Result
	 **/
	public function queryRaw($sql, array $params = null) {

		return $this->connection()->query($sql, $params);

	}



	/**
	 * Perform a raw select query
	 *
	 * @param string SQL
	 * @param array Query params
	 * @return array Rows
	 **/
	public function selectRaw($sql, array $params = null) {

		return $this->connection()->select($sql, $params);

	}



	/**
	 * Perform a raw insert query
	 *
	 * @param string SQL
	 * @param array Query params
	 * @param bool Return insert ID
	 * @return array|false [int Rows affected, int Insert ID]
	 **/
	public function insertRaw($sql, array $params = null, $fetch_insert_id = true) {

		return $this->connection()->insert($sql, $params, $fetch_insert_id);

	}



	/**
	 * Perform a raw update query
	 *
	 * @param string SQL
	 * @param array Query params
	 * @return int|false Rows affected
	 **/
	public function updateRaw($sql, array $params = null) {

		return $this->connection()->update($sql, $params);

	}



	/**
	 * Perform a raw delete query
	 *
	 * @param string SQL
	 * @param array Query params
	 * @return int|false Rows affected
	 **/
	public function deleteRaw($sql, array $params = null) {

		return $this->connection()->delete($sql, $params);

	}



}
