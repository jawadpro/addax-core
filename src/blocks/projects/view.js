document.querySelectorAll( '[data-addax-projects]' ).forEach( ( root ) => {
	const items = Array.from( root.querySelectorAll( '.addax-project' ) );
	const filters = Array.from( root.querySelectorAll( '.addax-projects__filter' ) );
	const empty = root.querySelector( '.addax-projects__empty' );

	filters.forEach( ( button ) => {
		button.addEventListener( 'click', () => {
			const filter = button.dataset.filter;
			filters.forEach( ( b ) => {
				const on = b === button;
				b.classList.toggle( 'is-active', on );
				b.setAttribute( 'aria-pressed', on ? 'true' : 'false' );
			} );
			let shown = 0;
			items.forEach( ( item ) => {
				const match = filter === '*' || item.dataset.terms.split( ' ' ).includes( filter );
				item.classList.toggle( 'is-hidden', ! match );
				item.hidden = ! match;
				if ( match ) {
					shown++;
					item.classList.remove( 'is-entering' );
					void item.offsetWidth; // eslint-disable-line no-void
					item.classList.add( 'is-entering' );
				}
			} );
			if ( empty ) {
				empty.hidden = shown > 0;
			}
		} );
	} );

	// Lightbox.
	const dialog = root.querySelector( '.addax-lightbox' );
	if ( ! dialog || typeof dialog.showModal !== 'function' ) {
		return;
	}
	const img = dialog.querySelector( 'img' );
	let opener = null;

	root.querySelectorAll( '[data-addax-lightbox]' ).forEach( ( link ) => {
		link.addEventListener( 'click', ( event ) => {
			event.preventDefault();
			opener = link;
			img.src = link.href;
			img.alt = link.getAttribute( 'aria-label' ) || '';
			dialog.showModal();
		} );
	} );

	const close = () => dialog.close();
	dialog.querySelector( '.addax-lightbox__close' ).addEventListener( 'click', close );
	dialog.addEventListener( 'click', ( event ) => {
		if ( event.target === dialog ) {
			close();
		}
	} );
	dialog.addEventListener( 'close', () => {
		img.removeAttribute( 'src' );
		opener?.focus();
	} );
} );
