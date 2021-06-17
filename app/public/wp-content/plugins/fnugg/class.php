<?php
/**
 * Handles REST API calls.
 */
class Fnugg_API {
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

	/**
	 * Get suggestions from Fnugg API.
	 *
	 * @param WP_REST_Request $request The WP_REST_Request.
	 * 
	 * @return WP_REST_Response
	 */
	public function get_suggestions( WP_REST_Request $request ) : WP_REST_Response {
		$search = $request->get_param( 'search' );

		$url = 'https://api.fnugg.no/suggest/autocomplete/?q=' . $search;
		$response = wp_remote_get( $url );

		if ( is_wp_error( $response ) ) {
			return [
				'success' => 0,
				'message' => 'Got WP_Error when sending request to ' . $url,
			];
		}

		// Retrieve information.
		$response_code = wp_remote_retrieve_response_code( $request );
		$response_message = wp_remote_retrieve_response_message( $request );
		$response_body = json_decode( wp_remote_retrieve_body( $response ) );

		if ( $response_body->total > 0 ) {
			$formatted_response = [];

			foreach ( $response_body->result as $key=>$suggestion ) {
				array_push( $formatted_response, $suggestion->name );
			}
	
			return new WP_REST_Response(
				[
					'code' => 200,
					'body' => $formatted_response
				]
		);
		} else {
			return new WP_REST_Response(
				[
					'status' => 404,
					'body' => []
				]
			);
		}
	}

	/**
	 * Get resort details from Fnugg API.
	 * 
	 * @param WP_REST_Request $request The WP_REST_Request.
	 *
	 * @return WP_REST_Response
	 */
	public function get_resort( WP_REST_Request $request ) : WP_REST_Response {
		// Get parameter from request.
		$resort = $request->get_param( 'resort' );

		// Sends HTTP request using GET method and returns its response.
		$url = 'https://api.fnugg.no/search?q=' . $resort;
		$request= wp_remote_get( $url );

		// Retrieve information.
		$response_code = wp_remote_retrieve_response_code( $request );
		$response_message = wp_remote_retrieve_response_message( $request );
		$response_body = json_decode( wp_remote_retrieve_body( $request ) );
		
		// Grab correct information.
		$source = $response_body->hits->hits;
		
		/*
		 * Comment:
		 * Better solution than below is to use ID of resort and do new call to /resort/id=?.
		 * That way we are guaranteed one resort as response.
		 */

 		// If source exists.
		if ( ! empty( $source ) ) {
			$source = $source[0]->_source;
			$current_conditions = $response_body->hits->hits[0]->_source->conditions->current_report->top;
			
			$formatted_response = [
				'name' => $source->name,
				'image_url' => $source->images->image_full,
				'last_updated' => $current_conditions->last_updated,
				'condition_description' => $current_conditions->condition_description,
				'temperature_unit' => $current_conditions->temperature->unit,
				'temperature_value' => $current_conditions->temperature->value,
				'wind_mps' => $current_conditions->wind->mps
			];
	
			return new WP_REST_Response(
				[
					'status' => $response_code,
					'message' => $response_message,
					'body' => $formatted_response,
				]
			);
		} else {
			return new WP_REST_Response(
				[
					'status' => 404,
					'message' => 'No resort by that name.'
				]
			);
		}
	}
}
?>