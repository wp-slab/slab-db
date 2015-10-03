<?php

namespace Slab\DB\Connections;

/**
 * Connection Interface
 *
 * @package default
 * @author Luke Lanchester
 **/
interface ConnectionInterface {


	/**
	 * Get compiler for this connection
	 *
	 * @return Slab\DB\QueryCompilers\QueryCompilerInterface
	 **/
	public function getCompiler();


	/**
	 * Execute a general query
	 *
	 * @param string SQL
	 * @param array Query params
	 * @return bool Result
	 **/
	public function query($sql, array $params = null);


	/**
	 * Execute a SELECT query
	 *
	 * @param string SQL
	 * @param array Query params
	 * @return array Rows
	 **/
	public function select($sql, array $params = null);


	/**
	 * Execute an INSERT query
	 *
	 * @param string SQL
	 * @param array Query params
	 * @param bool Return insert ID
	 * @return array|false [int Rows affected, int Insert ID]
	 **/
	public function insert($sql, array $params = null, $fetch_insert_id = true);


	/**
	 * Execute an UPDATE query
	 *
	 * @param string SQL
	 * @param array Query params
	 * @return int|false Rows affected
	 **/
	public function update($sql, array $params = null);


	/**
	 * Execute a DELETE query
	 *
	 * @param string SQL
	 * @param array Query params
	 * @return int|false Rows affected
	 **/
	public function delete($sql, array $params = null);


	/**
	 * Escape a param ref
	 *
	 * @param string Param
	 * @return string Escaped param
	 **/
	public function escapeParam($param);


	/**
	 * Escape a table ref
	 *
	 * @param string Table
	 * @return string Escaped table
	 **/
	public function escapeTable($table);


	/**
	 * Escape a column ref
	 *
	 * @param string Column
	 * @return string Escaped column
	 **/
	public function escapeColumn($column);


}
