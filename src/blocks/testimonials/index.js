import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, useInnerBlocksProps, InnerBlocks, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody, ToggleControl, RangeControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';
import './style.scss';
import './editor.scss';

const TEMPLATE = [
	[ 'addax/testimonial', {} ],
	[ 'addax/testimonial', {} ],
];

function Edit( { attributes, setAttributes } ) {
	const { autoplay, interval, showArrows, showDots, title } = attributes;
	const blockProps = useBlockProps();
	const innerBlocksProps = useInnerBlocksProps(
		{ className: 'addax-slider__slides is-editing' },
		{ allowedBlocks: [ 'addax/testimonial' ], template: TEMPLATE, orientation: 'horizontal', renderAppender: InnerBlocks.ButtonBlockAppender }
	);

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Slider', 'addax-core' ) }>
					<ToggleControl label={ __( 'Autoplay', 'addax-core' ) } checked={ autoplay } onChange={ ( next ) => setAttributes( { autoplay: next } ) } __nextHasNoMarginBottom />
					{ autoplay && <RangeControl label={ __( 'Seconds per testimonial', 'addax-core' ) } min={ 3 } max={ 20 } value={ interval / 1000 } onChange={ ( next ) => setAttributes( { interval: next * 1000 } ) } __nextHasNoMarginBottom __next40pxDefaultSize /> }
					<ToggleControl label={ __( 'Arrows', 'addax-core' ) } checked={ showArrows } onChange={ ( next ) => setAttributes( { showArrows: next } ) } __nextHasNoMarginBottom />
					<ToggleControl label={ __( 'Dots', 'addax-core' ) } checked={ showDots } onChange={ ( next ) => setAttributes( { showDots: next } ) } __nextHasNoMarginBottom />
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<RichText tagName="h2" className="addax-testimonials__title" value={ title } onChange={ ( next ) => setAttributes( { title: next } ) } placeholder={ __( 'Section title (optional)', 'addax-core' ) } allowedFormats={ [] } />
				<div { ...innerBlocksProps } />
			</div>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
} );
