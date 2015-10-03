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
		$db = new DatabaseManager;
		do_action('slab_db_connections', $db);
		return $db;
	});

	$slab->alias('db', 'Slab\DB\DatabaseManager');

}


/**
 * Initialize Slab DB Connections
 *
 * @param Slab\DB\DatabaseManager
 * @return void
 **/
function slab_db_default_connections($db) {

	$db->addConnection('wpdb', function(){
		global $wpdb;
		return new \Slab\DB\Connections\WpdbConnection($wpdb);
	});

}
