<?php

/**
 * Template part for displaying the footer info
 *
 * @package socialv
 */

namespace SocialV\Utility;

$is_default_copyright = true;
if (class_exists("ReduxFramework")) {
	$socialv_options = get_option('socialv-options');
	if ($socialv_options['display_copyright'] == 'no') {
		return;
	} else {
		$is_default_copyright = false;
	}
}
?>

<?php
if (!$is_default_copyright) {
?>
	<div class="copyright-footer">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12 m-0">
					<div class="pt-3 pb-3 text-<?php echo esc_attr($socialv_options['footer_copyright_align']); ?>">
						<?php if (!empty($socialv_options['footer_copyright'])) {  ?>
							<span class="copyright">
								<?php echo html_entity_decode($socialv_options['footer_copyright']); ?>
							</span>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div><!-- .site-info -->
<?php } else { ?>
	<div class="copyright-footer">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="pt-3 pb-3 text-center">
						<span class="copyright">
							<a target="_blank" href="<?php echo esc_url('https://themeforest.net/user/iqonicthemes/portfolio/'); ?>">
								<?php esc_html_e('© 2023', 'socialv'); ?>
								<strong><?php esc_html_e(' socialv ', 'socialv'); ?></strong>
								<?php esc_html_e('. All Rights Reserved.', 'socialv'); ?>
							</a>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div><!-- .site-info -->
<?php } ?>