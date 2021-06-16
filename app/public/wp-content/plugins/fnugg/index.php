<?php
/**
 * Plugin Name: Fnugg block
 * Description: Block to display Fnugg resort info
 * Version: 1.0.0
 * Author: Anna Li
 * License: GPLv2 or later
 * Text Domain: fnugg
 */


// Silence is golden.

require plugin_dir_path( __FILE__ ) . '/block/block.php';
require plugin_dir_path( __FILE__ ) . '/class.php';

// Registers custom REST API routes.
add_action( 'rest_api_init', function() {
	$fnugg_api = new Fnugg_API();
	$fnugg_api->register_rest_routes();
} );