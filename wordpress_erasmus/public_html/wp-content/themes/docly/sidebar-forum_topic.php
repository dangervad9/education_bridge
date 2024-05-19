<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package docly
 */

if ( ! is_active_sidebar( 'sidebar_widgets' ) ) {
	return;
}
?>

<div class="col-lg-4">
    <div class="forum_sidebar">
	    <?php dynamic_sidebar( 'forum_topic_sidebar' ); ?>
	</div>
</div>