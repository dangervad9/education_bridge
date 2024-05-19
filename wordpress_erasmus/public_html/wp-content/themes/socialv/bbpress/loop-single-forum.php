<?php

/**
 * Forums Loop - Single Forum
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

?>
<tr id="bbp-forum-<?php bbp_forum_id(); ?>" <?php bbp_forum_class(); ?>>
	<?php if (bbp_is_user_home() && bbp_is_subscriptions()) : ?>
		<td class="pe-0">
			<span class="bbp-row-actions">

				<?php do_action('bbp_theme_before_forum_subscription_action'); ?>

				<?php bbp_forum_subscription_link(array('before' => '', 'subscribe' => '<i class="iconly-Plus icli"></i>', 'unsubscribe' => '<i class="iconly-Close-Square icli"></i>')); ?>

				<?php do_action('bbp_theme_after_forum_subscription_action'); ?>

			</span>
		</td>
	<?php endif; ?>
	<td>

		<?php do_action('bbp_theme_before_forum_title'); ?>

		<h6>
			<a class="bbp-topic-permalink" href="<?php bbp_forum_permalink(); ?>"><?php bbp_forum_title(); ?></a>
		</h6>

		<?php do_action('bbp_theme_after_forum_title'); ?>
		<?php do_action('bbp_theme_before_topic_meta'); ?>
		<div class="bbp-topic-meta mt-1">
			<div class="topic-meta-box d-inline-block me-4">
				<div class="icons-main-meta d-flex align-items-center">
					<?php do_action('bbp_theme_before_forum_description'); ?>

					<span class="name"><?php bbp_forum_content(); ?></span>

					<?php do_action('bbp_theme_after_forum_description'); ?>
				</div>
			</div>
		</div>
		<?php do_action('bbp_theme_after_topic_meta'); ?>
	</td>
	<td>
		<span class="sv-voices"><?php bbp_forum_topic_count(); ?></span>
	</td>
	<td>
		<span class="sv-post"><?php bbp_show_lead_topic() ? bbp_forum_reply_count() : bbp_forum_post_count(); ?></span>
	</td>
	<td>
		<?php do_action('bbp_theme_before_forum_freshness_link'); ?>
		<ul class="d-flex list-img-group">
			<?php
			if (bbp_has_topics(array('order' => 'DESC', 'post_parent' => bbp_get_forum_id(), 'posts_per_page' => 3))) {
				while (bbp_topics()) : bbp_the_topic();
					$freshness_author = array_reverse(bbp_get_topic_engagements());
					$count = count($freshness_author);
					$len = $count < 3 ? $count : 3;
					for ($i = 0; $i < $len; $i++) {
						echo '<li class="list-inline-item"><a href="' . esc_url(bbp_get_user_profile_url($freshness_author[$i])) . '">' . get_avatar($freshness_author[$i], 35, '', '', array('class' => 'rounded-circle')) . '</a></li>';
					}
				endwhile;
			}
			?>
		</ul>
		<?php do_action('bbp_theme_after_forum_freshness_link'); ?>

	</td>
</tr>