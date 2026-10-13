import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText, BlockControls, AlignmentControl, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, RangeControl, ToggleControl, __experimentalNumberControl as NumberControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';
import './style.scss';

export const formatNumber = ( value, separator ) =>
	separator ? Math.round( value ).toLocaleString( 'en-US' ) : String( Math.round( value ) );

function Edit( { attributes, setAttributes } ) {
	const { number, prefix, suffix, label, duration, separator, textAlign } = attributes;
	const blockProps = useBlockProps( { className: textAlign ? `has-text-align-${ textAlign }` : undefined } );

	return (
		<>
			<BlockControls group="block">
				<AlignmentControl value={ textAlign } onChange={ ( value ) => setAttributes( { textAlign: value } ) } />
			</BlockControls>
			<InspectorControls>
				<PanelBody title={ __( 'Counter', 'addax-core' ) }>
					<NumberControl
						label={ __( 'Number', 'addax-core' ) }
						value={ number }
						onChange={ ( value ) => setAttributes( { number: Number( value ) || 0 } ) }
						__next40pxDefaultSize
					/>
					<TextControl label={ __( 'Prefix', 'addax-core' ) } value={ prefix } onChange={ ( value ) => setAttributes( { prefix: value } ) } __nextHasNoMarginBottom __next40pxDefaultSize />
					<TextControl label={ __( 'Suffix', 'addax-core' ) } help={ __( 'For example + or %', 'addax-core' ) } value={ suffix } onChange={ ( value ) => setAttributes( { suffix: value } ) } __nextHasNoMarginBottom __next40pxDefaultSize />
					<ToggleControl label={ __( 'Thousands separator', 'addax-core' ) } checked={ separator } onChange={ ( value ) => setAttributes( { separator: value } ) } __nextHasNoMarginBottom />
					<RangeControl label={ __( 'Animation length (ms)', 'addax-core' ) } min={ 0 } max={ 6000 } step={ 100 } value={ duration } onChange={ ( value ) => setAttributes( { duration: value } ) } __nextHasNoMarginBottom __next40pxDefaultSize />
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<div className="addax-counter__value">
					{ prefix && <span className="addax-counter__affix">{ prefix }</span> }
					<span className="addax-counter__number">{ formatNumber( number, separator ) }</span>
					{ suffix && <span className="addax-counter__affix">{ suffix }</span> }
				</div>
				<RichText
					tagName="div"
					className="addax-counter__label"
					value={ label }
					onChange={ ( value ) => setAttributes( { label: value } ) }
					placeholder={ __( 'Label', 'addax-core' ) }
					allowedFormats={ [ 'core/bold', 'core/italic' ] }
				/>
			</div>
		</>
	);
}

registerBlockType( metadata.name, { edit: Edit } );
