<?php

/**
 * Template part for displaying a post's content
 *
 * @package socialv
 */

namespace SocialV\Utility;

if (is_single()) {
	the_content();
} else {
	the_excerpt();
}
?>
