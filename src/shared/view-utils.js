/**
 * Tiny helpers shared by the front-end view scripts (no editor dependencies).
 */

/**
 * Run a callback once an element scrolls into view (or straight away without IntersectionObserver).
 *
 * @param {Element}  el       Element.
 * @param {Function} callback Callback.
 */
export function onVisible( el, callback ) {
	if ( ! ( 'IntersectionObserver' in window ) ) {
		callback();
		return;
	}
	const observer = new window.IntersectionObserver(
		( entries ) => {
			entries.forEach( ( entry ) => {
				if ( entry.isIntersecting ) {
					observer.disconnect();
					callback();
				}
			} );
		},
		{ threshold: 0.25 }
	);
	observer.observe( el );
}

export const prefersReducedMotion = () =>
	window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
