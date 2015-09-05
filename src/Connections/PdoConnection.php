<?php

namespace Slab\DB\Connections;

use Slab\DB\Compilers\MysqlCompiler;

/**
 * PDO Connection
 *
 * @package default
 * @author Luke Lanchester
 **/
class PdoConnection implements ConnectionInterface {


	/**
	 * Get compiler for this connection
	 *
	 * @return Slab\DB\Compilers\MysqlCompiler
	 **/
	public function getCompiler() {

		return new MysqlCompiler($this);
	}



}
