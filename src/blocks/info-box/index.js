import { registerBlockType } from '@wordpress/blocks';
import {
	useBlockProps,
	RichText,
	InspectorControls,
	BlockControls,
	AlignmentControl,
	MediaUpload,
	MediaUploadCheck,
	MediaPlaceholder,
	HeadingLevelDropdown,
	__experimentalLinkControl as LinkControl,
	__experimentalColorGradientSettingsDropdown as ColorGradientSettingsDropdown,
	__experimentalUseMultipleOriginColorsAndGradients as useMultipleOriginColorsAndGradients,
} from '@wordpress/block-editor';
import { PanelBody, SelectControl, TextControl, Button, BaseControl, ToolbarButton, Popover } from '@wordpress/components';
import { useState } from '@wordpress/element';
import { link as linkIcon } from '@wordpress/icons';
import { __ } from '@wordpress/i18n';
import { AddaxIcon, IconPicker } from '../../shared/icon';
import metadata from './block.json';
import './style.scss';
import '../../shared/editor.scss';

function Edit( { attributes, setAttributes, clientId } ) {
	const { variant, mediaType, icon, mediaId, mediaUrl, mediaAlt, title, text, level, url, linkText, accentColor, textAlign } = attributes;
	const [ linkOpen, setLinkOpen ] = useState( false );
	const [ anchor, setAnchor ] = useState();
	const colorSettings = useMultipleOriginColorsAndGradients();
	const Tag = `h${ level }`;

	const blockProps = useBlockProps( {
		className: [ `is-variant-${ variant }`, textAlign && `has-text-align-${ textAlign }` ].filter( Boolean ).join( ' ' ),
		style: accentColor ? { '--addax-accent': accentColor } : undefined,
	} );

	const onSelectImage = ( media ) =>
		setAttributes( { mediaId: media.id, mediaUrl: media.url, mediaAlt: media.alt || '', mediaType: 'image' } );

	let media = null;
	if ( mediaType === 'icon' ) {
		media = (
			<div className="addax-info-box__media is-icon">
				<AddaxIcon name={ icon } size={ 40 } />
			</div>
		);
	} else if ( mediaType === 'image' ) {
		media = mediaUrl ? (
			<div className="addax-info-box__media is-image">
				<img src={ mediaUrl } alt={ mediaAlt } />
			</div>
		) : (
			<MediaPlaceholder icon="format-image" labels={ { title: __( 'Info box image', 'addax-core' ) } } onSelect={ onSelectImage } accept="image/*" allowedTypes={ [ 'image' ] } />
		);
	}

	return (
		<>
			<BlockControls group="block">
				<HeadingLevelDropdown value={ level } options={ [ 2, 3, 4, 5, 6 ] } onChange={ ( next ) => setAttributes( { level: next } ) } />
				<AlignmentControl value={ textAlign } onChange={ ( next ) => setAttributes( { textAlign: next } ) } />
				<ToolbarButton ref={ setAnchor } icon={ linkIcon } label={ __( 'Link', 'addax-core' ) } isPressed={ !! url } onClick={ () => setLinkOpen( ! linkOpen ) } />
			</BlockControls>
			{ linkOpen && (
				<Popover anchor={ anchor } onClose={ () => setLinkOpen( false ) } placement="bottom">
					<LinkControl
						value={ { url } }
						onChange={ ( next ) => setAttributes( { url: next.url || '' } ) }
						onRemove={ () => setAttributes( { url: '' } ) }
						settings={ [] }
					/>
				</Popover>
			) }
			<InspectorControls>
				<PanelBody title={ __( 'Layout', 'addax-core' ) }>
					<SelectControl
						label={ __( 'Style', 'addax-core' ) }
						value={ variant }
						options={ [
							{ label: __( 'Classic (centred, hover underline)', 'addax-core' ), value: 'classic' },
							{ label: __( 'Modern (framed card)', 'addax-core' ), value: 'modern' },
							{ label: __( 'Inline (icon beside text)', 'addax-core' ), value: 'inline' },
						] }
						onChange={ ( next ) => setAttributes( { variant: next } ) }
						__nextHasNoMarginBottom
						__next40pxDefaultSize
					/>
					<SelectControl
						label={ __( 'Media', 'addax-core' ) }
						value={ mediaType }
						options={ [
							{ label: __( 'Icon', 'addax-core' ), value: 'icon' },
							{ label: __( 'Image', 'addax-core' ), value: 'image' },
							{ label: __( 'None', 'addax-core' ), value: 'none' },
						] }
						onChange={ ( next ) => setAttributes( { mediaType: next } ) }
						__nextHasNoMarginBottom
						__next40pxDefaultSize
					/>
					{ mediaType === 'icon' && (
						<BaseControl label={ __( 'Icon', 'addax-core' ) } __nextHasNoMarginBottom>
							<IconPicker value={ icon } onChange={ ( next ) => setAttributes( { icon: next } ) } />
						</BaseControl>
					) }
					{ mediaType === 'image' && (
						<MediaUploadCheck>
							<MediaUpload
								onSelect={ onSelectImage }
								allowedTypes={ [ 'image' ] }
								value={ mediaId }
								render={ ( { open } ) => (
									<Button variant="secondary" onClick={ open }>
										{ mediaUrl ? __( 'Replace image', 'addax-core' ) : __( 'Choose image', 'addax-core' ) }
									</Button>
								) }
							/>
						</MediaUploadCheck>
					) }
					{ url && (
						<TextControl
							label={ __( '"Read more" text', 'addax-core' ) }
							help={ __( 'Leave empty to link the title only.', 'addax-core' ) }
							value={ linkText }
							onChange={ ( next ) => setAttributes( { linkText: next } ) }
							__nextHasNoMarginBottom
							__next40pxDefaultSize
						/>
					) }
				</PanelBody>
			</InspectorControls>
			<InspectorControls group="color">
				<ColorGradientSettingsDropdown
					__experimentalIsRenderedInSidebar
					settings={ [ { label: __( 'Accent', 'addax-core' ), colorValue: accentColor, onColorChange: ( next ) => setAttributes( { accentColor: next || '' } ) } ] }
					panelId={ clientId }
					{ ...colorSettings }
				/>
			</InspectorControls>
			<div { ...blockProps }>
				{ media }
				<div className="addax-info-box__body">
					<RichText
						tagName={ Tag }
						className="addax-info-box__title"
						value={ title }
						onChange={ ( next ) => setAttributes( { title: next } ) }
						placeholder={ __( 'Title', 'addax-core' ) }
						allowedFormats={ [ 'core/bold', 'core/italic' ] }
					/>
					<RichText
						tagName="p"
						className="addax-info-box__text"
						value={ text }
						onChange={ ( next ) => setAttributes( { text: next } ) }
						placeholder={ __( 'Describe this service…', 'addax-core' ) }
					/>
					{ url && linkText && <span className="addax-info-box__more">{ linkText }</span> }
				</div>
			</div>
		</>
	);
}

registerBlockType( metadata.name, { edit: Edit } );
