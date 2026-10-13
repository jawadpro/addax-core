/**
 * Default @wordpress/scripts config (auto-detects every block.json in src/blocks),
 * plus the two admin apps.
 */
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const path = require( 'path' );

const config = Array.isArray( defaultConfig ) ? defaultConfig[ 0 ] : defaultConfig;

module.exports = {
	...config,
	entry: {
		...( typeof config.entry === 'function' ? config.entry() : config.entry ),
		'admin/settings': path.resolve( __dirname, 'src/admin/settings.js' ),
		'admin/editor': path.resolve( __dirname, 'src/admin/editor.js' ),
	},
};
