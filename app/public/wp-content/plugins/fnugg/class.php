<?php
/**
 * Handles REST API calls.
 */
class Fnugg_API {
	// Properties.
	// Methods.
	/**
	 * Registers all REST routes.
	 *
	 * @return void
	 */
	public function register_rest_routes() {
		// Register rest route for suggestions.
		register_rest_route(
			'dekode/fnugg/v1',
			'/get_suggestions', //wp-json/dekode/fnugg/v1/get_suggestions?search=fonna
			[
				'methods' => WP_REST_Server::READABLE,
				'callback' => [ $this, 'get_suggestions' ],
				'permission_callback' => '__return_true',
				'args' => [
					'search' => [
						'required' => true,
						'type' => 'string',
					],
				],
			]
		);

				// Register rest route for getting resort.
				register_rest_route(
					'dekode/fnugg/v1',
					'/get_resort',
					[
						'methods' => WP_REST_Server::READABLE,
						'callback' => [ $this, 'get_resort' ],
						'permission_callback' => '__return_true',
						'args' => [
							'resort' => [
								'required' => true,
								'type' => 'string',
							],
						],
					]
				);
	}

	public function get_suggestions( $request ) : array {
		$search = $request->get_param( 'search' );

		$url = 'https://api.fnugg.no/suggest/autocomplete/?q=' . $search;
		$response = wp_remote_get( $url );

		if ( is_wp_error( $response ) ) {
			return [
				'success' => 0,
				'message' => 'Got WP_Error when sending request to ' . $url,
			];
		}

		$json_response = json_decode( wp_remote_retrieve_body( $response ) );

		$formatted_response = [];

		foreach ( $json_response->result as $key=>$suggestion ) {
			array_push( $formatted_response, $suggestion->name );
		}

		return $formatted_response;
	}

	public function get_resort( $request ) : array {
		$resort = $request->get_param( 'resort' );

		$url = 'https://api.fnugg.no/search?q=' . $resort;
		$response = wp_remote_get( $url );

		if ( is_wp_error( $response ) ) {
			return [
				'success' => 0,
				'message' => 'Got WP_Error when sending request to ' . $url,
			];
		}

		$json_response = json_decode( wp_remote_retrieve_body( $response ) );
		
		$source = $json_response->hits->hits;

		if ( ! empty( $source ) ) {
			$source = $source[0]->_source;
			$current_conditions = $json_response->hits->hits[0]->_source->conditions->current_report->top;
	
			$formatted_response = [
				'name' => $source->name,
				'last_updated' => $current_conditions->last_updated,
				'condition_description' => $current_conditions->condition_description,
				'temperature_unit' => $current_conditions->temperature->unit,
				'temperature_value' => $current_conditions->temperature->value,
				'wind_mps' => $current_conditions->wind->mps
			];
	
			return [ $formatted_response ];
		}

		return [
			'success' => 0,
			'message' => 'No resort by that name',
		];		

		return [ $json_response ];
	}
}
?>