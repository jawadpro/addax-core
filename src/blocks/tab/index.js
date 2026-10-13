import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, useInnerBlocksProps, InnerBlocks, InspectorControls, store as blockEditorStore } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';

function Edit( { attributes, setAttributes, clientId, context } ) {
	const index = useSelect( ( select ) => select( blockEditorStore ).getBlockIndex( clientId ), [ clientId ] );
	const hasSelection = useSelect( ( select ) => select( blockEditorStore ).hasSelectedInnerBlock( clientId, true ) || select( blockEditorStore ).isBlockSelected( clientId ), [ clientId ] );
	const isActive = index === ( context[ 'addax/activeTab' ] || 0 ) || hasSelection;

	const blockProps = useBlockProps( { className: 'addax-tabs__panel', hidden: ! isActive } );
	const innerBlocksProps = useInnerBlocksProps( blockProps, { template: [ [ 'core/paragraph' ] ], renderAppender: InnerBlocks.DefaultBlockAppender } );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Tab', 'addax-core' ) }>
					<TextControl label={ __( 'Title', 'addax-core' ) } value={ attributes.title } onChange={ ( next ) => setAttributes( { title: next } ) } __nextHasNoMarginBottom __next40pxDefaultSize />
				</PanelBody>
			</InspectorControls>
			<div { ...innerBlocksProps } />
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
} );
