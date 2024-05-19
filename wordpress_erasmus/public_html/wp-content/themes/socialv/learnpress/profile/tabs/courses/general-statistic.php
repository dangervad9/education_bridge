<?php

/**
 * Template for displaying general statistic in user profile overview.
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 4.0.1
 */

defined('ABSPATH') || exit;

if (empty($statistic) || empty($user)) {
	return;
}

?>

<div id="dashboard-general-statistic">

	<?php do_action('learn-press/before-profile-dashboard-general-statistic-row'); ?>

	<div class="dashboard-general-statistic__row">
		<?php do_action('learn-press/before-profile-dashboard-user-general-statistic'); ?>

		<div class="statistic-box" title="<?php esc_attr_e('Total courses enrolled', 'socialv'); ?>">
			<div class="statistic-inner">
				<div class="img-icon"><i class="icon-lesson"></i></div>
				<span class="statistic-box__number"><?php echo esc_html($statistic['enrolled_courses']); ?></span>
				<p class="statistic-box__text"><?php esc_html_e('Enrolled Courses', 'socialv'); ?></p>
			</div>
		</div>
		<div class="statistic-box" title="<?php esc_attr_e('Total courses are learning', 'socialv'); ?>">
			<div class="statistic-inner">
				<div class="img-icon"><i class="icon-graduation-student-cap"></i></div>
				<span class="statistic-box__number"><?php echo esc_html($statistic['active_courses']); ?></span>
				<p class="statistic-box__text"><?php esc_html_e('Active Courses', 'socialv'); ?></p>
			</div>
		</div>
		<div class="statistic-box" title="<?php esc_attr_e('Total courses has finished', 'socialv'); ?>">
			<div class="statistic-inner">
				<div class="img-icon"><i class="icon-trophy"></i></div>
				<span class="statistic-box__number"><?php echo esc_html($statistic['completed_courses']); ?></span>
				<p class="statistic-box__text"><?php esc_html_e('Completed Courses', 'socialv'); ?></p>
			</div>
		</div>

		<?php do_action('learn-press/after-profile-dashboard-user-general-statistic'); ?>

		<?php do_action('learn-press/profile-dashboard-general-statistic-row'); ?>

		<?php if ($user->can_create_course()) : ?>
			<?php do_action('learn-press/before-profile-dashboard-instructor-general-statistic'); ?>
			<div class="statistic-box" title="<?php esc_attr_e('Total courses created', 'socialv'); ?>">
				<div class="statistic-inner">
					<div class="img-icon"><i class="icon-education-program"></i></div>
					<span class="statistic-box__number"><?php echo esc_html($statistic['total_courses']); ?></span>
					<p class="statistic-box__text"><?php esc_html_e('Total Courses', 'socialv'); ?></p>
				</div>
			</div>
			<div class="statistic-box" title="<?php esc_attr_e('Total students attended', 'socialv'); ?>">
				<div class="statistic-inner">
					<div class="img-icon"><i class="icon-students"></i></div>
					<span class="statistic-box__number"><?php echo esc_html($statistic['total_users']); ?></span>
					<p class="statistic-box__text"><?php esc_html_e('Total Students', 'socialv'); ?></p>
				</div>
			</div>

			<?php do_action('learn-press/after-profile-dashboard-instructor-general-statistic'); ?>

		<?php endif; ?>

		<?php do_action('learn-press/after-profile-dashboard-general-statistic-row'); ?>
	</div>

</div>