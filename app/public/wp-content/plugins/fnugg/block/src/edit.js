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
	isSelected,
} ) {
	const { resort } = attributes;
	const [ suggestions, setSuggestions ] = useState( [] );

	console.log(resort);

	const getSuggestions = ( search ) => {
		if ( search.length > 2 ) {
			const url = `${ window.dekodeFnugg.rest }dekode/fnugg/v1/get_suggestions?search=${ search }`;

			fetch( url )
				.then( response => response.json() )
				.then( result => {
					setSuggestions( result );
				} );
		}

		return;
	}
	
	return (
		<>
			<InspectorControls>
				<PanelBody title={ 'Settings' }>
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

			<div>hello</div>
			<Disabled>
				<ServerSideRender
					block="dekode/fnugg"
					attributes={ attributes }
				/>
			</Disabled>
		</>
	)
}

export default Edit;