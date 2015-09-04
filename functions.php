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

}
