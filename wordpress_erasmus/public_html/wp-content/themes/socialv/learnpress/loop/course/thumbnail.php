<?php

/**
 * Template for displaying thumbnail of course within the loop.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/loop/course/thumbnail.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.1
 */

defined('ABSPATH') || exit();

$course = learn_press_get_course();

if (!$course) {
	return;
}
?>

<div class="course-thumbnail">
	<a href="<?php the_permalink(); ?>">
		<?php
		$image_url =	wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'course_thumbnail');
		if (!empty($image_url[0])) {
			$image_url = $image_url[0];
		} else {
			$image_url = LP()->image('no-image.png');
		} ?>
		<img src="<?php echo esc_url($image_url); ?>" loading="lazy" class="rounded" alt="<?php the_title(); ?>">
	</a>
</div>