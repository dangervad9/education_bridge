<?php

/**
 * Template for displaying rating stars.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/course-review/rating-stars.php.
 *
 * @author  ThimPress
 * @package LearnPress/Course-Review/Templates
 * version  4.0.1
 */

// Prevent loading this file directly
defined('ABSPATH') || exit;

$percent = (!isset($rated)) ? 0 : min(100, (round((int) $rated * 2) / 2) * 20);
$title   = sprintf(__('%s out of 5 stars', 'socialv'), round((int) $rated, 2));

?>
<div class="review-stars-rated" title="<?php echo esc_attr($title); ?>">
    <?php for ($i = 1; $i <= 5; $i++) {
        $p = ($i * 20);
        $r = max($p <= $percent ? 100 : ($percent - ($i - 1) * 20) * 5, 0);

    ?>
        <div class="review-star">
            <i class="far"><i class="icon-border-star"></i></i>
            <i class="fas" style="width:<?php echo esc_attr($r); ?>%;"><i class="icon-fill-star"></i></i>
        </div>
    <?php } ?>
</div>