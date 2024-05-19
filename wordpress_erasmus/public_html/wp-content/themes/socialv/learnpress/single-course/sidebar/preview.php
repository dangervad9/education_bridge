<?php

/**
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 4.0.1
 */

use function SocialV\Utility\socialv;

defined('ABSPATH') || exit;
?>

<div class="course-sidebar-preview">
	<div class="media-preview">
		<?php
		LearnPress::instance()->template('course')->course_media_preview();
		learn_press_get_template('loop/course/badge-featured');
		?>
	</div>
	<div class="course-pricebox">
		<?php LearnPress::instance()->template('course')->course_pricing();
		// Graduation.
		LearnPress::instance()->template('course')->course_graduation(); ?>
		<div class="payments">
			<?php LearnPress::instance()->template('course')->course_buttons();
			?>
		</div>
	</div>
</div>
<?php socialv()->course_sidebar_meta_content(); ?>