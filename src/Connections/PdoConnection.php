<?php

namespace Slab\DB\Connections;

use Slab\DB\QueryCompilers\MysqlQueryCompiler;

/**
 * PDO Connection
 *
 * @package default
 * @author Luke Lanchester
 **/
class PdoConnection implements ConnectionInterface {


	/**
	 * Get compiler for this connection
	 *
	 * @return Slab\DB\QueryCompilers\MysqlQueryCompiler
	 **/
	public function getCompiler() {

		return new MysqlCompiler($this);

	}



	/**
	 * Execute a query
	 *
	 * @param string SQL
	 * @return array Rows
	 **/
	public function query($sql) {

		global $wpdb; // @todo obvs replace with PDO connection

		return $wpdb->get_results($sql);

	}



}
