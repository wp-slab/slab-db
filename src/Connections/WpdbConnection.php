<?php

namespace Slab\DB\Connections;

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
	 * Execute a query
	 *
	 * @param string SQL
	 * @return array Rows
	 **/
	public function query($sql) {

		return $this->getConnection()->get_results($sql);

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
	 * Get a connection
	 *
	 * @return WPDB connection
	 **/
	public function getConnection() {

		if($this->connection !== null) {
			return $this->connection;
		}

		global $wpdb;

		return $this->connection = $wpdb;

	}



}
