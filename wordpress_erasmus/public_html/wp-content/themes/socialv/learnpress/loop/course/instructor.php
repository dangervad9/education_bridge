<?php
/**
 * Template for displaying instructor of course within the loop.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/loop/course/instructor.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.1
 */

defined( 'ABSPATH' ) || exit();

$course = learn_press_get_course();
if ( ! $course ) {
	return;
}
?>

<span class="course-instructor">
	<?php echo esc_html__('By', 'socialv') .wp_kses_post( $course->get_instructor_html() ); ?>
</span>
