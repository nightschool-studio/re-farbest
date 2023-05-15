<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package storefront
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>
<button id="btnsec">SHOW FILTER</button>
<div id="secondary" class="widget-area" role="complementary" style="display:none;">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div><!-- #secondary -->
