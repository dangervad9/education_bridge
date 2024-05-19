<?php

/**
 * BuddyPress - Groups Admin
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

?>
<div class="card-main">
	<div class="card-inner pt-0 pb-0">
		<div class="item-list-tabs no-ajax" id="subnav" >
			<div class="col-12">
				<div class="socialv-subtab-lists">
					<div class="left" onclick="slide('left',event)">
						<i class="iconly-Arrow-Left-2 icli"></i>
					</div>
					<div class="right" onclick="slide('right',event)">
						<i class="iconly-Arrow-Right-2 icli"></i>
					</div>
					<div class="socialv-subtab-container custom-nav-slider">
						<ul class="list-inline m-0">
							<?php bp_group_admin_tabs(); ?>
						</ul>
					</div>
				</div>
			</div>
		</div><!-- .item-list-tabs -->
	</div>
</div>
<?php if (bp_is_action_variable('manage-members')) : ?>
	<div class="card-main card-space">
		<div class="card-inner">
			<?php
			do_action('bp_before_group_admin_form'); ?>
		</div>
	</div>
<?php endif; ?>
<div class="card-main card-space">
	<div class="card-inner">
		<form action="<?php bp_group_admin_form_action(); ?>" name="group-settings-form" id="group-settings-form" class="standard-form1" method="post" enctype="multipart/form-data">

			<?php
			/**
			 * Fires inside the group admin form and before the content.
			 *
			 * @since 1.1.0
			 */
			do_action('bp_before_group_admin_content'); ?>

			<?php /* Fetch the template for the current admin screen being viewed */ ?>

			<?php if (bp_is_group_admin_screen(bp_action_variable())) : ?>

				<?php bp_get_template_part('groups/single/admin/' . bp_action_variable()); ?>

			<?php endif; ?>

			<?php

			/**
			 * Fires inside the group admin template.
			 *
			 * Allows plugins to add custom group edit screens.
			 *
			 * @since 1.1.0
			 */
			do_action('groups_custom_edit_steps'); ?>

			<?php

			/**
			 * Fires inside the group admin form and after the content.
			 *
			 * @since 1.1.0
			 */
			do_action('bp_after_group_admin_content'); ?>

		</form><!-- #group-settings-form -->
	</div>
</div>

<?php
/**
 * Fires after the group admin form and content.
 *
 * @since 2.7.0
 */
do_action('bp_after_group_admin_form');
