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


// Includes
include SLAB_DB_DIR . 'functions.php';


// Hooks
add_action('slab_init', 'Slab\DB\slab_db_init');
add_action('slab_db_connections', 'Slab\DB\slab_db_default_connections');
