import {InspectorControls} from '@wordpress/block-editor';
import { useState, useEffect } from '@wordpress/element';
import { PanelBody, TextControl, CheckboxControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

/**
 * Edit component.
 *
 * @param attributes The block attributes.
 * @param setAttributes Helper function to save attributes for the block.
 * @returns {JSX.Element} Render the edit screen
 */
const edit = ({attributes, setAttributes}) => {

	const {
		pokemonNumber,
		showName,
		showNumber,
		showType,
		showWeight,
		showHeight,
		pokemonHeight,
		pokemonWeight,
		pokemonName,
		pokemonType,
		frontImage,
		backImage,
	} = attributes;

	const [pokemonData, setPokemonData] = useState( null );

	/**
	 * Fetch the pokemon data from the API.
	 * @param number The pokemon number.
	 */
	const fetchPokemon = (number) => {
		fetch('https://pokeapi.co/api/v2/pokemon/' +  number)
			.then(
				response => {
					response.json()
						.then(
							data => {
								setPokemonData(data);

								const pokemonTypes = data.types.map(array => array.type.name);

								setAttributes({
									pokemonName: data.name,
									pokemonHeight: data.height,
									pokemonWeight: data.weight,
									pokemonType: pokemonTypes.join('/'),
									frontImage: data.sprites.front_default,
									backImage: data.sprites.back_default,
								});
							}
						)
				}
			);
	}

	if(pokemonNumber && !pokemonData) {
		fetchPokemon(pokemonNumber);
	}

	/**
	 * Conditionally show the appropriate block display view.
	 *
	 * @returns {JSX.Element}
	 */
	const blockDisplay = () => {
		if (null !== pokemonData) {
			return (
				<div>
					<img src={frontImage}/>
					<img src={backImage}/>
					{showName && (<p> {__('Name:', 'wp-dexter')} {pokemonName}</p>)}
					{showNumber && (<p>{__('Number:', 'wp-dexter')} {pokemonNumber}</p>)}
					{showType && (<p>{__('Type:', 'wp-dexter')} {pokemonType}</p>)}
					{showWeight && (<p>{__('Weight:', 'wp-dexter')} {pokemonWeight}</p>)}
					{showHeight && (<p>{__('Height:', 'wp-dexter')} {pokemonHeight}</p>)}
				</div>
			)

		} else {
			return (
				<div>
					<p>{__('Choose your pokemon first please', 'wp-dexter')}</p>
				</div>
			)
		}
	}

	return(
		<div className="postbox pokepostbox">
			<InspectorControls>
				<PanelBody
					title={__('Pokemon Number', 'wp-dexter')}
					initialOpen={true}
				>
					<TextControl
						label={__('Select Pokemon Number', 'wp-dexter')}
						type="number"
						value={pokemonNumber}
						onChange={(number) => {
							setAttributes({ pokemonNumber: number });
							if ('' !== number) {
								fetchPokemon(number);
							}
						}}
					/>
					{null !== pokemonData && (
						<div>
							<CheckboxControl
								label={__('Show Pokemon Name', 'wp-dexter')}
								checked={showName}
								onChange={(value) => {
									setAttributes({ showName: value });
								}}
							/>
							<CheckboxControl
								label={__('Show Pokemon Number', 'wp-dexter')}
								checked={showNumber}
								onChange={(value) => {
									setAttributes({ showNumber: value });
								}}
							/>
							<CheckboxControl
								label={__('Show Pokemon Type', 'wp-dexter')}
								checked={showType}
								onChange={(value) => {
									setAttributes({ showType: value });
								}}
							/>
							<CheckboxControl
								label={__('Show Pokemon Weight', 'wp-dexter')}
								checked={showWeight}
								onChange={(value) => {
									setAttributes({ showWeight: value });
								}}
							/>
							<CheckboxControl
								label={__('Show Pokemon Height', 'wp-dexter')}
								checked={showHeight}
								onChange={(value) => {
									setAttributes({ showHeight: value });
								}}
							/>
						</div>
					)}
				</PanelBody>
			</InspectorControls>
			{blockDisplay()}
		</div>
	);
};

export default edit;


