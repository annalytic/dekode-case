import { registerBlockType } from '@wordpress/blocks';

import metadata from './block.json';
import edit from './edit';

const { name } = metadata;

// Register block.
registerBlockType( name, {
	title: 'Fnugg',
	icon: 'smiley',
	category: 'design',
	edit,
	save: () => {
		return null;
	}
} );