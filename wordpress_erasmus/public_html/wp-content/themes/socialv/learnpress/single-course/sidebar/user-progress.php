<?php
/**
 * Template for displaying progress of single course.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.2
 */

defined( 'ABSPATH' ) || exit();

if ( ! isset( $user ) || ! isset( $course ) || ! isset( $course_data ) || ! isset( $course_results ) ) {
	return;
}

$passing_condition = $course->get_passing_condition();

if (!empty($course_results['items'])) {
	$quiz_false = $course_results['items']['quiz']['completed'] - $course_results['items']['quiz']['passed'];
}
?>

<div class="course-results-progress">
	<?php do_action('learn-press/user-item-progress', $course_results, $course_data, $user, $course); ?>

	<div class="course-progress">
		<label class="lp-course-progress-heading"><?php esc_html_e('Course Results:', 'socialv'); ?> <span class="number"><b><?php echo esc_html($course_results['result']); ?></b><span class="percentage-sign">%</span></span>
		</label>
		<div class="learn-press-progress lp-course-progress <?php echo esc_attr($course_data->is_passed() ? ' passed' : ''); ?>" data-value="<?php echo esc_attr($course_results['result']); ?>" data-passing-condition="<?php echo esc_attr($passing_condition); ?>" title="<?php echo esc_attr(learn_press_translate_course_result_required($course)); ?>">
			<div class="progress-bg lp-progress-bar">
				<div class="progress-active lp-progress-value" style="left: <?php echo esc_attr($course_results['result']); ?>%;">
				</div>
			</div>
			<div class="lp-passing-conditional" data-content="<?php esc_attr(printf(esc_html__('Passing condition: %s%%', 'socialv'), $passing_condition)); ?>" style="left: <?php echo esc_attr($passing_condition); ?>%;">
			</div>
		</div>
	</div>

</div>