<?php

/**
 * Template for displaying tab nav of single course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/tabs/tabs.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.1
 */

use function SocialV\Utility\socialv;

defined('ABSPATH') || exit();

$tabs = socialv()->socialv_learn_press_get_course_tabs();

if (empty($tabs)) {
	return;
}

$active_tab = learn_press_cookie_get('course-tab');

if (!$active_tab) {
	$tab_keys   = array_keys($tabs);
	$active_tab = reset($tab_keys);
}

// Show status course
$lp_user = learn_press_get_current_user();

if ($lp_user && !$lp_user instanceof LP_User_Guest) {
	$can_view_course = $lp_user->can_view_content_course(get_the_ID());

	if (!$can_view_course->flag) {
		if (LP_BLOCK_COURSE_FINISHED === $can_view_course->key) {
			learn_press_display_message(
				esc_html__('You finished this course. This course has been blocked', 'socialv'),
				'warning'
			);
		} elseif (LP_BLOCK_COURSE_DURATION_EXPIRE === $can_view_course->key) {
			learn_press_display_message(
				esc_html__('This course has been blocked reason by expire', 'socialv'),
				'warning'
			);
		}
	}
}
?>
<div id="learn-press-course-tabs" class="course-tabs">
	<div class="socialv-subtab-lists">
		<div class="left" onclick="slide('left',event)">
			<i class="iconly-Arrow-Left-2 icli"></i>
		</div>
		<div class="right" onclick="slide('right',event)">
			<i class="iconly-Arrow-Right-2 icli"></i>
		</div>
		<div class="socialv-subtab-container custom-nav-slider">
			<ul class="nav nav-tabs learn-press-nav-tabs course-nav-tabs">
				<?php
				foreach ($tabs as $key => $tab) : ?>
					<?php
					$classes = 'course-nav-tab-' . esc_attr($key);
					if ($active_tab === $key) {
						$active = 'active';
					}
					?>
					<li class="<?php echo esc_attr($classes); ?>"><a class="nav-link <?php echo !empty($tab['active']) && $tab['active'] ? esc_attr('show active', 'socialv') : ''; ?>" data-bs-toggle="tab" data-bs-target="#<?php echo esc_attr($tab['id']); ?>" href="#<?php echo esc_attr($tab['id']); ?>" role="tab" aria-controls="<?php echo esc_attr($tab['id']); ?>" aria-selected="true"><span><?php echo esc_html($tab['title']); ?></span></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<div class="course-tab-panels tab-content">
		<?php foreach ($tabs as $key => $tab) : ?>
			<div class="tab-pane course-tab-panel-<?php echo esc_attr($key); ?> fade <?php echo !empty($tab['active']) && $tab['active'] ? esc_attr('show active', 'socialv') : ''; ?>" id="<?php echo esc_attr($tab['id']); ?>">
				<?php
				if (isset($tab['callback']) && is_callable($tab['callback'])) {
					call_user_func($tab['callback'], $key, $tab);
				} else {
					do_action('learn-press/course-tab-content', $key, $tab);
				}
				?>
			</div>
		<?php endforeach; ?>
	</div>
</div>