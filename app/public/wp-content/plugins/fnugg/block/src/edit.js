import { FormTokenField, PanelBody } from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';
import { useState } from '@wordpress/element';

function Edit( {
	attributes,
	setAttributes,
	isSelected,
} ) {
	const [ suggestions, setSuggestions ] = useState( [] );
	const [ selectedResort, setSelectedResort ] = useState();

	const getSuggestions = ( search ) => {
		if ( search.length > 2 ) {
			const url = `${ window.dekodeFnugg.rest }dekode/fnugg/v1/get_suggestions?search=${ search }`;

			fetch( url )
				.then( response => response.json() )
				.then( result => {
					setSuggestions(result)
					console.log(result);
				} );
		}

		return;
	}
	
	return (
		<>
			<InspectorControls>
				<PanelBody title={ 'Settings' }>
					<FormTokenField
						value={ selectedResort }
						suggestions={ suggestions }
						onChange={ ( tokens ) => setState( { tokens } ) }
						label={ 'Select Resort' }
						onInputChange={ ( value ) => getSuggestions( value ) }
						maxLength={ 1 }
					/>
				</PanelBody>
			</InspectorControls>

			<div>hello</div>
		</>
	)
}

export default Edit;