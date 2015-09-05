<?php

namespace Slab\DB\Query;

use Slab\DB\DatabaseConnection;

/**
 * Base Where Query
 *
 * @package default
 * @author Luke Lanchester
 **/
abstract class BaseWhereQuery extends BaseQuery {

	// where
	// order_by
	// limit
	// offset


	/**
	 * @var array Select fields
	 **/
	protected $fields = [];


	/**
	 * Add select field
	 *
	 * @param mixed Field
	 * @return self
	 **/
	public function select($field) {

		$this->fields[] = $field;

		return $this;

	}



	/**
	 * Add select fields
	 *
	 * @param array Fields
	 * @return self
	 **/
	public function selects(array $fields) {

		foreach($fields as $field) {
			$this->select($field);
		}

		return $this;

	}



	/**
	 * Set from table
	 *
	 * @param mixed Table
	 * @return self
	 **/
	public function from($table) {

		return $this;

	}
}
