/**
 * Small accessible fade slider shared by the Hero Slider and Testimonials blocks.
 *
 * Markup contract (rendered by PHP):
 *   [data-addax-slider][data-autoplay][data-interval][data-pause-hover]
 *     .addax-slider__slides > [data-addax-slide] ...
 *     [data-addax-prev] [data-addax-next] [data-addax-toggle]
 *     .addax-slider__dots
 *     .addax-slider__progress > span   (optional)
 */
import { prefersReducedMotion } from './view-utils';

export function initSlider( root, { labels = {} } = {} ) {
	const slides = Array.from( root.querySelectorAll( ':scope .addax-slider__slides > [data-addax-slide]' ) );
	if ( slides.length === 0 ) {
		return;
	}

	const prev = root.querySelector( '[data-addax-prev]' );
	const next = root.querySelector( '[data-addax-next]' );
	const toggle = root.querySelector( '[data-addax-toggle]' );
	const dotsWrap = root.querySelector( '.addax-slider__dots' );
	const progress = root.querySelector( '.addax-slider__progress > span' );
	const interval = Math.max( 2000, parseInt( root.dataset.interval, 10 ) || 6000 );
	let autoplay = root.dataset.autoplay === '1' && slides.length > 1 && ! prefersReducedMotion();
	let index = 0;
	let timer = null;
	let hoverPaused = false;

	root.classList.add( 'is-ready' );
	root.setAttribute( 'aria-roledescription', 'carousel' );

	if ( slides.length < 2 ) {
		root.classList.add( 'is-single' );
	}

	const dots = slides.map( ( slide, i ) => {
		slide.setAttribute( 'role', 'group' );
		slide.setAttribute( 'aria-roledescription', 'slide' );
		slide.setAttribute( 'aria-label', `${ i + 1 } / ${ slides.length }` );
		if ( ! dotsWrap ) {
			return null;
		}
		const dot = document.createElement( 'button' );
		dot.type = 'button';
		dot.className = 'addax-slider__dot';
		dot.setAttribute( 'aria-label', `${ labels.goTo || 'Go to slide' } ${ i + 1 }` );
		dot.addEventListener( 'click', () => go( i, true ) );
		dotsWrap.appendChild( dot );
		return dot;
	} );

	function restartProgress() {
		if ( ! progress ) {
			return;
		}
		progress.style.transition = 'none';
		progress.style.width = '0%';
		if ( autoplay && ! hoverPaused ) {
			// Force reflow, then animate to full over one interval.
			void progress.offsetWidth; // eslint-disable-line no-void
			progress.style.transition = `width ${ interval }ms linear`;
			progress.style.width = '100%';
		}
	}

	function schedule() {
		window.clearTimeout( timer );
		if ( autoplay && ! hoverPaused ) {
			timer = window.setTimeout( () => go( index + 1 ), interval );
		}
		restartProgress();
	}

	function go( to, fromUser = false ) {
		index = ( to + slides.length ) % slides.length;
		slides.forEach( ( slide, i ) => {
			const active = i === index;
			slide.classList.toggle( 'is-active', active );
			slide.toggleAttribute( 'inert', ! active );
			slide.setAttribute( 'aria-hidden', active ? 'false' : 'true' );
		} );
		dots.forEach( ( dot, i ) => dot && dot.setAttribute( 'aria-current', i === index ? 'true' : 'false' ) );
		if ( fromUser ) {
			root.dispatchEvent( new window.CustomEvent( 'addax:slide', { detail: { index } } ) );
		}
		schedule();
	}

	function setAutoplay( on ) {
		autoplay = on;
		if ( toggle ) {
			toggle.setAttribute( 'aria-pressed', on ? 'false' : 'true' );
			toggle.setAttribute( 'aria-label', on ? labels.pause || 'Pause' : labels.play || 'Play' );
			toggle.classList.toggle( 'is-paused', ! on );
		}
		schedule();
	}

	prev?.addEventListener( 'click', () => go( index - 1, true ) );
	next?.addEventListener( 'click', () => go( index + 1, true ) );
	toggle?.addEventListener( 'click', () => setAutoplay( ! autoplay ) );

	if ( toggle && ( root.dataset.autoplay !== '1' || slides.length < 2 ) ) {
		toggle.hidden = true;
	}

	root.addEventListener( 'keydown', ( event ) => {
		if ( event.target.closest( 'input, textarea, select, [contenteditable]' ) ) {
			return;
		}
		if ( event.key === 'ArrowLeft' ) {
			go( index - 1, true );
		} else if ( event.key === 'ArrowRight' ) {
			go( index + 1, true );
		}
	} );

	const pause = () => {
		hoverPaused = true;
		schedule();
	};
	const resume = () => {
		hoverPaused = false;
		schedule();
	};
	if ( root.dataset.pauseHover === '1' ) {
		root.addEventListener( 'mouseenter', pause );
		root.addEventListener( 'mouseleave', resume );
	}
	root.addEventListener( 'focusin', pause );
	root.addEventListener( 'focusout', ( event ) => {
		if ( ! root.contains( event.relatedTarget ) ) {
			resume();
		}
	} );

	// Swipe.
	let startX = null;
	root.addEventListener( 'touchstart', ( event ) => {
		startX = event.touches[ 0 ].clientX;
	}, { passive: true } );
	root.addEventListener( 'touchend', ( event ) => {
		if ( startX === null ) {
			return;
		}
		const delta = event.changedTouches[ 0 ].clientX - startX;
		if ( Math.abs( delta ) > 40 ) {
			go( index + ( delta < 0 ? 1 : -1 ), true );
		}
		startX = null;
	} );

	// Stop when the tab is hidden.
	document.addEventListener( 'visibilitychange', () => ( document.hidden ? pause() : resume() ) );

	setAutoplay( autoplay );
	go( 0 );
}
