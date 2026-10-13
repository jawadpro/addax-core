/**
 * Editor sidebar panels for the Addax page options and project details,
 * plus the editor side of the "Addax settings" block bindings source.
 */
import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/editor';
import { SelectControl, ToggleControl, TextControl, __experimentalVStack as VStack } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { store as editorStore } from '@wordpress/editor';
import { useEntityProp } from '@wordpress/core-data';
import { registerBlockBindingsSource } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

const LAYOUT_TYPES = [ 'post', 'page', 'addax-project' ];

function usePostMeta() {
	const postType = useSelect( ( select ) => select( editorStore ).getCurrentPostType(), [] );
	const [ meta, setMeta ] = useEntityProp( 'postType', postType, 'meta' );
	return { postType, meta: meta || {}, update: ( key, value ) => setMeta( { ...meta, [ key ]: value } ) };
}

function LayoutPanel() {
	const { postType, meta, update } = usePostMeta();
	if ( ! LAYOUT_TYPES.includes( postType ) || meta.addax_header_style === undefined ) {
		return null;
	}

	return (
		<PluginDocumentSettingPanel name="addax-layout" title={ __( 'Addax layout', 'addax-core' ) }>
			<VStack spacing={ 4 }>
				<SelectControl
					label={ __( 'Header', 'addax-core' ) }
					value={ meta.addax_header_style }
					options={ [
						{ label: __( 'Template default', 'addax-core' ), value: '' },
						{ label: __( 'Standard', 'addax-core' ), value: 'default' },
						{ label: __( 'Transparent overlay', 'addax-core' ), value: 'overlay' },
						{ label: __( 'Business (with top bar)', 'addax-core' ), value: 'business' },
						{ label: __( 'No header', 'addax-core' ), value: 'none' },
					] }
					onChange={ ( value ) => update( 'addax_header_style', value ) }
					help={ meta.addax_header_style === 'overlay' ? __( 'Best with a hero, slider or cover block at the top of the page.', 'addax-core' ) : undefined }
					__nextHasNoMarginBottom
					__next40pxDefaultSize
				/>
				<SelectControl
					label={ __( 'Footer', 'addax-core' ) }
					value={ meta.addax_footer_style }
					options={ [
						{ label: __( 'Template default', 'addax-core' ), value: '' },
						{ label: __( 'Four columns', 'addax-core' ), value: 'default' },
						{ label: __( 'Simple', 'addax-core' ), value: 'simple' },
						{ label: __( 'No footer', 'addax-core' ), value: 'none' },
					] }
					onChange={ ( value ) => update( 'addax_footer_style', value ) }
					__nextHasNoMarginBottom
					__next40pxDefaultSize
				/>
				<ToggleControl
					label={ __( 'Hide title bar', 'addax-core' ) }
					checked={ !! meta.addax_hide_title }
					onChange={ ( value ) => update( 'addax_hide_title', value ) }
					__nextHasNoMarginBottom
				/>
			</VStack>
		</PluginDocumentSettingPanel>
	);
}

function ProjectPanel() {
	const { postType, meta, update } = usePostMeta();
	if ( postType !== 'addax-project' ) {
		return null;
	}
	const field = ( key, label, props = {} ) => (
		<TextControl label={ label } value={ meta[ key ] || '' } onChange={ ( value ) => update( key, value ) } __nextHasNoMarginBottom __next40pxDefaultSize { ...props } />
	);

	return (
		<PluginDocumentSettingPanel name="addax-project" title={ __( 'Project details', 'addax-core' ) }>
			<VStack spacing={ 4 }>
				{ field( 'addax_project_client', __( 'Client', 'addax-core' ) ) }
				{ field( 'addax_project_year', __( 'Year', 'addax-core' ) ) }
				{ field( 'addax_project_services', __( 'Services', 'addax-core' ), { help: __( 'For example: Branding, Web design', 'addax-core' ) } ) }
				{ field( 'addax_project_url', __( 'Live URL', 'addax-core' ), { type: 'url', placeholder: 'https://' } ) }
			</VStack>
		</PluginDocumentSettingPanel>
	);
}

registerPlugin( 'addax-core-panels', {
	render: () => (
		<>
			<LayoutPanel />
			<ProjectPanel />
		</>
	),
} );

// Editor preview for {"source":"addax/options"} bindings (WordPress 6.7+).
if ( typeof registerBlockBindingsSource === 'function' ) {
	const options = window.addaxCoreOptions || {};
	const read = ( key ) => {
		if ( ! key ) {
			return undefined;
		}
		if ( key.startsWith( 'social.' ) ) {
			return options.social?.[ key.slice( 7 ) ] || undefined;
		}
		if ( key === 'phone_url' ) {
			return options.phone ? `tel:${ options.phone.replace( /[^0-9+]/g, '' ) }` : undefined;
		}
		if ( key === 'email_url' ) {
			return options.email ? `mailto:${ options.email }` : undefined;
		}
		return options[ key ] || undefined;
	};

	try {
		registerBlockBindingsSource( {
			name: 'addax/options',
			label: __( 'Addax settings', 'addax-core' ),
			getValues( { bindings } ) {
				const values = {};
				for ( const [ attribute, binding ] of Object.entries( bindings ) ) {
					const value = read( binding.args?.key );
					if ( value !== undefined ) {
						values[ attribute ] = value;
					}
				}
				return values;
			},
			canUserEditValue: () => false,
		} );
	} catch ( e ) {
		// Older WordPress: the front end still resolves bindings.
	}
}
