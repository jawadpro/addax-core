/**
 * Addax Settings screen: a small React app over /wp/v2/settings (option: addax_options).
 */
import apiFetch from '@wordpress/api-fetch';
import { createRoot, useEffect, useState } from '@wordpress/element';
import {
	Button,
	Card,
	CardBody,
	CardHeader,
	Notice,
	SelectControl,
	Spinner,
	TabPanel,
	TextControl,
	ToggleControl,
	__experimentalVStack as VStack,
} from '@wordpress/components';
import { __, sprintf } from '@wordpress/i18n';
import './settings.scss';

const NETWORKS = [
	[ 'facebook', 'Facebook' ],
	[ 'x', 'X (Twitter)' ],
	[ 'instagram', 'Instagram' ],
	[ 'linkedin', 'LinkedIn' ],
	[ 'dribbble', 'Dribbble' ],
	[ 'youtube', 'YouTube' ],
	[ 'github', 'GitHub' ],
];

function Field( props ) {
	return <TextControl __nextHasNoMarginBottom __next40pxDefaultSize { ...props } />;
}

function DemoTool( { setNotice } ) {
	const [ busy, setBusy ] = useState( false );
	const run = () => {
		setBusy( true );
		apiFetch( { path: '/addax/v1/demo-projects', method: 'POST' } )
			.then( ( result ) =>
				setNotice( {
					status: 'success',
					text: result.created
						? sprintf( /* translators: %d: number of projects */ __( 'Added %d demo projects. View them under Projects.', 'addax-core' ), result.created )
						: __( 'The demo projects are already there.', 'addax-core' ),
				} )
			)
			.catch( ( error ) => setNotice( { status: 'error', text: error.message } ) )
			.finally( () => setBusy( false ) );
	};
	return (
		<VStack spacing={ 3 }>
			<p className="addax-settings__intro">
				{ __( 'Adds eight sample projects with categories, images and details, so the Our Work grid has something to show. Running it again skips projects that already exist.', 'addax-core' ) }
			</p>
			<div>
				<Button variant="secondary" onClick={ run } isBusy={ busy } disabled={ busy } __next40pxDefaultSize>
					{ __( 'Import demo projects', 'addax-core' ) }
				</Button>
			</div>
		</VStack>
	);
}

