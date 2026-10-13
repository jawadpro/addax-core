<?php
/**
 * Addax Projects.
 *
 * @package AddaxCore
 * @var array $attributes
 */

$addax_args = array(
	'post_type'           => 'addax-project',
	'post_status'         => 'publish',
	'posts_per_page'      => max( 1, min( 48, (int) $attributes['count'] ) ),
	'orderby'             => $attributes['orderBy'],
	'order'               => 'asc' === $attributes['order'] ? 'ASC' : 'DESC',
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
);
if ( ! empty( $attributes['categories'] ) ) {
	$addax_args['tax_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
		array(
			'taxonomy' => 'adx-project-category',
			'terms'    => array_map( 'intval', $attributes['categories'] ),
		),
	);
}

$addax_query = new WP_Query( $addax_args );

if ( ! $addax_query->have_posts() ) {
	if ( current_user_can( 'edit_posts' ) ) {
		printf(
			'<div %1$s><p class="addax-projects__empty-admin">%2$s <a href="%3$s">%4$s</a></p></div>',
			get_block_wrapper_attributes(), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			esc_html__( 'No projects found.', 'addax-core' ),
			esc_url( admin_url( 'post-new.php?post_type=addax-project' ) ),
			esc_html__( 'Add a project', 'addax-core' )
		);
	}
	return;
}

// Collect the categories actually used by these projects, for the filter bar.
$addax_terms = array();
$addax_items = array();
while ( $addax_query->have_posts() ) {
	$addax_query->the_post();
	$addax_post_terms = get_the_terms( get_the_ID(), 'adx-project-category' );
	$addax_post_terms = is_array( $addax_post_terms ) ? $addax_post_terms : array();
	foreach ( $addax_post_terms as $addax_term ) {
		$addax_terms[ $addax_term->slug ] = $addax_term->name;
	}
	$addax_items[] = array(
		'id'    => get_the_ID(),
		'terms' => $addax_post_terms,
	);
}
wp_reset_postdata();
asort( $addax_terms );

$addax_cols    = max( 1, min( 6, (int) $attributes['columns'] ) );
$addax_ratio   = preg_match( '#^\d+/\d+$#', (string) $attributes['aspectRatio'] ) ? $attributes['aspectRatio'] : '1/1';
$addax_wrapper = get_block_wrapper_attributes(
	array(
		'style'               => sprintf( '--addax-projects-cols:%1$d;--addax-projects-gap:%2$dpx;--addax-projects-ratio:%3$s;', $addax_cols, (int) $attributes['gap'], esc_attr( $addax_ratio ) ),
		'data-addax-projects' => '',
	)
);
$addax_all = $attributes['allLabel'] ? $attributes['allLabel'] : __( 'All', 'addax-core' );
?>
<div <?php echo $addax_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php if ( ! empty( $attributes['showFilters'] ) && count( $addax_terms ) > 1 ) : ?>
		<div class="addax-projects__filters" role="group" aria-label="<?php esc_attr_e( 'Filter projects', 'addax-core' ); ?>">
			<button type="button" class="addax-projects__filter is-active" data-filter="*" aria-pressed="true"><?php echo esc_html( $addax_all ); ?></button>
			<?php foreach ( $addax_terms as $addax_slug => $addax_name ) : ?>
				<button type="button" class="addax-projects__filter" data-filter="<?php echo esc_attr( $addax_slug ); ?>" aria-pressed="false"><?php echo esc_html( $addax_name ); ?></button>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<ul class="addax-projects__grid">
		<?php foreach ( $addax_items as $addax_item ) : ?>
			<?php
			$addax_id    = $addax_item['id'];
			$addax_slugs = wp_list_pluck( $addax_item['terms'], 'slug' );
			$addax_names = wp_list_pluck( $addax_item['terms'], 'name' );
			$addax_thumb = get_post_thumbnail_id( $addax_id );
			$addax_full  = $addax_thumb ? wp_get_attachment_image_url( $addax_thumb, 'full' ) : '';
			$addax_title = get_the_title( $addax_id );
			?>
			<li class="addax-project" data-terms="<?php echo esc_attr( implode( ' ', $addax_slugs ) ); ?>">
				<div class="addax-project__media">
					<?php
					echo $addax_thumb
						? wp_get_attachment_image( $addax_thumb, 'large', false, array( 'class' => 'addax-project__img', 'alt' => '' ) )
						: '<span class="addax-project__img is-placeholder"></span>';
					?>
				</div>
				<div class="addax-project__content">
					<?php if ( $addax_names ) : ?>
						<span class="addax-project__cats"><?php echo esc_html( implode( ' / ', $addax_names ) ); ?></span>
					<?php endif; ?>
					<h3 class="addax-project__title"><a href="<?php echo esc_url( get_permalink( $addax_id ) ); ?>"><?php echo esc_html( $addax_title ); ?></a></h3>
					<?php if ( ! empty( $attributes['showExcerpt'] ) && has_excerpt( $addax_id ) ) : ?>
						<p class="addax-project__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt( $addax_id ), 18 ) ); ?></p>
					<?php endif; ?>
					<div class="addax-project__links">
						<?php if ( $addax_full ) : ?>
							<a href="<?php echo esc_url( $addax_full ); ?>" class="addax-project__zoom" data-addax-lightbox aria-label="<?php echo esc_attr( sprintf( /* translators: %s: project title */ __( 'View image: %s', 'addax-core' ), $addax_title ) ); ?>"><?php echo addax_core_icon( 'search', 20 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
						<?php endif; ?>
						<a href="<?php echo esc_url( get_permalink( $addax_id ) ); ?>" class="addax-project__open" tabindex="-1" aria-hidden="true"><?php echo addax_core_icon( 'arrow-right', 20 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					</div>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
	<p class="addax-projects__empty" hidden><?php esc_html_e( 'Sorry, no matching projects found.', 'addax-core' ); ?></p>

	<dialog class="addax-lightbox" aria-label="<?php esc_attr_e( 'Image viewer', 'addax-core' ); ?>">
		<button type="button" class="addax-lightbox__close" aria-label="<?php esc_attr_e( 'Close', 'addax-core' ); ?>"><?php echo addax_core_icon( 'close', 24 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button>
		<img alt="" />
	</dialog>
</div>
