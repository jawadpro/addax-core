import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, RangeControl, ToggleControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';
import './style.scss';

export const mapUrl = ( address, zoom ) =>
	`https://maps.google.com/maps?q=${ encodeURIComponent( address ) }&z=${ zoom }&output=embed`;

function Edit( { attributes, setAttributes } ) {
	const { address, zoom, height, grayscale } = attributes;
	const fallback = window.addaxCoreOptions?.address || '';
	const where = address || fallback;
	const blockProps = useBlockProps( { className: grayscale ? 'is-grayscale' : undefined, style: { '--addax-map-h': `${ height }px` } } );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Map', 'addax-core' ) }>
					<TextControl label={ __( 'Address', 'addax-core' ) } value={ address } placeholder={ fallback } help={ __( 'Empty uses the address from Addax Settings.', 'addax-core' ) } onChange={ ( next ) => setAttributes( { address: next } ) } __nextHasNoMarginBottom __next40pxDefaultSize />
					<RangeControl label={ __( 'Zoom', 'addax-core' ) } min={ 3 } max={ 20 } value={ zoom } onChange={ ( next ) => setAttributes( { zoom: next } ) } __nextHasNoMarginBottom __next40pxDefaultSize />
					<RangeControl label={ __( 'Height (px)', 'addax-core' ) } min={ 200 } max={ 900 } step={ 10 } value={ height } onChange={ ( next ) => setAttributes( { height: next } ) } __nextHasNoMarginBottom __next40pxDefaultSize />
					<ToggleControl label={ __( 'Grayscale', 'addax-core' ) } checked={ grayscale } onChange={ ( next ) => setAttributes( { grayscale: next } ) } __nextHasNoMarginBottom />
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				{ where ? (
					<iframe title={ __( 'Map', 'addax-core' ) } src={ mapUrl( where, zoom ) } loading="lazy" style={ { pointerEvents: 'none' } } />
				) : (
					<div className="addax-editor-placeholder">{ __( 'Enter an address in the block settings, or add one in Addax → Settings.', 'addax-core' ) }</div>
				) }
			</div>
		</>
	);
}

registerBlockType( metadata.name, { edit: Edit } );
