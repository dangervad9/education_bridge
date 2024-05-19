<?php

/**
 * BuddyPress - Users Settings
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

?>
<div class="container">
	<div id="item-body">
		<div class="row card-space">
			<div class="col-md-4">
				<div class="accordion">
					<div class="socialv-profile-edit-dropdown" id="accordionProfile">
						<div class="accordion-item">
							<h6 class="accordion-header" id="headingOne">
								<div class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
									<i class="iconly-Profile icli"></i> <?php esc_html_e('Profile Setting', 'socialv'); ?>
								</div>
							</h6>
							<div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionProfile">

								<?php if (bp_profile_has_multiple_groups()) : ?>
									<div class="accordion-body">
										<ul class="list-inline m-0">
											<?php bp_profile_group_tabs(); ?>
										</ul>
									</div>
								<?php endif; ?>
							</div>
						</div>
						<div class="accordion-item">
							<h6 class="accordion-header" id="headingTwo">
								<div class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
									<i class="iconly-Setting icli"></i> <?php esc_html_e('Account Settings', 'socialv'); ?>
								</div>
							</h6>
							<div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionProfile">
								<div class="accordion-body">
									<?php do_action('socialv_settings_menus'); ?>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-8">

				<?php do_action('socialv_account_menu_header_buttons'); ?>
				<div class="card-main card-space">
					<?php
					switch (bp_current_action()):
						case 'notifications':
							bp_get_template_part('members/single/settings/notifications');
							break;
						case 'capabilities':
							bp_get_template_part('members/single/settings/capabilities');
							break;
						case 'delete-account':
							bp_get_template_part('members/single/settings/delete-account');
							break;
						case 'general':
							bp_get_template_part('members/single/settings/general');
							break;
						case 'profile':
							bp_get_template_part('members/single/settings/profile');
							break;
						case 'data':
							bp_get_template_part('members/single/settings/data');
							break;
						default:
							bp_get_template_part('members/single/plugins');
							break;
					endswitch;
					?>
				</div>
			</div>
		</div>
	</div>
</div>