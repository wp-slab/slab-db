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
	 * @return Slab\DB\Compilers\MysqlCompiler
	 **/
	public function getCompiler();


	/**
	 * Execute a general query
	 *
	 * @param string SQL
	 * @param array Query values
	 * @return bool Result
	 **/
	public function query($sql, array $values = null);


	/**
	 * Execute a SELECT query
	 *
	 * @param string SQL
	 * @param array Query values
	 * @return array [int Rows affected, int Insert ID]
	 **/
	public function select($sql, array $values = null);


	/**
	 * Execute an INSERT query
	 *
	 * @param string SQL
	 * @param array Query values
	 * @return array [int Rows affected, int Insert ID]
	 **/
	public function insert($sql, array $values = null);


	/**
	 * Execute an UPDATE query
	 *
	 * @param string SQL
	 * @param array Query values
	 * @return int Rows affected
	 **/
	public function update($sql, array $values = null);


	/**
	 * Execute a DELETE query
	 *
	 * @param string SQL
	 * @param array Query values
	 * @return int Rows affected
	 **/
	public function delete($sql, array $values = null);


	/**
	 * Escape a value ref
	 *
	 * @param string Value
	 * @return string Escaped value
	 **/
	public function escapeValue($value);


	/**
	 * Escape a table ref
	 *
	 * @param string Table
	 * @return string Escaped table
	 **/
	public function escapeTable($value);


	/**
	 * Escape a column ref
	 *
	 * @param string Column
	 * @return string Escaped column
	 **/
	public function escapeColumn($value);


}
