<?php

namespace Slab\DB\QueryBuilder;

use Slab\DB\DatabaseConnection;

/**
 * Base Where Query Builder
 *
 * @package default
 * @author Luke Lanchester
 **/
abstract class BaseWhereQueryBuilder extends BaseQueryBuilder {

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
