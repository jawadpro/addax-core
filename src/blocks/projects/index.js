import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, RangeControl, ToggleControl, SelectControl, TextControl, FormTokenField, Disabled, Notice } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';
import ServerSideRender from '@wordpress/server-side-render';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';
import './style.scss';

function Edit( { attributes, setAttributes } ) {
	const { count, columns, categories, showFilters, showExcerpt, orderBy, order, aspectRatio, gap, allLabel } = attributes;
	const blockProps = useBlockProps();
	const terms = useSelect( ( select ) => select( coreStore ).getEntityRecords( 'taxonomy', 'adx-project-category', { per_page: 100, hide_empty: false } ) || [], [] );
	const total = useSelect( ( select ) => {
		const records = select( coreStore ).getEntityRecords( 'postType', 'addax-project', { per_page: 1, status: 'publish' } );
		return records ? records.length : null;
	}, [] );

	const selectedNames = terms.filter( ( term ) => categories.includes( term.id ) ).map( ( term ) => term.name );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Query', 'addax-core' ) }>
					<RangeControl label={ __( 'Number of projects', 'addax-core' ) } min={ 1 } max={ 48 } value={ count } onChange={ ( next ) => setAttributes( { count: next } ) } __nextHasNoMarginBottom __next40pxDefaultSize />
					<FormTokenField
						label={ __( 'Only these categories', 'addax-core' ) }
						value={ selectedNames }
						suggestions={ terms.map( ( term ) => term.name ) }
						onChange={ ( names ) => setAttributes( { categories: terms.filter( ( term ) => names.includes( term.name ) ).map( ( term ) => term.id ) } ) }
						__experimentalExpandOnFocus
						__nextHasNoMarginBottom
						__next40pxDefaultSize
					/>
					<SelectControl
						label={ __( 'Order by', 'addax-core' ) }
						value={ `${ orderBy }/${ order }` }
						options={ [
							{ label: __( 'Newest first', 'addax-core' ), value: 'date/desc' },
							{ label: __( 'Oldest first', 'addax-core' ), value: 'date/asc' },
							{ label: __( 'Title A → Z', 'addax-core' ), value: 'title/asc' },
							{ label: __( 'Title Z → A', 'addax-core' ), value: 'title/desc' },
							{ label: __( 'Menu order', 'addax-core' ), value: 'menu_order/asc' },
							{ label: __( 'Random', 'addax-core' ), value: 'rand/desc' },
						] }
						onChange={ ( next ) => {
							const [ by, dir ] = next.split( '/' );
							setAttributes( { orderBy: by, order: dir } );
						} }
						__nextHasNoMarginBottom
						__next40pxDefaultSize
					/>
				</PanelBody>
				<PanelBody title={ __( 'Layout', 'addax-core' ) }>
					<RangeControl label={ __( 'Columns', 'addax-core' ) } min={ 1 } max={ 6 } value={ columns } onChange={ ( next ) => setAttributes( { columns: next } ) } __nextHasNoMarginBottom __next40pxDefaultSize />
					<RangeControl label={ __( 'Gap (px)', 'addax-core' ) } min={ 0 } max={ 48 } value={ gap } onChange={ ( next ) => setAttributes( { gap: next } ) } __nextHasNoMarginBottom __next40pxDefaultSize />
					<SelectControl
						label={ __( 'Image shape', 'addax-core' ) }
						value={ aspectRatio }
						options={ [
							{ label: __( 'Square', 'addax-core' ), value: '1/1' },
							{ label: __( 'Landscape (4:3)', 'addax-core' ), value: '4/3' },
							{ label: __( 'Portrait (3:4)', 'addax-core' ), value: '3/4' },
						] }
						onChange={ ( next ) => setAttributes( { aspectRatio: next } ) }
						__nextHasNoMarginBottom
						__next40pxDefaultSize
					/>
					<ToggleControl label={ __( 'Category filters', 'addax-core' ) } checked={ showFilters } onChange={ ( next ) => setAttributes( { showFilters: next } ) } __nextHasNoMarginBottom />
					{ showFilters && <TextControl label={ __( '"All" button label', 'addax-core' ) } value={ allLabel } placeholder={ __( 'All', 'addax-core' ) } onChange={ ( next ) => setAttributes( { allLabel: next } ) } __nextHasNoMarginBottom __next40pxDefaultSize /> }
					<ToggleControl label={ __( 'Show excerpt on hover', 'addax-core' ) } checked={ showExcerpt } onChange={ ( next ) => setAttributes( { showExcerpt: next } ) } __nextHasNoMarginBottom />
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				{ total === 0 && (
					<Notice status="info" isDismissible={ false }>
						{ __( 'No projects yet. Add some under Projects → Add New Project, then they will appear here.', 'addax-core' ) }
					</Notice>
				) }
				<Disabled>
					<ServerSideRender block={ metadata.name } attributes={ attributes } skipBlockSupportAttributes />
				</Disabled>
			</div>
		</>
	);
}

registerBlockType( metadata.name, { edit: Edit } );
