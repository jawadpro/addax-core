import { initSlider } from '../../shared/slider';

document.querySelectorAll( '[data-addax-slider="hero"]' ).forEach( ( root ) => {
	let labels = {};
	try {
		labels = JSON.parse( root.dataset.labels || '{}' );
	} catch ( e ) {}
	initSlider( root, { labels } );

	// Scroll-down: if the target is our own anchor, land on whatever follows the hero.
	const scroll = root.querySelector( '[data-addax-scroll]' );
	scroll?.addEventListener( 'click', ( event ) => {
		const id = scroll.getAttribute( 'href' );
		let target = id && id.length > 1 ? document.querySelector( id ) : null;
		if ( ! target ) {
			return;
		}
		if ( id === '#addax-after-hero' && target.nextElementSibling ) {
			target = target.nextElementSibling;
		}
		event.preventDefault();
		const header = document.querySelector( '.addax-header' );
		const offset = header && window.getComputedStyle( header.closest( 'header' ) || header ).position !== 'static' ? header.offsetHeight : 0;
		const top = target.getBoundingClientRect().top + window.scrollY - offset;
		window.scrollTo( { top, behavior: window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ? 'auto' : 'smooth' } );
	} );
} );
