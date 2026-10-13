import { prefersReducedMotion } from '../../shared/view-utils';

document.querySelectorAll( '[data-addax-clients].is-marquee' ).forEach( ( el ) => {
	const track = el.querySelector( '.addax-clients__track' );
	if ( ! track || prefersReducedMotion() ) {
		el.classList.remove( 'is-marquee' );
		return;
	}

	// Duplicate the logos until the strip is at least twice the container width,
	// so the -50% loop is seamless. Clones are hidden from assistive tech.
	const originals = Array.from( track.children );
	const fill = () => {
		el.classList.add( 'is-running' );
		let guard = 0;
		while ( track.scrollWidth < el.clientWidth * 2 && guard < 20 ) {
			originals.forEach( ( item ) => {
				const clone = item.cloneNode( true );
				clone.setAttribute( 'aria-hidden', 'true' );
				clone.querySelectorAll( 'a' ).forEach( ( a ) => a.setAttribute( 'tabindex', '-1' ) );
				track.appendChild( clone );
			} );
			guard++;
		}
		// Make the item count even so translateX(-50%) lands on a repeat.
		if ( track.children.length % ( originals.length * 2 ) !== 0 ) {
			originals.forEach( ( item ) => {
				const clone = item.cloneNode( true );
				clone.setAttribute( 'aria-hidden', 'true' );
				track.appendChild( clone );
			} );
		}
	};

	if ( document.readyState === 'complete' ) {
		fill();
	} else {
		window.addEventListener( 'load', fill, { once: true } );
	}
} );
