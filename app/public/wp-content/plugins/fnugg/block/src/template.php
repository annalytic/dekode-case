<?php
/**
 * Fnugg block template.
 */

declare( strict_types=1 );

namespace Dekode\Fnugg\Template;

/**
 * Render template
 *
 * @param array $attributes List of settings attributes.
 *
 * @return string
 */
function render_template( array $attributes ) : string {
	$resort = isset( $attributes['resort'][0] ) ? $attributes['resort'][0] : null;
	
	ob_start();
	if ( ! empty( $resort ) ) {
	
		$url = get_rest_url() . 'dekode/fnugg/v1/get_resort?resort=' . $resort;
		$request= wp_remote_get( $url );
		
		$response_body = json_decode( wp_remote_retrieve_body( $request ) );
		$response_code = wp_remote_retrieve_response_code( $request );

		// Needs to add check for if response code is 200.
		$details = $response_body->body;
		?>
		<div class="card">
			<div class="card-header">
				<img src="<?php echo $details->image_url ?>">
				<h2><?php echo $details->name ?></h2>
				
				<div>
					<p>Dagens forhold:</p>
					<span>Oppdatert: </span> <?php echo $details->last_updated ?>
				</div>
			</div>

			<div>
				<span>Temperatur:</span>
				<span><?php echo $details->temperature_value ?></span>
				<span><?php echo $details->temperature_unit?></span>
			</div>

			<div>
				<span>Vind:</span>
				<span><?php echo $details->wind_mps ?></span>
				</span>m/s</span>
			</div>

			<div>
				<span>Forhold:</span>
				<span><?php echo $details->condition_description ?></span>
			</div>
		</div>
		<?php
	} else {
		?>
			<p class="hide-in-fe">Select a resort in right sidebar</p>
			<p class="hide-in-ed">No resort is chosen.</p>
		<?php
	}
	return ob_get_clean();
}
