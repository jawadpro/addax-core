/**
 * Extracts a curated set of @wordpress/icons into src/icons.json,
 * so the same SVGs render in the editor (React) and on the front end (PHP).
 * Run: node tools/build-icons.js
 */
const fs = require( 'fs' );
const path = require( 'path' );

const names = [
	'desktop', 'mobile', 'tablet', 'code', 'brush', 'color', 'layout', 'chart-bar',
	'trending-up', 'globe', 'shield', 'lock', 'key', 'people', 'cog', 'tool',
	'cloud', 'connection', 'megaphone', 'send', 'envelope', 'comment', 'payment',
	'store', 'shipping', 'home', 'institution', 'map-marker', 'calendar', 'gift',
	'star-filled', 'thumbs-up', 'lifesaver', 'check', 'seen', 'search',
	// Interface icons used by the blocks themselves.
	'arrow-up', 'arrow-left', 'arrow-right', 'chevron-left', 'chevron-right', 'chevron-down', 'close', 'plus', 'external',
];

const dir = path.join( __dirname, '../node_modules/@wordpress/icons/src/library' );
const out = {};

for ( const name of names ) {
	const src = fs.readFileSync( path.join( dir, name + '.tsx' ), 'utf8' );
	const body = src.match( /<SVG[^>]*>([\s\S]*?)<\/SVG>/ )[ 1 ];
	const svg = body
		.replace( /<Path/g, '<path' )
		.replace( /<Circle/g, '<circle' )
		.replace( /<Rect/g, '<rect' )
		.replace( /fillRule=/g, 'fill-rule=' )
		.replace( /clipRule=/g, 'clip-rule=' )
		.replace( /\s+/g, ' ' )
		.replace( /\s*\/>/g, '/>' )
		.trim();
	out[ name ] = svg;
}

fs.writeFileSync(
	path.join( __dirname, '../src/icons.json' ),
	JSON.stringify( out, null, '\t' ) + '\n'
);
console.log( 'Wrote', Object.keys( out ).length, 'icons' );
