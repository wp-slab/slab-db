<?php

namespace Slab\DB\Query;

use Slab\DB\DatabaseConnection;

/**
 * Base Query
 *
 * @package default
 * @author Luke Lanchester
 **/
abstract class BaseQuery {


	/**
	 * @var Slab\DB\DatabaseConnection
	 **/
	protected $db;


	/**
	 * Constructor
	 *
	 * @param Slab\DB\DatabaseConnection
	 * @return void
	 **/
	public function __construct(DatabaseConnection $db) {

		$this->db = $db;

	}



}
