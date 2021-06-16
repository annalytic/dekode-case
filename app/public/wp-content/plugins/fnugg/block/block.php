<?php
/*
 * Register plugin.
 */

declare( strict_types=1 );

/**
 * Register block
 */
function register_block() {
	$asset_file = include( plugin_dir_path( __FILE__ ) . 'build/index.asset.php');

	// Register editor script.
	wp_register_script(
		'fnugg-editor',
		plugins_url( 'build/index.js', __FILE__ ),
		$asset_file['dependencies'],
		$asset_file['version']
	);

	// Register editor and frontend style.

	// Register block from metadata.
	register_block_type_from_metadata( plugin_dir_path( __FILE__ ) . '/src' );
}
add_action( 'init', 'register_block' );