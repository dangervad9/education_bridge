<?php

/**
 * Template for displaying course rate.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/course-review/course-rate.php.
 *
 * @author  ThimPress
 * @package LearnPress/Course-Review/Templates
 * version  4.0.1
 */

// Prevent loading this file directly
defined('ABSPATH') || exit;

$course_id       = get_the_ID();
$course_rate_res = learn_press_get_course_rate($course_id, false);
$course_rate     = $course_rate_res['rated'];
$total           = $course_rate_res['total'];

$user_id = learn_press_get_current_user_id();
if (!empty($user_id)) {
	$args     = array(
		'user_id' => $user_id,
		'post_id' => $course_id,
	);
	$comments = get_comments($args);

	if (!empty($comments)) {
		$comment_id = $comments[0]->comment_ID;
		$status     = wp_get_comment_status($comment_id);
		if ('approved' !== $status) {
			echo '<div class="course-rate__message">' . learn_press_get_message(esc_html__('Thank you for your review. Your review will be visible after it has been approved!', 'socialv'), 'success') . '</div>';
		}
	}
}
?>
<div class="course-rate">

	<div class="course-rate__summary">
		<div class="course-rate__summary-value"><?php echo number_format($course_rate, 1); ?></div>
		<div class="course-rate__summary-stars">
			<?php
			learn_press_course_review_template('rating-stars.php', array('rated' => $course_rate));
			?>
		</div>
		<div class="course-rate__summary-text">
			<?php printf(__('<span>%d</span> total', 'socialv'), $total); ?>
		</div>

	</div>

	<div class="course-rate__details">
		<?php
		foreach ($course_rate_res['items'] as $item) :
		?>
			<div class="course-rate__details-row">
				<span class="course-rate__details-row-star">
					<?php echo esc_html($item['rated']); ?>
					<i class="fas"><i class="icon-fill-star"></i></i>
				</span>
				<div class="course-rate__details-row-value">
					<div class="rating-gray"></div>
					<div class="rating" style="width:<?php echo esc_attr($item['percent']); ?>%;" title="<?php echo esc_attr($item['percent']); ?>%">
					</div>
					<span class="rating-count"><?php echo esc_html($item['total']); ?></span>
				</div>
			</div>
		<?php
		endforeach;
		?>
	</div>
</div>