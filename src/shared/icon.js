/**
 * Shared icon helpers. The SVG bodies come from src/icons.json, which the PHP
 * renderer reads too, so editor and front end always match.
 */
import { Button, Dropdown, SearchControl } from '@wordpress/components';
import { useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import icons from '../icons.json';

export const ICON_NAMES = Object.keys( icons ).filter(
	( name ) =>
		! [ 'arrow-up', 'arrow-left', 'chevron-left', 'chevron-right', 'chevron-down', 'close', 'plus', 'external' ].includes( name )
);

export function AddaxIcon( { name, size = 24, className } ) {
	if ( ! icons[ name ] ) {
		return null;
	}
	return (
		<svg
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 24 24"
			width={ size }
			height={ size }
			aria-hidden="true"
			focusable="false"
			fill="currentColor"
			className={ className }
			dangerouslySetInnerHTML={ { __html: icons[ name ] } }
		/>
	);
}

export function IconPicker( { value, onChange } ) {
	const [ search, setSearch ] = useState( '' );
	const list = ICON_NAMES.filter( ( name ) => name.includes( search.toLowerCase() ) );

	return (
		<Dropdown
			popoverProps={ { placement: 'left-start' } }
			renderToggle={ ( { isOpen, onToggle } ) => (
				<Button variant="secondary" onClick={ onToggle } aria-expanded={ isOpen } className="addax-icon-picker__toggle">
					<AddaxIcon name={ value } size={ 20 } />
					<span>{ value ? value : __( 'Choose icon', 'addax-core' ) }</span>
				</Button>
			) }
			renderContent={ () => (
				<div className="addax-icon-picker">
					<SearchControl value={ search } onChange={ setSearch } __nextHasNoMarginBottom />
					<div className="addax-icon-picker__grid">
						{ list.map( ( name ) => (
							<Button
								key={ name }
								label={ name }
								showTooltip
								isPressed={ value === name }
								onClick={ () => onChange( name ) }
							>
								<AddaxIcon name={ name } size={ 24 } />
							</Button>
						) ) }
					</div>
				</div>
			) }
		/>
	);
}
