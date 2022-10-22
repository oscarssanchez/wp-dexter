/**
 * WordPress dependencies
 */
import { InnerBlocks } from '@wordpress/block-editor';

/**
 * Save component.
 * See https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @returns {Function} Render the edit screen
 */
const Save = () => {
    return <InnerBlocks.Content />;
};

export default Save;