<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package socialv
 */

namespace SocialV\Utility;

use SocialV\Utility\Dynamic_Style\Styles\Footer;

$footer_class = '';
$socialv_options = get_option('socialv-options');
$is_default = $is_footer = true;
if (function_exists("get_field")) {
	$footer = new Footer();
	$is_footer = $footer->is_socialv_footer();
}
if ($is_footer) {
	if ($is_default) {
?>
		<footer class="footer socialv-footer">
			<?php
			get_template_part('template-parts/footer/widget');
			get_template_part('template-parts/footer/copyright');
			?>
		</footer><!-- #colophon -->
<?php
	}
}
?>
<!-- === back-to-top === -->
<div id="back-to-top" class="css-prefix-top">
	<a class="top" id="top" href="#top">
		<i class="iconly-Arrow-Up-2 icli"></i>
	</a>
</div>
<!-- === back-to-top End === -->
</div>
</div><!-- #page -->
<?php wp_footer(); ?>
</body>

</html>