function App() {
	const [ options, setOptions ] = useState( null );
	const [ saving, setSaving ] = useState( false );
	const [ notice, setNotice ] = useState( null );
	const [ dirty, setDirty ] = useState( false );

	useEffect( () => {
		apiFetch( { path: '/wp/v2/settings' } )
			.then( ( settings ) => setOptions( settings.addax_options || {} ) )
			.catch( ( error ) => setNotice( { status: 'error', text: error.message } ) );
	}, [] );

	useEffect( () => {
		const warn = ( event ) => {
			if ( dirty ) {
				event.preventDefault();
				event.returnValue = '';
			}
		};
		window.addEventListener( 'beforeunload', warn );
		return () => window.removeEventListener( 'beforeunload', warn );
	}, [ dirty ] );

	if ( ! options ) {
		return notice ? <Notice status="error" isDismissible={ false }>{ notice.text }</Notice> : <Spinner />;
	}

	const set = ( key, value ) => {
		setOptions( { ...options, [ key ]: value } );
		setDirty( true );
	};
	const setSocial = ( key, value ) => set( 'social', { ...( options.social || {} ), [ key ]: value } );

	const save = () => {
		setSaving( true );
		setNotice( null );
		apiFetch( { path: '/wp/v2/settings', method: 'POST', data: { addax_options: options } } )
			.then( ( settings ) => {
				setOptions( settings.addax_options );
				setDirty( false );
				setNotice( { status: 'success', text: __( 'Settings saved.', 'addax-core' ) } );
			} )
			.catch( ( error ) => setNotice( { status: 'error', text: error.message } ) )
			.finally( () => setSaving( false ) );
	};

	const tabs = [
		{
			name: 'contact',
			title: __( 'Contact', 'addax-core' ),
			body: (
				<VStack spacing={ 4 }>
					<p className="addax-settings__intro">
						{ __( 'Used by the top bar, header info, footer and Map block. Bind any Paragraph, Heading or Button to these values from the block’s Attributes panel (source “Addax settings”).', 'addax-core' ) }
					</p>
					<Field label={ __( 'Phone', 'addax-core' ) } value={ options.phone } onChange={ ( v ) => set( 'phone', v ) } />
					<Field label={ __( 'Email', 'addax-core' ) } type="email" value={ options.email } onChange={ ( v ) => set( 'email', v ) } />
					<Field label={ __( 'Address', 'addax-core' ) } value={ options.address } onChange={ ( v ) => set( 'address', v ) } />
					<Field label={ __( 'Opening hours', 'addax-core' ) } value={ options.hours } onChange={ ( v ) => set( 'hours', v ) } placeholder={ __( 'Mon–Fri, 9am–6pm', 'addax-core' ) } />
				</VStack>
			),
		},
		{
			name: 'social',
			title: __( 'Social', 'addax-core' ),
			body: (
				<VStack spacing={ 4 }>
					<p className="addax-settings__intro">
						{ __( 'Social Icons blocks whose link is “#” use these URLs. Once any URL is saved, placeholder icons without one are hidden.', 'addax-core' ) }
					</p>
					{ NETWORKS.map( ( [ key, label ] ) => (
						<Field key={ key } label={ label } type="url" placeholder="https://" value={ options.social?.[ key ] || '' } onChange={ ( v ) => setSocial( key, v ) } />
					) ) }
				</VStack>
			),
		},
		{
			name: 'layout',
			title: __( 'Layout', 'addax-core' ),
			body: (
				<VStack spacing={ 5 }>
					<SelectControl
						label={ __( 'Default header', 'addax-core' ) }
						help={ __( 'Applies wherever a template uses the standard header. Pages can override it in the editor sidebar.', 'addax-core' ) }
						value={ options.header_style }
						options={ [
							{ label: __( 'Standard', 'addax-core' ), value: 'default' },
							{ label: __( 'Transparent overlay', 'addax-core' ), value: 'overlay' },
							{ label: __( 'Business (with top bar)', 'addax-core' ), value: 'business' },
						] }
						onChange={ ( v ) => set( 'header_style', v ) }
						__nextHasNoMarginBottom
						__next40pxDefaultSize
					/>
					<ToggleControl label={ __( 'Sticky header', 'addax-core' ) } checked={ !! options.sticky_header } onChange={ ( v ) => set( 'sticky_header', v ) } __nextHasNoMarginBottom />
					<ToggleControl label={ __( 'Back-to-top button', 'addax-core' ) } checked={ !! options.back_to_top } onChange={ ( v ) => set( 'back_to_top', v ) } __nextHasNoMarginBottom />
					<ToggleControl label={ __( 'Reveal sections on scroll', 'addax-core' ) } help={ __( 'Always off for visitors who prefer reduced motion.', 'addax-core' ) } checked={ !! options.reveal_animations } onChange={ ( v ) => set( 'reveal_animations', v ) } __nextHasNoMarginBottom />
				</VStack>
			),
		},
		{
			name: 'tools',
			title: __( 'Tools', 'addax-core' ),
			body: <DemoTool setNotice={ setNotice } />,
		},
		{
			name: 'footer',
			title: __( 'Footer', 'addax-core' ),
			body: (
				<VStack spacing={ 4 }>
					<Field
						label={ __( 'Copyright text', 'addax-core' ) }
						help={ __( '{year} and {site} are replaced automatically.', 'addax-core' ) }
						value={ options.copyright }
						onChange={ ( v ) => set( 'copyright', v ) }
					/>
				</VStack>
			),
		},
	];

	return (
		<div className="addax-settings">
			<header className="addax-settings__header">
				<h1>{ __( 'Addax Settings', 'addax-core' ) }</h1>
				<p>
					{ __( 'Colours, fonts and spacing live in Appearance → Editor → Styles. Headers and footers are template parts you can edit there too.', 'addax-core' ) }{ ' ' }
					<a href="site-editor.php?p=%2Fstyles">{ __( 'Open Styles', 'addax-core' ) }</a>
				</p>
			</header>
			{ notice && (
				<Notice status={ notice.status } onRemove={ () => setNotice( null ) }>
					{ notice.text }
				</Notice>
			) }
			<Card>
				<CardHeader>
					<strong>{ __( 'Site details', 'addax-core' ) }</strong>
					<Button variant="primary" onClick={ save } isBusy={ saving } disabled={ saving || ! dirty } __next40pxDefaultSize>
						{ saving ? __( 'Saving…', 'addax-core' ) : __( 'Save changes', 'addax-core' ) }
					</Button>
				</CardHeader>
				<CardBody>
					<TabPanel className="addax-settings__tabs" tabs={ tabs }>
						{ ( tab ) => <div className="addax-settings__panel">{ tab.body }</div> }
					</TabPanel>
				</CardBody>
			</Card>
		</div>
	);
}

const root = document.getElementById( 'addax-settings-root' );
if ( root ) {
	createRoot( root ).render( <App /> );
}
