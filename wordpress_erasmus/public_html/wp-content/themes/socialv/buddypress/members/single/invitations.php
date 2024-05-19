<?php

/**
 * BuddyPress - membership invitations
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 8.0.0
 */

?>
<div class="card-main card-space socialv-search-main">
	<div class="card-inner pt-0 pb-0">
		<div class="item-list-tabs no-ajax" id="subnav" >
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
	</div>
</div>

<?php
switch (bp_current_action()):

	case 'send-invites':
		bp_get_template_part('members/single/invitations/send-invites');
		break;

	case 'list-invites':
	default:
		bp_get_template_part('members/single/invitations/list-invites');
		break;

endswitch;
