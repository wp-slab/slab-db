<?php

namespace Slab\DB\Query;

use LogicException;

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
	 * @var mixed From table expression
	 **/
	protected $from;


	/**
	 * @var array Select field expressions
	 **/
	protected $select = [];


	/**
	 * @var array Join expressions
	 **/
	protected $joins = [];


	/**
	 * @var array Where conditions
	 **/
	protected $wheres = [];


	/**
	 * @var array Having conditions
	 **/
	protected $havings = [];


	/**
	 * @var array Orders
	 **/
	protected $orders = [];


	/**
	 * @var array Groups
	 **/
	protected $groups = [];


	/**
	 * @var int Limit
	 **/
	protected $limit = null;


	/**
	 * @var int Offset
	 **/
	protected $offset = null;


	/**
	 * Set select fields
	 *
	 * @param mixed Field expression
	 * @return self
	 **/
	public function select() {

		$this->select = []; // reset select fields

		return $this->addSelects(func_get_args());

	}



	/**
	 * Add multiple select fields
	 *
	 * @param array Field expressions
	 * @return self
	 **/
	public function addSelects(array $fields) {

		foreach($fields as $field) {
			$this->addSelect($field);
		}

		return $this;

	}



	/**
	 * Add a select field
	 *
	 * @param mixed Field expression
	 * @return self
	 **/
	public function addSelect($field) {

		$this->select[] = $field; // @todo check?

		return $this;

	}



	/**
	 * Set from table
	 *
	 * @param mixed Table expression
	 * @return self
	 **/
	public function from($table) {

		$this->from = $table;

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

		$this->joins[] = [$table, $type, null];

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

		if(empty($this->joins)) {
			throw new LogicException('A join must be created before on conditions can be added');
		}

		$index = count($this->joins) - 1;

		$this->joins[$index][2] = [$field1, $operator, $field2];

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

		$this->wheres[] = [$expr, $operator, $value];

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

		// @todo

		return $this;

	}



	/**
	 * Add a where field is null condition
	 *
	 * @param string Field
	 * @return self
	 **/
	public function whereNull($field) {

		$this->wheres[] = [$expr, 'is null', null];

		return $this;

	}



	/**
	 * Add a where field is not null condition
	 *
	 * @param string Field
	 * @return self
	 **/
	public function whereNotNull($field) {

		$this->wheres[] = [$expr, 'is not null', null];

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

		$this->wheres[] = [$expr, 'between', [$min, $max]];

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

		$this->wheres[] = [$expr, 'not between', [$min, $max]];

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

		$this->wheres[] = [$expr, 'in', $values];

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

		$this->wheres[] = [$expr, 'not in', $values];

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

		$this->havings[] = [$field, $operator, $value];

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

		if($append === true) {
			$this->orders[] = [$column, $order];
		} else {
			$this->orders = [[$column, $order]];
		}

		return $this;

	}



	/**
	 * Group results by column
	 *
	 * @param string Column
	 * @return self
	 **/
	public function groupBy($column) {

		$this->groups[] = $column;

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

		$this->limit = max(1, intval($limit));

		return $this;

	}



	/**
	 * Set an initial offset of results
	 *
	 * @param int Offer
	 * @return self
	 **/
	public function offset($offset) {

		$this->offset = max(0, intval($offset));

		return $this;

	}



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



	/**
	 * Convert query to SQL
	 *
	 * @return string SQL
	 **/
	public function sql() {

		return '@todo generate SQL';

	}



	/**
	 * Get all results
	 *
	 * @return array Collection
	 **/
	public function get() {

		return [];

	}



	/**
	 * Get first row
	 *
	 * @return object Row
	 **/
	public function first() {

		return null;

	}



	/**
	 * Get a column, optionally keyed
	 *
	 * @param string Column
	 * @param string Key
	 * @return array Column
	 **/
	public function col($column = null, $key = null) {

		return [];

	}



}