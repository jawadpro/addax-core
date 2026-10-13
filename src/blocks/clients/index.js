import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls, MediaPlaceholder, MediaUpload, MediaUploadCheck, BlockControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl, RangeControl, TextControl, Button, ToolbarButton, Flex, FlexItem } from '@wordpress/components';
import { __, sprintf } from '@wordpress/i18n';
import metadata from './block.json';
import './style.scss';

const toLogo = ( media ) => ( { id: media.id, url: media.url, alt: media.alt || '', href: '' } );

function Edit( { attributes, setAttributes } ) {
	const { logos, marquee, grayscale, speed, logoHeight, gap } = attributes;
	const blockProps = useBlockProps( {
		className: [ grayscale && 'is-grayscale', 'is-static' ].filter( Boolean ).join( ' ' ),
		style: { '--addax-logo-h': `${ logoHeight }px`, '--addax-logo-gap': `${ gap }px` },
	} );

	const updateLogo = ( index, patch ) =>
		setAttributes( { logos: logos.map( ( logo, i ) => ( i === index ? { ...logo, ...patch } : logo ) ) } );
	const removeLogo = ( index ) => setAttributes( { logos: logos.filter( ( logo, i ) => i !== index ) } );
	const addLogos = ( media ) => {
		const existing = logos.filter( ( logo ) => logo.id );
		const ids = existing.map( ( logo ) => logo.id );
		const merged = media.map( ( item ) => logos.find( ( logo ) => logo.id === item.id ) || toLogo( item ) );
		// Keep theme-bundled logos (no id) that the media frame doesn't know about.
		setAttributes( { logos: [ ...logos.filter( ( logo ) => ! logo.id ), ...merged ] } );
		return ids;
	};

	if ( ! logos.length ) {
		return (
			<div { ...blockProps }>
				<MediaPlaceholder
					icon="images-alt2"
					labels={ { title: __( 'Client logos', 'addax-core' ), instructions: __( 'Upload or pick logos. Transparent PNG or SVG works best.', 'addax-core' ) } }
					onSelect={ ( media ) => setAttributes( { logos: media.map( toLogo ) } ) }
					accept="image/*"
					allowedTypes={ [ 'image' ] }
					multiple
				/>
			</div>
		);
	}

	return (
		<>
			<BlockControls>
				<MediaUploadCheck>
					<MediaUpload
						multiple
						gallery={ false }
						allowedTypes={ [ 'image' ] }
						value={ logos.filter( ( l ) => l.id ).map( ( l ) => l.id ) }
						onSelect={ addLogos }
						render={ ( { open } ) => <ToolbarButton onClick={ open }>{ __( 'Edit logos', 'addax-core' ) }</ToolbarButton> }
					/>
				</MediaUploadCheck>
			</BlockControls>
			<InspectorControls>
				<PanelBody title={ __( 'Display', 'addax-core' ) }>
					<ToggleControl label={ __( 'Scroll continuously', 'addax-core' ) } checked={ marquee } onChange={ ( next ) => setAttributes( { marquee: next } ) } help={ __( 'Pauses on hover. Visitors who prefer reduced motion see a static row.', 'addax-core' ) } __nextHasNoMarginBottom />
					{ marquee && <RangeControl label={ __( 'Seconds per loop', 'addax-core' ) } min={ 10 } max={ 90 } value={ speed } onChange={ ( next ) => setAttributes( { speed: next } ) } __nextHasNoMarginBottom __next40pxDefaultSize /> }
					<ToggleControl label={ __( 'Grayscale until hover', 'addax-core' ) } checked={ grayscale } onChange={ ( next ) => setAttributes( { grayscale: next } ) } __nextHasNoMarginBottom />
					<RangeControl label={ __( 'Logo height (px)', 'addax-core' ) } min={ 24 } max={ 160 } value={ logoHeight } onChange={ ( next ) => setAttributes( { logoHeight: next } ) } __nextHasNoMarginBottom __next40pxDefaultSize />
					<RangeControl label={ __( 'Space between (px)', 'addax-core' ) } min={ 8 } max={ 160 } value={ gap } onChange={ ( next ) => setAttributes( { gap: next } ) } __nextHasNoMarginBottom __next40pxDefaultSize />
				</PanelBody>
				<PanelBody title={ __( 'Logos', 'addax-core' ) } initialOpen={ false }>
					{ logos.map( ( logo, index ) => (
						<div key={ index } style={ { marginBottom: 16, paddingBottom: 16, borderBottom: '1px solid #ddd' } }>
							<Flex align="center">
								<FlexItem><img src={ logo.url } alt="" style={ { height: 32, width: 'auto', background: '#888', padding: 4 } } /></FlexItem>
								<FlexItem><Button isDestructive variant="link" onClick={ () => removeLogo( index ) }>{ __( 'Remove', 'addax-core' ) }</Button></FlexItem>
							</Flex>
							<TextControl label={ sprintf( /* translators: %d: logo number */ __( 'Logo %d alt text', 'addax-core' ), index + 1 ) } value={ logo.alt } onChange={ ( next ) => updateLogo( index, { alt: next } ) } __nextHasNoMarginBottom __next40pxDefaultSize />
							<TextControl label={ __( 'Link (optional)', 'addax-core' ) } type="url" value={ logo.href || '' } onChange={ ( next ) => updateLogo( index, { href: next } ) } __nextHasNoMarginBottom __next40pxDefaultSize />
						</div>
					) ) }
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<ul className="addax-clients__track">
					{ logos.map( ( logo, index ) => (
						<li key={ index } className="addax-clients__logo">
							<img src={ logo.url } alt={ logo.alt } />
						</li>
					) ) }
				</ul>
			</div>
		</>
	);
}

registerBlockType( metadata.name, { edit: Edit } );
