<?php

namespace Slab\DB;

use Slab\DB\Connections\PdoConnection;
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

		return new PdoConnection;

	}



	/**
	 * Make a Select Query
	 *
	 * @return Slab\DB\Query\SelectQuery
	 **/
	public function select($field = null) {

		$connection = $this->connection();
		$compiler = $connection->getCompiler();

		$query = new SelectQuery($connection, $compiler);

		if($field !== null) {
			$query->addSelects(func_get_args());
		}

		return $query;

	}



}
