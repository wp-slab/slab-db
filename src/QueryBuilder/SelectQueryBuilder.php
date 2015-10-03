<?php

namespace Slab\DB\QueryBuilder;

use LogicException;

use Slab\DB\Compilers\CompilerInterface;
use Slab\DB\Connections\ConnectionInterface;

/**
 * Select Query
 *
 * @package default
 * @author Luke Lanchester
 **/
// class SelectQuery extends BaseWhereQuery {
class SelectQueryBuilder {


	/**
	 * @var Slab\DB\Connections\ConnectionInterface
	 **/
	protected $db;


	/**
	 * @var Slab\DB\Compilers\CompilerInterface
	 **/
	protected $compiler;


	/**
	 * @var mixed From table expression
	 **/
	protected $from;


	/**
	 * @var array Select field expressions
	 **/
	protected $selects = [];


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
	 * Constructor
	 *
	 * @param Slab\DB\Connections\ConnectionInterface
	 * @param Slab\DB\Compilers\CompilerInterface
	 * @return void
	 **/
	public function __construct(ConnectionInterface $db, CompilerInterface $compiler) {

		$this->db = $db;
		$this->compiler = $compiler;

	}



	/**
	 * Overwrite select fields
	 *
	 * @param mixed Field expression
	 * @return self
	 **/
	public function select() {

		$this->selects = []; // reset select fields

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

		$this->selects[] = $field;

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
	 * @param mixed Field or where expression
	 * @param string Operator
	 * @param mixed Value
	 * @return self
	 **/
	public function where($expr, $operator = null, $value = null) {

		$this->wheres[] = [$expr, $operator, $value];

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
	 * @param mixed Field or where expression
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
	public function orderBy($column, $order = 'asc', $append = false) {

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
	 * Convert query to SQL
	 *
	 * @return string SQL
	 **/
	public function sql() {

		return $this->compiler->compileSelect([
			'from'   => $this->from,
			'select' => $this->selects,
			'join'   => $this->joins,
			'where'  => $this->wheres,
			'having' => $this->havings,
			'order'  => $this->orders,
			'group'  => $this->groups,
			'limit'  => $this->limit,
			'offset' => $this->offset,
		]);

	}



	/**
	 * Get all results
	 *
	 * @return array Collection
	 **/
	public function get() {

		$sql = $this->sql();

		return $this->db->query($sql);

	}



	/**
	 * Get first row
	 *
	 * @return object Row
	 **/
	public function first() {

		$this->limit(1);

		$rows = $this->get();

		return !empty($rows[0]) ? $rows[0] : null;

	}



	/**
	 * Get a column, optionally keyed
	 *
	 * @param string Column
	 * @param string Key
	 * @return array Column
	 **/
	public function col($column, $key = null) {

		if($key === null) {
			$this->select([$column, 'value']);
		} else {
			$this->select([$column, 'value'], [$key, 'key']);
		}

		$rows = $this->get();

		$output = [];

		foreach($rows as $row) {

			if($key === null) {
				$output[] = $row->value;
			} else {
				$output[$row->key] = $row->value;
			}

		}

		return $output;

	}



}
