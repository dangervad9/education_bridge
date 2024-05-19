<?php

/**
 * BuddyPress - Sent Membership Invitations
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 8.0.0
 */
?>

<div class="card-main card-space">
	<div class="card-inner">
		<?php if (bp_has_members_invitations()) : ?>

			<h2 class="bp-screen-reader-text">
				<?php
				/* translators: accessibility text */
				esc_html_e('Invitations', 'socialv');
				?>
			</h2>

			<?php bp_get_template_part('members/single/invitations/invitations-loop'); ?>

			<div class="socialv-bp-pagination no-ajax" id="pag-bottom">
				<div class="pagination-links" id="invitations-pag-bottom">
					<?php bp_members_invitations_pagination_links(); ?>
				</div>
			</div>
		<?php else : ?>

			<p class="m-0"><?php esc_html_e('There are no invitations to display.', 'socialv'); ?></p>

		<?php endif; ?>

	</div>
</div>