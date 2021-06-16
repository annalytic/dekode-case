<?php
/*
 * Register plugin.
 */

declare( strict_types=1 );

namespace Dekode\Fnugg;

require_once plugin_dir_path( __FILE__  ) . 'src/template.php';

use function Dekode\Fnugg\Template\render_template;

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
		$asset_file['version'],
		false
	);

	// Register editor and frontend style.

	// Register block from metadata.
	register_block_type_from_metadata(
		plugin_dir_path( __FILE__ ) . '/src',
		[
			'render_callback' => function( array $attributes ) : string {
				return render_template( $attributes );
			},
		]
 );

	// Localize REST route.
	wp_localize_script(
		'fnugg-editor', //why?
		'dekodeFnugg',
		[
			'rest' => get_rest_url(),
		]
	);
}
add_action( 'init', __NAMESPACE__ . '\\register_block' );