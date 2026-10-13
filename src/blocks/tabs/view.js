document.querySelectorAll( '[data-addax-tabs]' ).forEach( ( root ) => {
	const nav = root.querySelector( '.addax-tabs__nav' );
	const tabs = Array.from( nav.querySelectorAll( '[role="tab"]' ) );
	const panels = Array.from( root.querySelectorAll( ':scope > .addax-tabs__panels > .addax-tabs__panel' ) );

	root.classList.add( 'is-ready' );
	nav.hidden = false;

	const select = ( index, focus = false ) => {
		tabs.forEach( ( tab, i ) => {
			const on = i === index;
			tab.classList.toggle( 'is-active', on );
			tab.setAttribute( 'aria-selected', on ? 'true' : 'false' );
			tab.tabIndex = on ? 0 : -1;
			panels[ i ].hidden = ! on;
			panels[ i ].classList.toggle( 'is-active', on );
		} );
		if ( focus ) {
			tabs[ index ].focus();
		}
	};

	tabs.forEach( ( tab, i ) => {
		tab.addEventListener( 'click', () => select( i ) );
		tab.addEventListener( 'keydown', ( event ) => {
			const last = tabs.length - 1;
			const map = { ArrowRight: i === last ? 0 : i + 1, ArrowLeft: i === 0 ? last : i - 1, Home: 0, End: last };
			if ( event.key in map ) {
				event.preventDefault();
				select( map[ event.key ], true );
			}
		} );
	} );

	select( parseInt( root.dataset.active, 10 ) || 0 );
} );
