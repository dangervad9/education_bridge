<?php

/**
 * BuddyPress - Members Profile Loop
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

do_action('bp_before_profile_loop_content'); ?>

<?php if (bp_has_profile()) : ?>

	<?php while (bp_profile_groups()) : bp_the_profile_group(); ?>

		<?php if (bp_profile_group_has_fields()) : ?>

			<?php
			do_action('bp_before_profile_field_content');
			?>

			<div class="card-main card-space card-view-profile-list">
				<div class="card-head card-header-border d-flex align-items-center justify-content-between">
					<div class="head-title">
						<h5 class="card-title"><?php bp_the_profile_group_name(); ?></h5>
					</div>
					<?php if (bp_core_can_edit_settings()) : ?>
						<div class="title-btn">
							<a class="cart-edit" href="<?php echo esc_url(bp_the_profile_group_edit_form_action()); ?>"><i class="iconly-Edit-Square icli"></i></a>
						</div>
					<?php endif; ?>
				</div>
				<div class="card-inner">
					<ul class="socialv-about-info list-inline">

						<?php while (bp_profile_fields()) : bp_the_profile_field(); ?>

							<?php if (bp_field_has_data()) : ?>
								<li>
									<label><?php bp_the_profile_field_name(); ?></label>
									<div class="h6"><?php bp_the_profile_field_value(); ?></div>
								</li>

							<?php endif; ?>

							<?php

							/**
							 * Fires after the display of a field table row for profile data.
							 *
							 * @since 1.1.0
							 */
							do_action('bp_profile_field_item'); ?>

						<?php endwhile; ?>

					</ul>
				</div>
			</div>

			<?php

			do_action('bp_after_profile_field_content'); ?>

		<?php endif; ?>

	<?php endwhile; ?>

	<?php

	do_action('bp_profile_field_buttons'); ?>

<?php endif; ?>

<?php

do_action('bp_after_profile_loop_content');
