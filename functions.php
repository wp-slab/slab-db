<?php

namespace Slab\DB;

/**
 * Initialize Slab DB
 *
 * @param Slab\Core\Application
 * @return void
 **/
function slab_db_init($slab) {

	$slab->autoloader->registerNamespace('Slab\DB', SLAB_DB_DIR . 'src');

	$slab->singleton('Slab\DB\DatabaseManager', function(){
		return new DatabaseManager;
	});

	$slab->alias('db', 'Slab\DB\DatabaseManager');

}
