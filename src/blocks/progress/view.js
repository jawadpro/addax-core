import { onVisible, prefersReducedMotion } from '../../shared/view-utils';

document.querySelectorAll( '[data-addax-progress]' ).forEach( ( el ) => {
	if ( prefersReducedMotion() ) {
		return;
	}
	el.classList.add( 'is-pending' );
	onVisible( el, () => {
		// Next frame, so the transition runs from 0.
		window.requestAnimationFrame( () => el.classList.remove( 'is-pending' ) );
	} );
} );
