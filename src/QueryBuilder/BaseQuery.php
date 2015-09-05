<?php

namespace Slab\DB\QueryBuilder;

use Slab\DB\DatabaseConnection;

/**
 * Base Query Builder
 *
 * @package default
 * @author Luke Lanchester
 **/
abstract class BaseQueryBuilder {


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
