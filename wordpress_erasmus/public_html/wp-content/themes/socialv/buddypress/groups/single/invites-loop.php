<?php

/**
 * BuddyPress - Group Invites Loop
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

?>
<div class="row">
	<div class="left-menu col-md-4">

		<div id="invite-list">

			<ul class="list-inline m-0">
				<?php bp_new_group_invite_friend_list(); ?>
			</ul>

			<?php wp_nonce_field('groups_invite_uninvite_user', '_wpnonce_invite_uninvite_user'); ?>

		</div>

	</div><!-- .left-menu -->

	<div class="main-column col-md-8">

		<?php

		/**
		 * Fires before the display of the group send invites list.
		 *
		 * @since 1.1.0
		 */
		do_action('bp_before_group_send_invites_list'); ?>

		<?php if (bp_group_has_invites(bp_ajax_querystring('invite') . '&per_page=10')) : ?>
			<div id="friend-list" class="socialv-members-lists socialv-bp-main-box">

				<?php while (bp_group_invites()) : bp_group_the_invite(); ?>
					
					<div <?php bp_member_class(['item-entry col-12']); ?> id="<?php bp_group_invite_item_id(); ?>">
						<div class="socialv-member-info">
							<div class="socialv-member-main">
								<div class="socialv-member-left  item-avatar">
									<a href="<?php bp_member_link(); ?>"><?php bp_group_invite_user_avatar(); ?></a>
								</div>
								<div class="socialv-member-center item-block">
									<div class="member-name">
										<h5 class="title">
											<?php bp_group_invite_user_link(); ?>
										</h5>
									</div>
									<div class="socialv-member-info-top">
										<span class="socialv-e-last-activity"><?php bp_group_invite_user_last_active(); ?></span>
									</div>
									<?php do_action('bp_group_send_invites_item'); ?>
								</div>
							</div>
							<div class="socialv-member-right">
								<a class="remove btn socialv-btn-danger text-capitalize" href="<?php bp_group_invite_user_remove_invite_url(); ?>" id="<?php bp_group_invite_item_id(); ?>"><?php esc_html_e('Remove', 'socialv'); ?></a>

								<?php

								/**
								 * Fires inside the action area for a send invites item.
								 *
								 * @since 1.1.0
								 */
								do_action('bp_group_send_invites_item_action'); ?>
							</div>
						</div>
					</div>

				<?php endwhile; ?>

			</div><!-- #friend-list -->
			
			
			<div id="pag-bottom" class="socialv-bp-pagination">
				<div class="pagination-links" id="group-invite-pag-bottom">
					<?php 
					bp_group_invite_pagination_links(); ?>
				</div>
			</div>

		<?php else : ?>

			<div id="message" class="info">
				<p><?php esc_html_e('Select friends to invite.', 'socialv'); ?></p>
			</div>

		<?php endif; ?>

		<?php

		/**
		 * Fires after the display of the group send invites list.
		 *
		 * @since 1.1.0
		 */
		do_action('bp_after_group_send_invites_list'); ?>

	</div><!-- .main-column -->
</div>