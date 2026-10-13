import { registerBlockType } from '@wordpress/blocks';
import {
	useBlockProps,
	RichText,
	InspectorControls,
	__experimentalColorGradientSettingsDropdown as ColorGradientSettingsDropdown,
	__experimentalUseMultipleOriginColorsAndGradients as useMultipleOriginColorsAndGradients,
} from '@wordpress/block-editor';
import { PanelBody, RangeControl, ToggleControl, SelectControl, BaseControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { AddaxIcon, IconPicker } from '../../shared/icon';
import metadata from './block.json';
import './style.scss';
import '../../shared/editor.scss';

export function progressStyle( { value, barColor, trackColor } ) {
	const style = { '--addax-progress': Math.max( 0, Math.min( 100, value ) ) };
	if ( barColor ) {
		style[ '--addax-bar' ] = barColor;
	}
	if ( trackColor ) {
		style[ '--addax-track' ] = trackColor;
	}
	return style;
}

function Edit( { attributes, setAttributes, clientId } ) {
	const { label, value, variant, barColor, trackColor, showValue, icon } = attributes;
	const colorSettings = useMultipleOriginColorsAndGradients();
	const blockProps = useBlockProps( {
		className: `is-variant-${ variant }`,
		style: progressStyle( attributes ),
	} );

	const labelField = (
		<RichText
			tagName="span"
			className="addax-progress__label"
			value={ label }
			onChange={ ( next ) => setAttributes( { label: next } ) }
			placeholder={ __( 'Label', 'addax-core' ) }
			allowedFormats={ [] }
		/>
	);
	const valueText = showValue && <span className="addax-progress__value">{ value }%</span>;

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Progress', 'addax-core' ) }>
					<SelectControl
						label={ __( 'Style', 'addax-core' ) }
						value={ variant }
						options={ [
							{ label: __( 'Thin line', 'addax-core' ), value: 'line' },
							{ label: __( 'Rounded bar', 'addax-core' ), value: 'rounded' },
							{ label: __( 'Donut chart', 'addax-core' ), value: 'donut' },
						] }
						onChange={ ( next ) => setAttributes( { variant: next } ) }
						__nextHasNoMarginBottom
						__next40pxDefaultSize
					/>
					<RangeControl label={ __( 'Percentage', 'addax-core' ) } min={ 0 } max={ 100 } value={ value } onChange={ ( next ) => setAttributes( { value: next } ) } __nextHasNoMarginBottom __next40pxDefaultSize />
					<ToggleControl label={ __( 'Show percentage', 'addax-core' ) } checked={ showValue } onChange={ ( next ) => setAttributes( { showValue: next } ) } __nextHasNoMarginBottom />
					{ variant === 'donut' && (
						<BaseControl label={ __( 'Centre icon (optional)', 'addax-core' ) } __nextHasNoMarginBottom>
							<div style={ { display: 'flex', gap: 8 } }>
								<IconPicker value={ icon } onChange={ ( next ) => setAttributes( { icon: next } ) } />
								{ icon && <button type="button" className="components-button is-link is-destructive" onClick={ () => setAttributes( { icon: '' } ) }>{ __( 'Remove', 'addax-core' ) }</button> }
							</div>
						</BaseControl>
					) }
				</PanelBody>
			</InspectorControls>
			<InspectorControls group="color">
				<ColorGradientSettingsDropdown
					__experimentalIsRenderedInSidebar
					settings={ [
						{ label: __( 'Bar', 'addax-core' ), colorValue: barColor, onColorChange: ( next ) => setAttributes( { barColor: next || '' } ) },
						{ label: __( 'Track', 'addax-core' ), colorValue: trackColor, onColorChange: ( next ) => setAttributes( { trackColor: next || '' } ) },
					] }
					panelId={ clientId }
					{ ...colorSettings }
				/>
			</InspectorControls>
			<div { ...blockProps }>
				{ variant === 'donut' ? (
					<>
						<div className="addax-progress__donut">
							<span className="addax-progress__center">
								{ icon && <AddaxIcon name={ icon } size={ 32 } /> }
								{ valueText }
							</span>
						</div>
						<div className="addax-progress__caption">{ labelField }</div>
					</>
				) : (
					<>
						<div className="addax-progress__head">
							{ labelField }
							{ valueText }
						</div>
						<div className="addax-progress__track">
							<div className="addax-progress__bar" />
						</div>
					</>
				) }
			</div>
		</>
	);
}

registerBlockType( metadata.name, { edit: Edit } );
