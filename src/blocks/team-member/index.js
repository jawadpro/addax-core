import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText, InspectorControls, MediaPlaceholder, MediaReplaceFlow, BlockControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, TextControl, FocalPointPicker } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';
import './style.scss';

function Edit( { attributes, setAttributes } ) {
	const { mediaId, mediaUrl, mediaAlt, name, role, url, aspectRatio, focalPoint } = attributes;
	const blockProps = useBlockProps( { style: { '--addax-team-ratio': aspectRatio } } );
	const onSelect = ( media ) => setAttributes( { mediaId: media.id, mediaUrl: media.url, mediaAlt: media.alt || '' } );
	const position = `${ focalPoint.x * 100 }% ${ focalPoint.y * 100 }%`;

	return (
		<>
			{ mediaUrl && (
				<BlockControls group="other">
					<MediaReplaceFlow mediaId={ mediaId } mediaURL={ mediaUrl } allowedTypes={ [ 'image' ] } accept="image/*" onSelect={ onSelect } name={ __( 'Replace photo', 'addax-core' ) } />
				</BlockControls>
			) }
			<InspectorControls>
				<PanelBody title={ __( 'Team member', 'addax-core' ) }>
					<SelectControl
						label={ __( 'Shape', 'addax-core' ) }
						value={ aspectRatio }
						options={ [
							{ label: __( 'Portrait (3:4)', 'addax-core' ), value: '3/4' },
							{ label: __( 'Square', 'addax-core' ), value: '1/1' },
							{ label: __( 'Tall (2:3)', 'addax-core' ), value: '2/3' },
						] }
						onChange={ ( next ) => setAttributes( { aspectRatio: next } ) }
						__nextHasNoMarginBottom
						__next40pxDefaultSize
					/>
					{ mediaUrl && <FocalPointPicker label={ __( 'Focal point', 'addax-core' ) } url={ mediaUrl } value={ focalPoint } onChange={ ( next ) => setAttributes( { focalPoint: next } ) } __nextHasNoMarginBottom /> }
					<TextControl label={ __( 'Profile link (optional)', 'addax-core' ) } type="url" value={ url } onChange={ ( next ) => setAttributes( { url: next } ) } __nextHasNoMarginBottom __next40pxDefaultSize />
					<TextControl label={ __( 'Photo alt text', 'addax-core' ) } value={ mediaAlt } onChange={ ( next ) => setAttributes( { mediaAlt: next } ) } __nextHasNoMarginBottom __next40pxDefaultSize />
				</PanelBody>
			</InspectorControls>
			<figure { ...blockProps }>
				{ mediaUrl ? (
					<img className="addax-team__img" src={ mediaUrl } alt={ mediaAlt } style={ { objectPosition: position } } />
				) : (
					<MediaPlaceholder icon="admin-users" labels={ { title: __( 'Photo', 'addax-core' ) } } onSelect={ onSelect } accept="image/*" allowedTypes={ [ 'image' ] } />
				) }
				<span className="addax-team__overlay" aria-hidden="true" />
				<figcaption className="addax-team__info is-editing">
					<RichText tagName="strong" className="addax-team__name" value={ name } onChange={ ( next ) => setAttributes( { name: next } ) } placeholder={ __( 'Name', 'addax-core' ) } allowedFormats={ [] } />
					<RichText tagName="span" className="addax-team__role" value={ role } onChange={ ( next ) => setAttributes( { role: next } ) } placeholder={ __( 'Role', 'addax-core' ) } allowedFormats={ [] } />
				</figcaption>
			</figure>
		</>
	);
}

registerBlockType( metadata.name, { edit: Edit } );
