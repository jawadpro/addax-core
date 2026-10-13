import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, useInnerBlocksProps, InnerBlocks, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl, RangeControl, SelectControl, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';
import './style.scss';
import './editor.scss';

const TEMPLATE = [ [ 'addax/hero-slide' ] ];

function Edit( { attributes, setAttributes } ) {
	const { autoplay, interval, minHeight, minHeightUnit, showArrows, showDots, showProgress, showScrollDown, scrollTarget } = attributes;
	const blockProps = useBlockProps( { style: { '--addax-hero-min-h': `${ minHeight }${ minHeightUnit }` } } );
	const innerBlocksProps = useInnerBlocksProps(
		{ className: 'addax-slider__slides is-editing' },
		{ allowedBlocks: [ 'addax/hero-slide' ], template: TEMPLATE, renderAppender: InnerBlocks.ButtonBlockAppender }
	);

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Slider', 'addax-core' ) }>
					<ToggleControl label={ __( 'Autoplay', 'addax-core' ) } checked={ autoplay } onChange={ ( next ) => setAttributes( { autoplay: next } ) } help={ __( 'Visitors get a pause button. Turned off for people who prefer reduced motion.', 'addax-core' ) } __nextHasNoMarginBottom />
					{ autoplay && <RangeControl label={ __( 'Seconds per slide', 'addax-core' ) } min={ 3 } max={ 20 } value={ interval / 1000 } onChange={ ( next ) => setAttributes( { interval: next * 1000 } ) } __nextHasNoMarginBottom __next40pxDefaultSize /> }
					<RangeControl label={ __( 'Minimum height', 'addax-core' ) } min={ 30 } max={ minHeightUnit === 'px' ? 1200 : 100 } value={ minHeight } onChange={ ( next ) => setAttributes( { minHeight: next } ) } __nextHasNoMarginBottom __next40pxDefaultSize />
					<SelectControl label={ __( 'Height unit', 'addax-core' ) } value={ minHeightUnit } options={ [ { label: 'vh', value: 'vh' }, { label: 'px', value: 'px' } ] } onChange={ ( next ) => setAttributes( { minHeightUnit: next, minHeight: next === 'px' ? 640 : 100 } ) } __nextHasNoMarginBottom __next40pxDefaultSize />
					<ToggleControl label={ __( 'Arrows', 'addax-core' ) } checked={ showArrows } onChange={ ( next ) => setAttributes( { showArrows: next } ) } __nextHasNoMarginBottom />
					<ToggleControl label={ __( 'Dots', 'addax-core' ) } checked={ showDots } onChange={ ( next ) => setAttributes( { showDots: next } ) } __nextHasNoMarginBottom />
					<ToggleControl label={ __( 'Progress bar', 'addax-core' ) } checked={ showProgress } onChange={ ( next ) => setAttributes( { showProgress: next } ) } __nextHasNoMarginBottom />
					<ToggleControl label={ __( 'Scroll-down button', 'addax-core' ) } checked={ showScrollDown } onChange={ ( next ) => setAttributes( { showScrollDown: next } ) } __nextHasNoMarginBottom />
					{ showScrollDown && <TextControl label={ __( 'Scroll to (anchor)', 'addax-core' ) } help={ __( 'An HTML anchor such as #services. Empty scrolls to the next section.', 'addax-core' ) } value={ scrollTarget } onChange={ ( next ) => setAttributes( { scrollTarget: next } ) } __nextHasNoMarginBottom __next40pxDefaultSize /> }
				</PanelBody>
			</InspectorControls>
			<section { ...blockProps }>
				<div { ...innerBlocksProps } />
			</section>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
} );
