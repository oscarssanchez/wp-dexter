 /**
 * Internal dependencies
 */
import edit from './edit'
import save from './save'
import { registerBlockType } from '@wordpress/blocks';
import { name, settings } from './block.json';

/**
 * Register block
 */
registerBlockType(name, {
	...settings,
	edit,
	save,
});
