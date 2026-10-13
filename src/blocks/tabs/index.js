import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, useInnerBlocksProps, InnerBlocks, InspectorControls, RichText, store as blockEditorStore } from '@wordpress/block-editor';
import { PanelBody, SelectControl, Button } from '@wordpress/components';
import { useSelect, useDispatch } from '@wordpress/data';
import { createBlock } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';
import './style.scss';
import './editor.scss';

const TEMPLATE = [
	[ 'addax/tab', { title: __( 'Design', 'addax-core' ) }, [ [ 'core/paragraph', { placeholder: __( 'Tab content…', 'addax-core' ) } ] ] ],
	[ 'addax/tab', { title: __( 'Develop', 'addax-core' ) }, [ [ 'core/paragraph', { placeholder: __( 'Tab content…', 'addax-core' ) } ] ] ],
	[ 'addax/tab', { title: __( 'Launch', 'addax-core' ) }, [ [ 'core/paragraph', { placeholder: __( 'Tab content…', 'addax-core' ) } ] ] ],
];

function Edit( { attributes, setAttributes, clientId } ) {
	const { variant, navAlign, activeTab } = attributes;
	const tabs = useSelect( ( select ) => select( blockEditorStore ).getBlocks( clientId ), [ clientId ] );
	const { updateBlockAttributes, insertBlock, selectBlock } = useDispatch( blockEditorStore );

	const blockProps = useBlockProps( { className: `is-variant-${ variant } is-nav-${ navAlign }` } );
	const innerBlocksProps = useInnerBlocksProps(
		{ className: 'addax-tabs__panels' },
		{ allowedBlocks: [ 'addax/tab' ], template: TEMPLATE, renderAppender: false }
	);

	const active = Math.min( activeTab, Math.max( tabs.length - 1, 0 ) );

	const addTab = () => {
		const block = createBlock( 'addax/tab', { title: __( 'New tab', 'addax-core' ) }, [ createBlock( 'core/paragraph' ) ] );
		insertBlock( block, tabs.length, clientId, false );
		setAttributes( { activeTab: tabs.length } );
	};

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Tabs', 'addax-core' ) }>
					<SelectControl
						label={ __( 'Navigation style', 'addax-core' ) }
						value={ variant }
						options={ [
							{ label: __( 'Bullets', 'addax-core' ), value: 'bullets' },
							{ label: __( 'Pills', 'addax-core' ), value: 'pills' },
							{ label: __( 'Underline', 'addax-core' ), value: 'underline' },
						] }
						onChange={ ( next ) => setAttributes( { variant: next } ) }
						__nextHasNoMarginBottom
						__next40pxDefaultSize
					/>
					<SelectControl
						label={ __( 'Navigation alignment', 'addax-core' ) }
						value={ navAlign }
						options={ [
							{ label: __( 'Left', 'addax-core' ), value: 'left' },
							{ label: __( 'Centre', 'addax-core' ), value: 'center' },
							{ label: __( 'Right', 'addax-core' ), value: 'right' },
						] }
						onChange={ ( next ) => setAttributes( { navAlign: next } ) }
						__nextHasNoMarginBottom
						__next40pxDefaultSize
					/>
					<p className="components-base-control__help">{ __( 'The tab selected in the editor is the one open when the page loads.', 'addax-core' ) }</p>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<div className="addax-tabs__nav" role="tablist">
					{ tabs.map( ( tab, index ) => (
						<div key={ tab.clientId } className={ `addax-tabs__tab${ index === active ? ' is-active' : '' }` } role="tab" aria-selected={ index === active }>
							{ index === active ? (
								<RichText
									tagName="span"
									value={ tab.attributes.title }
									onChange={ ( next ) => updateBlockAttributes( tab.clientId, { title: next } ) }
									placeholder={ __( 'Tab title', 'addax-core' ) }
									allowedFormats={ [] }
								/>
							) : (
								<button type="button" onClick={ () => setAttributes( { activeTab: index } ) } onDoubleClick={ () => selectBlock( tab.clientId ) }>
									{ tab.attributes.title || __( 'Untitled', 'addax-core' ) }
								</button>
							) }
						</div>
					) ) }
					<Button className="addax-tabs__add" icon="plus" label={ __( 'Add tab', 'addax-core' ) } onClick={ addTab } size="small" />
				</div>
				<div { ...innerBlocksProps } />
			</div>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
} );
