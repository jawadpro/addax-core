<?php
/**
 * Title: Projects (filterable)
 * Slug: addax-core/projects
 * Categories: addax-core, portfolio
 * Keywords: portfolio, projects, work, filter
 * Description: Heading and a filterable grid of your Projects.
 *
 * @package AddaxCore
 */
?>
<!-- wp:group {"tagName":"section","align":"full","metadata":{"name":"Projects"},"anchor":"work","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"},"margin":{"top":"0"},"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
<section id="work" class="wp-block-group alignfull" style="margin-top:0;padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:paragraph {"align":"center","className":"is-style-addax-badge"} -->
<p class="has-text-align-center is-style-addax-badge"><?php esc_html_e( 'Portfolio', 'addax-core' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center"><?php esc_html_e( 'Work that makes us proud', 'addax-core' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:addax/projects {"count":8,"columns":4,"gap":16,"aspectRatio":"4/3","align":"wide"} /--></section>
<!-- /wp:group -->
