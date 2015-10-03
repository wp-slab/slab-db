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



}
