<?php

namespace Slab\DB;

use Slab\DB\Query\SelectQuery;

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
	 **/
	public function connection($group = null) {

		return new DatabaseConnection;

	}



	/**
	 * Make a Select Query
	 *
	 * @return Slab\DB\Query\SelectQuery
	 **/
	public function select($field = null) {

		$conn = $this->connection();

		$query = new SelectQuery($conn);

		if($field !== null) {
			$query->addSelects(func_get_args());
		}

		return $query;

	}



}
