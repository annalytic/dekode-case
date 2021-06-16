<?php
/**
 * Fnugg block template.
 */

declare( strict_types=1 );

namespace Dekode\Fnugg\Template;

/**
 * Render template
 *
 * @param array $attributes the list of settings attributes.
 *
 * @return string
 */
function render_template( array $attributes ): string {
	$resort = $attributes['resort'][0];
	ob_start();
	if ( ! empty( $resort ) ) {
	
		$url = get_rest_url() . 'dekode/fnugg/v1/get_resort?resort=' . $resort;
		$response = wp_remote_get( $url );

		$json_response = json_decode( wp_remote_retrieve_body( $response ) );
		var_dump($json_response[0]->name);
		$details = $json_response[0];

		?>
		<div class="card">
			<h1><?php echo $details->name ?></h1>

			<p>Dagens forhold:</p>
			<span>Oppdatert: </span> <?php echo $details->last_updated ?>
		</div>
		<?php
	} else {
		?>
			<p>Select a resort in right sidebar</p>
		<?php
	}
	return ob_get_clean();
}
