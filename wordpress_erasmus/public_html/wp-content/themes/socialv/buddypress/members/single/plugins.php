<?php

/**
 * BuddyPress - Users Plugins Template
 *
 * 3rd-party plugins should use this template to easily add template
 * support to their plugins for the members component.
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

/**
 * Fires at the start of the member plugin template.
 *
 * @since 1.2.0
 */
do_action('bp_before_member_plugin_template');
?>

<?php if (!bp_is_current_component_core()) :
	if (bp_current_action() != 'courses' && bp_current_action() != 'badge' && bp_current_action() != 'ranks' && bp_current_action() != 'points' && bp_current_action() != 'membership' && bp_current_action() != 'bp-messages') : ?>
		<div class="card-main card-space-bottom">
			<div class="card-inner pt-0 pb-0">
				<div class="item-list-tabs no-ajax" id="subnav">
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
								<?php

								/**
								 * Fires inside the member plugin template nav <ul> tag.
								 *
								 * @since 1.2.2
								 */
								do_action('bp_member_plugin_options_nav'); ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	endif;
endif; ?>

<?php if (bp_current_action() == 'shop') {
	echo '<div class="card-inner">';
}
if (has_action('bp_template_title')) : ?>
	<div class="card-head card-header-border d-flex align-items-center justify-content-between">
		<div class="head-title">
			<h4 class="card-title"><?php do_action('bp_template_title'); ?></h4>
		</div>
	</div>
<?php endif; ?>

<?php

/**
 * Fires and displays the member plugin template content.
 *
 * @since 1.0.0
 */
do_action('bp_template_content');

if (bp_current_action() == 'shop') {
	echo '</div>';
}
?>

<?php

/**
 * Fires at the end of the member plugin template.
 *
 * @since 1.2.0
 */
do_action('bp_after_member_plugin_template');
