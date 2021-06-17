/**
 * WordPress dependencies
 */
import {
	FormTokenField,
	PanelBody,
	Disabled
} from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';
import { useState } from '@wordpress/element';
import ServerSideRender from '@wordpress/server-side-render';

function Edit( {
	attributes,
	setAttributes,
} ) {
	// Attributes.
	const { resort } = attributes;
	
	// States.
	const [ suggestions, setSuggestions ] = useState( [] );

	// Get suggestions based on user input in FormTokenField.
	const getSuggestions = ( search ) => {
		if ( search.length > 2 ) {
			const url = `${ window.dekodeFnugg.rest }dekode/fnugg/v1/get_suggestions?search=${ search }`;

			fetch( url )
				.then( response => response.json() )
				.then( result => {
					setSuggestions( result.body );
				} )
				.catch( error => {
					console.error('Error:', error);
				} );
		}

		return;
	}
	
	return (
		<>
			<InspectorControls>
				<PanelBody title={ 'Settings' }>
					{ /* Use FormTokenField component to handle search and suggestions for resorts. */ }
					<FormTokenField
						value={ resort }
						suggestions={ suggestions }
						onChange={ ( value ) => setAttributes( { resort: value } ) }
						label={ 'Select Resort' }
						onInputChange={ ( value ) => getSuggestions( value ) }
						maxLength={ 1 }
					/>
				</PanelBody>
			</InspectorControls>

			<Disabled>
				{ /* Component used to server-side rendring preview of dynamic block to display in editor. */ }
				<ServerSideRender
					block="dekode/fnugg"
					attributes={ attributes }
				/>
			</Disabled>
		</>
	)
}

export default Edit;