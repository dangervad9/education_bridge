<?php

/**
 * Template part for displaying the page content when a 404 error has occurred
 *
 * @package socialv
 */

namespace SocialV\Utility;

$socialv_options = get_option('socialv-options');

?>

<div class="<?php echo apply_filters('content_container_class', 'container'); ?>">
	<div class="content-area">
		<main class="site-main">
			<div class="error-404 not-found">
				<div class="page-content">
					<div class="row">
						<div class="col-sm-12 text-center">
							<?php
							if (!empty($socialv_options['404_banner_image']['url'])) {	
								?>
								<div class="fourzero-image mb-5">
									<img src="<?php echo esc_url($socialv_options['404_banner_image']['url']); ?>" loading="lazy" alt="<?php esc_attr_e('404', 'socialv'); ?>" />
								</div>
							<?php
							} else {
								$bgurl = get_template_directory_uri() . '/assets/images/redux/404.png';
							?>
								<div class="fourzero-image mb-5">
									<img src="<?php echo esc_url($bgurl); ?>" loading="lazy" alt="<?php esc_attr_e('404', 'socialv'); ?>" />
								</div>
							<?php
							}

							if (!empty($socialv_options['404_title'])) { ?>
								<h2> <?php
										$four_title = $socialv_options['404_title'];
										echo esc_html($four_title); ?>
								</h2>
							<?php } else { ?>
								<h2><?php esc_html_e('Page Not Found.', 'socialv'); ?></h2>
							<?php
							}

							if (!empty($socialv_options['404_description'])) { ?>
								<p class="mb-5">
									<?php $four_des = $socialv_options['404_description'];
									echo esc_html($four_des); ?>
								</p>
							<?php } else { ?>
								<p class="mb-5">
									<?php esc_html_e('The requested page does not exist.', 'socialv'); ?>
								</p>
							<?php } ?>

							<div class="d-block">
								<?php
								if (!empty($socialv_options['404_backtohome_title'])) {
									$btn_text  = esc_html($socialv_options['404_backtohome_title']);
								} else {
									$btn_text  = esc_html__('Back to Home','socialv');
								} ?>
								<?php socialv()->socialv_get_blog_readmore(home_url(), $btn_text); ?>
							</div>
						</div>
					</div>
				</div><!-- .page-content -->
			</div><!-- .error-404 -->
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .container -->