import { registerBlockType } from '@wordpress/blocks';

import metadata from './block.json';
const { name } = metadata;

registerBlockType( name, {
	title: 'Fnugg',
	icon: 'smiley',
	category: 'design',
	edit: () => <div>Hola, mundo!</div>,
	save: () => <div>Hola, mundo!</div>,
} );

console.log('hello');