<?php

namespace Slab\DB\Query;

use Slab\DB\DatabaseConnection;

/**
 * Select Query
 *
 * @package default
 * @author Luke Lanchester
 **/
// class SelectQuery extends BaseWhereQuery {
class SelectQuery {


	/**
	 * Set select fields
	 *
	 * @param mixed Field
	 * @return self
	 **/
	public function select() {

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



	/**
	 * Join a table
	 *
	 * @param mixed Table
	 * @param string Join type
	 * @return self
	 **/
	public function join($table, $type = null) {

		return $this;

	}



	/**
	 * Left join a table
	 *
	 * @param mixed Table
	 * @return self
	 **/
	public function leftJoin($table) {

		return $this->join($table, 'left');

	}



	/**
	 * Set join condition
	 *
	 * @param mixed Field or expression
	 * @param string Comparison operator
	 * @param mixed Comparison field or expression
	 * @return self
	 **/
	public function on($field1, $operator = null, $field2 = null) {

		return $this;

	}



	/**
	 * Add a where condition
	 *
	 * @param mixed Expression or field
	 * @param string Operator
	 * @param mixed Value
	 * @return self
	 **/
	public function where($expr, $operator = null, $value = null) {

		return $this;

	}



	/**
	 * Add an or condition
	 *
	 * @param mixed Expression or field
	 * @param string Operator
	 * @param mixed Value
	 * @return self
	 **/
	public function orWhere($expr, $operator = null, $value = null) {

		return $this;

	}



	/**
	 * Add a where field is null condition
	 *
	 * @param string Field
	 * @return self
	 **/
	public function whereNull($field) {

		return $this;

	}



	/**
	 * Add a where field is not null condition
	 *
	 * @param string Field
	 * @return self
	 **/
	public function whereNotNull($field) {

		return $this;

	}



	/**
	 * Add a where between condition
	 *
	 * @param string Field
	 * @param mixed Min value, inclusive
	 * @param mixed Max value, inclusive
	 * @return self
	 **/
	public function whereBetween($field, $min, $max) {

		return $this;

	}



	/**
	 * Add a where not between condition
	 *
	 * @param string Field
	 * @param mixed Min value, inclusive
	 * @param mixed Max value, inclusive
	 * @return self
	 **/
	public function whereNotBetween($field, $min, $max) {

		return $this;

	}



	/**
	 * Add a where in condition
	 *
	 * @param string Field
	 * @param array Values
	 * @return self
	 **/
	public function whereIn($field, array $values) {

		return $this;

	}



	/**
	 * Add a where not in condition
	 *
	 * @param string Field
	 * @param array Values
	 * @return self
	 **/
	public function whereNotIn($field, array $values) {

		return $this;

	}



	/**
	 * Add a having clasure
	 *
	 * @param mixed Field
	 * @param string Operator
	 * @param mixed Value
	 * @return self
	 **/
	public function having($field, $operator = null, $value = null) {

		return $this;

	}



	/**
	 * Order results by column
	 *
	 * @param string Column
	 * @param string Order
	 * @param bool Append?
	 * @return self
	 **/
	public function orderBy($column, $order = 'ASC', $append = false) {

		return $this;

	}



	/**
	 * Group results by column
	 *
	 * @param string Column
	 * @return self
	 **/
	public function groupBy($column) {

		return $this;

	}



	/**
	 * Set a limit on the number of results
	 *
	 * @param int Limit
	 * @return self
	 **/
	public function limit($limit, $offset = null) {

		if($offset !== null) {
			$this->offset($offset);
		}

		return $this;

	}



	/**
	 * Set an initial offset of results
	 *
	 * @param int Offer
	 * @return self
	 **/
	public function offset($offset) {

		return $this;

	}



	/**
	 * Convert query to SQL
	 *
	 * @return string SQL
	 **/
	public function sql() {

		return '@todo generate SQL';

	}



	// get
	// first
	// col



	/**
	 * Escape a raw SQL fragment
	 *
	 * @param string Raw SQL
	 * @param mixed Params
	 * @return string Escaped SQL
	 **/
	public function raw($sql) {

		// @todo escape func_get_args

		return $sql;

	}



}
