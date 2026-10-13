import { onVisible, prefersReducedMotion } from '../../shared/view-utils';

const format = ( value, separator ) =>
	separator ? Math.round( value ).toLocaleString( 'en-US' ) : String( Math.round( value ) );

document.querySelectorAll( '[data-addax-counter]' ).forEach( ( el ) => {
	const target = parseFloat( el.dataset.target ) || 0;
	const duration = parseInt( el.dataset.duration, 10 ) || 0;
	const separator = el.dataset.separator === '1';
	const out = el.querySelector( '.addax-counter__number' );

	if ( ! out || ! duration || prefersReducedMotion() ) {
		return;
	}

	// Reserve the final width so the layout doesn't jump while counting.
	out.style.minWidth = `${ out.offsetWidth }px`;
	out.textContent = format( 0, separator );

	onVisible( el, () => {
		const start = performance.now();
		const tick = ( now ) => {
			const progress = Math.min( ( now - start ) / duration, 1 );
			const eased = 1 - Math.pow( 1 - progress, 3 );
			out.textContent = format( target * eased, separator );
			if ( progress < 1 ) {
				window.requestAnimationFrame( tick );
			}
		};
		window.requestAnimationFrame( tick );
	} );
} );
