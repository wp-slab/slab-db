<?php

namespace Slab\DB\Compilers;

use Slab\DB\Connections\ConnectionInterface;

/**
 * MySQL Compiler
 *
 * @package default
 * @author Luke Lanchester
 **/
class MysqlCompiler implements CompilerInterface {


	/**
	 * @var Slab\DB\Connections\ConnectionInterface
	 **/
	protected $db;


	/**
	 * Constructor
	 *
	 * @param Slab\DB\Connections\ConnectionInterface
	 * @return void
	 **/
	public function __construct(ConnectionInterface $db) {

		$this->db = $db;

	}



	/**
	 * Compile parts into complete query
	 *
	 * @param array Query info
	 * @return string
	 **/
	public function compileSelect(array $query) {

		$sql = [];

		$query = array_merge([
			'select' => null,
			'from'   => null,
			'join'   => null,
			'where'  => null,
			'group'  => null,
			'having' => null,
			'order'  => null,
			'limit'  => null,
			'offset' => null,
		], $query);

		$sql[] = $this->compileSelectClause($query['select']);
		$sql[] = $this->compileFromClause($query['from']);
		$sql[] = $this->compileJoinClauses($query['join']);
		$sql[] = $this->compileWhereClauses($query['where']);
		$sql[] = $this->compileGroupByClauses($query['group']);
		$sql[] = $this->compileHavingClauses($query['having']);
		$sql[] = $this->compileOrderByClauses($query['order']);
		$sql[] = $this->compileLimitClause($query['limit']);
		$sql[] = $this->compileOffsetClause($query['offset']);

		return implode(' ', array_filter($sql));

	}



	/**
	 * Compile select clause
	 *
	 * @param array Select
	 * @return string SQL part
	 **/
	public function compileSelectClause(array $select) {

		if(empty($select)) {
			return 'select *';
		}

		$cols = [];


		foreach($select as $select) {

			if(is_string($select)) {
				$cols[] = $select; // @todo escape
			} elseif(is_array($select)) {
				$cols[] = "{$select[0]} as {$select[1]}"; // @todo escape
			} elseif(is_a($select, 'Closure')) {
				$cols[] = $select->__invoke(); // @todo pass db
			}

		}

		return 'select ' . implode(', ', $cols);

	}



	/**
	 * Compile from clause
	 *
	 * @param array From
	 * @return string SQL part
	 **/
	public function compileFromClause($from) {

		if(is_string($from)) {
			return "from $from";
		} elseif(is_array($from)) {
			return "from {$from[0]} as {$from[1]}";
		} elseif(is_a($from, 'Closure')) {
			return 'from ' . $select->__invoke();
		}

	}



	/**
	 * Compile join clauses
	 *
	 * @param array JoinCl
	 * @return string SQL part
	 **/
	public function compileJoinClauses($joins) {

	}



	/**
	 * Compile whereclauses
	 *
	 * @param array WhereC
	 * @return string SQL part
	 **/
	public function compileWhereClauses($wheres) {

	}



	/**
	 * Compile group by clauses
	 *
	 * @param array Group bys
	 * @return string SQL part
	 **/
	public function compileGroupByClauses($group_bys) {

	}



	/**
	 * Compile having clauses
	 *
	 * @param array Havings
	 * @return string SQL part
	 **/
	public function compileHavingClauses($havings) {

	}



	/**
	 * Compile order by clauses
	 *
	 * @param array Orders
	 * @return string SQL part
	 **/
	public function compileOrderByClauses($orders) {

	}



	/**
	 * Compile limit clause
	 *
	 * @param int Limit
	 * @return string SQL part
	 **/
	public function compileLimitClause($limit) {

		$limit = intval($limit);

		return $limit > 0 ? "limit $limit" : null;

	}



	/**
	 * Compile offset clause
	 *
	 * @param int Offset
	 * @return string SQL part
	 **/
	public function compileOffsetClause($offset) {

		$offset = intval($offset);

		return $offset > 0 ? "offset $offset" : null;

	}



}
