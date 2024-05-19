<?php

/**
 * BuddyPress - Users Messages
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

?>
<div class="card-main">
	<div class="card-inner pt-0">
		<div class="row align-items-center socialv-sub-tab-lists" id="subnav" >
			<div class="col-md-7 col-xl-7 item-list-tabs no-ajax ">
				<div class="socialv-subtab-lists">
					<div class="left" onclick="slide('left',event)">
						<i class="iconly-Arrow-Left-2 icli"></i>
					</div>
					<div class="right" onclick="slide('right',event)">
						<i class="iconly-Arrow-Right-2 icli"></i>
					</div>
					<div class="socialv-subtab-container custom-nav-slider">
						<ul class="list-inline m-0">
							<?php bp_get_options_nav(); ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-5 col-xl-5">
				<?php if (bp_is_messages_inbox() || bp_is_messages_sentbox()) : ?>
					<div class="dir-search"><?php bp_message_search_form(); ?></div>
				<?php endif; ?>
			</div>
		</div>
		<div class="socialv-message-data">
			<?php
			switch (bp_current_action()):

					// Inbox/Sentbox
				case 'inbox':
				case 'sentbox':

					/**
					 * Fires before the member messages content for inbox and sentbox.
					 *
					 * @since 1.2.0
					 */
					do_action('bp_before_member_messages_content'); ?>

					<div class="messages">
						<?php bp_get_template_part('members/single/messages/messages-loop'); ?>
					</div><!-- .messages -->

				<?php

					/**
					 * Fires after the member messages content for inbox and sentbox.
					 *
					 * @since 1.2.0
					 */
					do_action('bp_after_member_messages_content');
					break;

					// Single Message View
				case 'view':
					bp_get_template_part('members/single/messages/single');
					break;

					// Compose
				case 'compose':
					bp_get_template_part('members/single/messages/compose');
					break;

					// Sitewide Notices
				case 'notices':

					/**
					 * Fires before the member messages content for notices.
					 *
					 * @since 1.2.0
					 */
					do_action('bp_before_member_messages_content'); ?>

					<div class="messages">
						<?php bp_get_template_part('members/single/messages/notices-loop'); ?>
					</div><!-- .messages -->

			<?php

					/**
					 * Fires after the member messages content for inbox and sentbox.
					 *
					 * @since 1.2.0
					 */
					do_action('bp_after_member_messages_content');
					break;

					// Any other
				default:
					bp_get_template_part('members/single/plugins');
					break;
			endswitch;
			?>
		</div>
	</div>
</div>