<?php
/*
Plugin Name: Slab &mdash; DB
Plugin URI: http://www.wp-slab.com/components/db
Description: The Slab Database component. Build and execute queries with ease.
Version: 1.0.0
Author: Slab
Author URI: http://www.wp-slab.com
Created: 2014-06-30
Updated: 2015-08-08
Repo URI: github.com/wp-slab/slab-db
Requires: slab-core
*/


// Define
define('SLAB_DB_INIT', true);
define('SLAB_DB_DIR', plugin_dir_path(__FILE__));
define('SLAB_DB_URL', plugin_dir_url(__FILE__));


// Hooks
add_action('slab_init', 'slab_db_init');


// Init
function slab_db_init($slab) {

	$slab->autoloader->registerNamespace('Slab\DB', SLAB_DB_DIR . 'src');

}
