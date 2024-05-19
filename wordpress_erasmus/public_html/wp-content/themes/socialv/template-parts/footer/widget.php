<?php

/**
 * Template part for displaying the footer info
 *
 * @package socialv
 */

namespace SocialV\Utility;

$footer = socialv()->get_footer_option();
if (count($footer) == 0) {
	return;
}
?>
<div class="footer-top">
	<div class="container">
		<div class="row">
			<?php
			foreach ($footer['value'] as $key => $item) {
				if (is_active_sidebar('footer_' . ($key + 1) . '_sidebar')) { ?>
					<div class="<?php echo esc_attr($item, 'socialv'); ?>">
						<?php dynamic_sidebar('footer_' . ($key + 1) . '_sidebar'); ?>
					</div>
			<?php
				}
			}
			?>
		</div>
	</div>
</div>