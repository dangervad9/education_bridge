<?php

/**
 * Template for displaying content of archive courses page.
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 4.0.1
 */

use function SocialV\Utility\socialv;

defined('ABSPATH') || exit;

/**
 * @since 4.0.0
 *
 * @see LP_Template_General::template_header()
 */
if (empty($is_block_theme)) {
	do_action('learn-press/template-header');
}

do_action('learn-press/before-main-content');
$page_title = learn_press_page_title(false);
$post_section = socialv()->post_style();
?>
<div class="site-content-contain">
	<div id="content" class="site-content">
		<div id="primary" class="content-area">
			<main id="main" class="site-main">
				<div class="<?php echo apply_filters('content_container_class', 'container'); ?>">
					<div class="row <?php echo esc_attr($post_section['row_reverse']); ?>">
						<?php socialv()->socialv_the_layout_class(); ?>
						<div class="lp-content-area">
							<div class="row align-items-center course-main-tab-container ms-0 me-0">
								<div class="col-md-4 col-12 mb-3 mb-md-0 item-list-tabs">
									<?php if ($page_title) : ?>
										<div class="socialv-subtab-lists">
											<?php echo wp_kses_post($page_title); ?>
										</div>
									<?php endif; ?>
								</div>
								<div class="col-md-8 col-12 item-list-filters">
									<?php
									/**
									 * LP Hook
									 */
									do_action('learn-press/before-courses-loop');
									?>
								</div>
							</div>
							
							<?php

							LP()->template('course')->begin_courses_loop();
							if (LP_Settings_Courses::is_ajax_load_courses() && !LP_Settings_Courses::is_no_load_ajax_first_courses()) {
								echo '<li class="lp-archive-course-skeleton" style="width:100%">';
								socialv()->socialv_skeleton_animation();
								echo '</li>';
							} else {
								if (have_posts()) {
									while (have_posts()) :
										the_post();

										learn_press_get_template_part('content', 'course');

									endwhile;
								} else {
									LP()->template('course')->no_courses_found();
								}

								if (LP_Settings_Courses::is_ajax_load_courses()) {
									echo '<li class="lp-archive-course-skeleton no-first-load-ajax" style="width:100%; display: none">';
									socialv()->socialv_skeleton_animation();
									echo '</li>';
								}
							}

							LP()->template('course')->end_courses_loop();
							do_action('learn-press/after-courses-loop');

							?>
						</div>
						<?php socialv()->socialv_sidebar(); ?>
					</div>
				</div>
			</main>
		</div>
	</div>
</div>
<?php
/**
 * @since 4.0.0
 *
 * @see   LP_Template_General::template_footer()
 */
if (empty($is_block_theme)) {
	do_action('learn-press/template-footer');
}
