<?php
/**
 * Addax Tabs. Builds the tab list from the child blocks and wraps each in a tab panel.
 *
 * @package AddaxCore
 * @var array    $attributes
 * @var WP_Block $block
 */

$addax_tabs = array();
foreach ( $block->inner_blocks as $addax_inner ) {
	if ( 'addax/tab' === $addax_inner->name ) {
		$addax_tabs[] = $addax_inner;
	}
}
if ( ! $addax_tabs ) {
	return;
}

$addax_uid    = wp_unique_id( 'addax-tabs-' );
$addax_active = min( max( 0, (int) $attributes['activeTab'] ), count( $addax_tabs ) - 1 );
$addax_wrap   = get_block_wrapper_attributes(
	array(
		'class'           => sprintf( 'is-variant-%1$s is-nav-%2$s', sanitize_html_class( $attributes['variant'] ), sanitize_html_class( $attributes['navAlign'] ) ),
		'data-addax-tabs' => '',
		'data-active'     => $addax_active,
	)
);
?>
<div <?php echo $addax_wrap; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="addax-tabs__nav" role="tablist" hidden>
		<?php foreach ( $addax_tabs as $addax_i => $addax_tab ) : ?>
			<button type="button" role="tab" class="addax-tabs__tab<?php echo $addax_i === $addax_active ? ' is-active' : ''; ?>" id="<?php echo esc_attr( "{$addax_uid}-tab-{$addax_i}" ); ?>" aria-controls="<?php echo esc_attr( "{$addax_uid}-panel-{$addax_i}" ); ?>" aria-selected="<?php echo $addax_i === $addax_active ? 'true' : 'false'; ?>" tabindex="<?php echo $addax_i === $addax_active ? '0' : '-1'; ?>">
				<span><?php echo esc_html( isset( $addax_tab->attributes['title'] ) ? $addax_tab->attributes['title'] : '' ); ?></span>
			</button>
		<?php endforeach; ?>
	</div>
	<div class="addax-tabs__panels">
		<?php foreach ( $addax_tabs as $addax_i => $addax_tab ) : ?>
			<div class="addax-tabs__panel<?php echo $addax_i === $addax_active ? ' is-active' : ''; ?>" role="tabpanel" id="<?php echo esc_attr( "{$addax_uid}-panel-{$addax_i}" ); ?>" aria-labelledby="<?php echo esc_attr( "{$addax_uid}-tab-{$addax_i}" ); ?>" tabindex="0">
				<h3 class="addax-tabs__panel-title"><?php echo esc_html( isset( $addax_tab->attributes['title'] ) ? $addax_tab->attributes['title'] : '' ); ?></h3>
				<?php echo $addax_tab->render(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>
