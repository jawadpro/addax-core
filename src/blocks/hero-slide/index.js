import { registerBlockType } from '@wordpress/blocks';
import {
	useBlockProps,
	useInnerBlocksProps,
	InnerBlocks,
	InspectorControls,
	BlockControls,
	MediaReplaceFlow,
	MediaPlaceholder,
	__experimentalColorGradientSettingsDropdown as ColorGradientSettingsDropdown,
	__experimentalUseMultipleOriginColorsAndGradients as useMultipleOriginColorsAndGradients,
} from '@wordpress/block-editor';
import { PanelBody, RangeControl, FocalPointPicker, ToolbarGroup, ToolbarButton } from '@wordpress/components';
import { justifyLeft, justifyCenter, justifyRight } from '@wordpress/icons';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';

const TEMPLATE = [
	[ 'core/heading', { level: 1, textAlign: 'center', fontSize: 'huge', content: __( 'Crafting your digital experience', 'addax-core' ) } ],
	[ 'core/paragraph', { align: 'center', fontSize: 'large', content: __( 'Your one stop shop for all of your digital needs.', 'addax-core' ) } ],
	[ 'core/buttons', { layout: { type: 'flex', justifyContent: 'center' } }, [
		[ 'core/button', { text: __( 'Explore more', 'addax-core' ) } ],
		[ 'core/button', { text: __( 'Get in touch', 'addax-core' ), className: 'is-style-addax-light' } ],
	] ],
];

function Edit( { attributes, setAttributes, clientId, context } ) {
	const { mediaId, mediaUrl, focalPoint, overlayColor, overlayOpacity, contentPosition } = attributes;
	const colorSettings = useMultipleOriginColorsAndGradients();
	const minHeight = context[ 'addax/sliderMinHeight' ];
	const unit = context[ 'addax/sliderMinHeightUnit' ] || 'vh';

	const blockProps = useBlockProps( {
		className: `is-position-${ contentPosition }`,
		style: minHeight ? { '--addax-hero-min-h': `${ minHeight }${ unit }` } : undefined,
	} );
	const innerBlocksProps = useInnerBlocksProps( { className: 'addax-hero-slide__content' }, { template: TEMPLATE } );
	const onSelect = ( media ) => setAttributes( { mediaId: media.id, mediaUrl: media.url } );

	const positions = [
		{ value: 'left', icon: justifyLeft, label: __( 'Content left', 'addax-core' ) },
		{ value: 'center', icon: justifyCenter, label: __( 'Content centre', 'addax-core' ) },
		{ value: 'right', icon: justifyRight, label: __( 'Content right', 'addax-core' ) },
	];

	return (
		<>
			<BlockControls group="block">
				<ToolbarGroup>
					{ positions.map( ( item ) => (
						<ToolbarButton key={ item.value } icon={ item.icon } label={ item.label } isPressed={ contentPosition === item.value } onClick={ () => setAttributes( { contentPosition: item.value } ) } />
					) ) }
				</ToolbarGroup>
			</BlockControls>
			<BlockControls group="other">
				<MediaReplaceFlow mediaId={ mediaId } mediaURL={ mediaUrl } allowedTypes={ [ 'image' ] } accept="image/*" onSelect={ onSelect } name={ mediaUrl ? __( 'Replace background', 'addax-core' ) : __( 'Add background', 'addax-core' ) } />
			</BlockControls>
			<InspectorControls>
				<PanelBody title={ __( 'Background', 'addax-core' ) }>
					{ mediaUrl ? (
						<FocalPointPicker label={ __( 'Focal point', 'addax-core' ) } url={ mediaUrl } value={ focalPoint } onChange={ ( next ) => setAttributes( { focalPoint: next } ) } __nextHasNoMarginBottom />
					) : (
						<MediaPlaceholder icon="format-image" labels={ { title: __( 'Background image', 'addax-core' ) } } onSelect={ onSelect } accept="image/*" allowedTypes={ [ 'image' ] } />
					) }
					<RangeControl label={ __( 'Overlay opacity', 'addax-core' ) } min={ 0 } max={ 100 } step={ 5 } value={ overlayOpacity } onChange={ ( next ) => setAttributes( { overlayOpacity: next } ) } __nextHasNoMarginBottom __next40pxDefaultSize />
				</PanelBody>
			</InspectorControls>
			<InspectorControls group="color">
				<ColorGradientSettingsDropdown
					__experimentalIsRenderedInSidebar
					settings={ [ { label: __( 'Overlay', 'addax-core' ), colorValue: overlayColor, onColorChange: ( next ) => setAttributes( { overlayColor: next || '#000000' } ) } ] }
					panelId={ clientId }
					{ ...colorSettings }
				/>
			</InspectorControls>
			<div { ...blockProps }>
				{ mediaUrl && <img className="addax-hero-slide__bg" src={ mediaUrl } alt="" style={ { objectPosition: `${ focalPoint.x * 100 }% ${ focalPoint.y * 100 }%`, transform: 'none' } } /> }
				<span className="addax-hero-slide__overlay" style={ { backgroundColor: overlayColor, opacity: overlayOpacity / 100 } } />
				<div { ...innerBlocksProps } />
			</div>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
} );
