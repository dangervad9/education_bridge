<?php
/**
 * BuddyPress - Members Unread Notifications
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

?>

<?php if ( bp_has_notifications() ) : ?>

	<h2 class="bp-screen-reader-text"><?php
		/* translators: accessibility text */
		esc_html_e( 'Unread notifications', 'socialv' );
	?></h2>

	<?php bp_get_template_part( 'members/single/notifications/notifications-loop' ); ?>

	<div class="socialv-bp-pagination no-ajax" id="pag-bottom">
		<div class="pagination-links" id="notifications-pag-bottom">
			<?php bp_notifications_pagination_links(); ?>
		</div>
	</div>

<?php else : ?>

	<?php bp_get_template_part( 'members/single/notifications/feedback-no-notifications' ); ?>

<?php endif;
