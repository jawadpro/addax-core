import { initSlider } from '../../shared/slider';

document.querySelectorAll( '[data-addax-slider="testimonials"]' ).forEach( ( root ) => {
	let labels = {};
	try {
		labels = JSON.parse( root.dataset.labels || '{}' );
	} catch ( e ) {}
	initSlider( root, { labels } );
} );
