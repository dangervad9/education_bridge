<?php

/**
 * BuddyPress - Users Notifications
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

?>
<div class="card-main">
	<div class="card-inner pt-0 pb-0">
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
				<div class="position-relative">
					<div id="members-order-select" class="last filter socialv-data-filter-by">
						<?php bp_notifications_sort_order_form(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="card-main card-space">
	<div class="card-inner">
		<?php
		switch (bp_current_action()):

			case 'unread':
				bp_get_template_part('members/single/notifications/unread');
				break;

			case 'read':
				bp_get_template_part('members/single/notifications/read');
				break;

				// Any other actions.
			default:
				bp_get_template_part('members/single/plugins');
				break;
		endswitch;
		?>
	</div>
</div>