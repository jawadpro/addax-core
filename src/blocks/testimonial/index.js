import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';

function Edit( { attributes, setAttributes } ) {
	const { quote, name, role, mediaId, mediaUrl } = attributes;
	const blockProps = useBlockProps( { className: 'addax-testimonial' } );

	return (
		<figure { ...blockProps }>
			<blockquote className="addax-testimonial__quote">
				<RichText tagName="p" value={ quote } onChange={ ( next ) => setAttributes( { quote: next } ) } placeholder={ __( 'What did the client say?', 'addax-core' ) } allowedFormats={ [ 'core/bold', 'core/italic' ] } />
			</blockquote>
			<figcaption className="addax-testimonial__client">
				<MediaUploadCheck>
					<MediaUpload
						allowedTypes={ [ 'image' ] }
						value={ mediaId }
						onSelect={ ( media ) => setAttributes( { mediaId: media.id, mediaUrl: media.sizes?.thumbnail?.url || media.url } ) }
						render={ ( { open } ) => (
							<Button className="addax-testimonial__avatar" onClick={ open } label={ __( 'Client photo', 'addax-core' ) } showTooltip>
								{ mediaUrl ? <img src={ mediaUrl } alt="" /> : <span aria-hidden="true">+</span> }
							</Button>
						) }
					/>
				</MediaUploadCheck>
				<span className="addax-testimonial__meta">
					<RichText tagName="cite" className="addax-testimonial__name" value={ name } onChange={ ( next ) => setAttributes( { name: next } ) } placeholder={ __( 'Client name', 'addax-core' ) } allowedFormats={ [] } />
					<RichText tagName="span" className="addax-testimonial__role" value={ role } onChange={ ( next ) => setAttributes( { role: next } ) } placeholder={ __( 'Role, company', 'addax-core' ) } allowedFormats={ [] } />
				</span>
			</figcaption>
		</figure>
	);
}

registerBlockType( metadata.name, { edit: Edit } );
