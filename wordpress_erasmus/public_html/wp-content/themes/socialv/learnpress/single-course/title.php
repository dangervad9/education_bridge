<?php
/**
 * Template for displaying title of single course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/title.php.
 *
 * @author  ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.1
 */

use function SocialV\Utility\socialv;
defined( 'ABSPATH' ) || exit();
?>


<div class="socialv-breadcrumb">
	<nav aria-label="breadcrumb" class="text-start socialv-breadcrumb-nav">
		<?php socialv()->socialv_breadcrumb_nav("breadcrumb main-bg"); ?>
	</nav>
</div>
<h1 class="course-title"><?php the_title(); ?></h1>
