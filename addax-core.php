<?php
/**
 * Plugin Name:       Addax Core
 * Plugin URI:        https://github.com/jawadpro/addax-core
 * Description:       Companion plugin for the Addax theme: custom blocks (hero slider, counters, progress charts, info boxes, tabs, client logos, projects, team, testimonials), the Projects post type, Addax settings and per-page options.
 * Version:           2.0.0
 * Requires at least: 6.6
 * Requires PHP:      7.4
 * Author:            Jawad
 * Author URI:        https://github.com/jawadpro
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       addax-core
 *
 * @package AddaxCore
 */

defined( 'ABSPATH' ) || exit;

define( 'ADDAX_CORE_VERSION', '2.0.0' );
define( 'ADDAX_CORE_FILE', __FILE__ );
define( 'ADDAX_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'ADDAX_CORE_URL', plugin_dir_url( __FILE__ ) );

require_once ADDAX_CORE_DIR . 'includes/helpers.php';
require_once ADDAX_CORE_DIR . 'includes/post-types.php';
require_once ADDAX_CORE_DIR . 'includes/settings.php';
require_once ADDAX_CORE_DIR . 'includes/post-meta.php';
require_once ADDAX_CORE_DIR . 'includes/block-bindings.php';
require_once ADDAX_CORE_DIR . 'includes/blocks.php';
require_once ADDAX_CORE_DIR . 'includes/demo.php';
require_once ADDAX_CORE_DIR . 'includes/patterns.php';

/**
 * Load translations.
 */
function addax_core_load_textdomain() {
	load_plugin_textdomain( 'addax-core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'addax_core_load_textdomain', 0 );

/**
 * Flush rewrite rules so /projects/ works straight after activation.
 */
function addax_core_activate() {
	addax_core_register_post_types();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'addax_core_activate' );
register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
