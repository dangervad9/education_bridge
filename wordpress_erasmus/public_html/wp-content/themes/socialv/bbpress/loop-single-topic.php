<?php

/**
 * Topics Loop - Single
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

?>

<tr id="bbp-topic-<?php bbp_topic_id(); ?>" <?php bbp_topic_class(); ?>>

	<?php if (bbp_is_user_home() && bbp_is_favorites() || bbp_is_subscriptions()) : ?>
		<td class="pe-0">
			<?php if (bbp_is_favorites()) : ?>
				<span class="bbp-row-actions">

					<?php do_action('bbp_theme_before_topic_favorites_action'); ?>

					<?php bbp_topic_favorite_link(array('before' => '', 'favorite' => '<i class="iconly-Star icli"></i>', 'favorited' => '<i class="iconly-Star icbo"></i>')); ?>

					<?php do_action('bbp_theme_after_topic_favorites_action'); ?>

				</span>
			<?php elseif (bbp_is_subscriptions()) : ?>
				<span class="bbp-row-actions">

					<?php do_action('bbp_theme_before_topic_subscription_action'); ?>

					<?php bbp_topic_subscription_link(array('before' => '', 'subscribe' => '<i class="iconly-Plus icli"></i>', 'unsubscribe' => '<i class="iconly-Close-Square icli"></i>')); ?>

					<?php do_action('bbp_theme_after_topic_subscription_action'); ?>

				</span>
			<?php endif; ?>
		</td>
	<?php endif; ?>

	<td>
		<?php do_action('bbp_theme_before_topic_title'); ?>

		<h6>
			<a class="bbp-topic-permalink" href="<?php bbp_topic_permalink(); ?>"><?php bbp_topic_title(); ?></a>

		</h6>

		<?php do_action('bbp_theme_after_topic_title'); ?>
		<?php do_action('bbp_theme_before_topic_meta'); ?>
		<div class="bbp-topic-meta mt-1">
			<?php do_action('bbp_theme_before_topic_started_by'); ?>
			<div class="topic-meta-box d-inline-block me-4">
				<div class="icons-main-meta d-flex align-items-center">
					<i class="iconly-User2 icli me-1"></i>
					<span class="name"><?php echo bbp_get_topic_author_link(array('type' => 'name')); ?></span>
				</div>
			</div>
			<?php do_action('bbp_theme_after_topic_started_by'); ?>

			<?php if (!bbp_is_single_forum() || (bbp_get_topic_forum_id() !== bbp_get_forum_id())) : ?>
				<div class="topic-meta-box d-inline-block">
					<div class="icons-main-meta d-flex align-items-center">
						<i class="iconly-Folder icli me-1"></i>
						<?php do_action('bbp_theme_before_topic_started_in'); ?>
						<span class="name"><?php echo '<a href="' . bbp_get_forum_permalink(bbp_get_topic_forum_id()) . '">' . bbp_get_forum_title(bbp_get_topic_forum_id()) . '</a>'; ?></span>
						<?php do_action('bbp_theme_after_topic_started_in'); ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<?php do_action('bbp_theme_after_topic_meta'); ?>
	</td>
	<td>
		<span class="sv-voices"><?php bbp_topic_voice_count(); ?></span>
	</td>
	<td>
		<span class="sv-post"><?php bbp_show_lead_topic() ? bbp_topic_reply_count() : bbp_topic_post_count(); ?></span>
	</td>
	<td>
		<?php do_action('bbp_theme_before_topic_freshness_author'); ?>
		<ul class="list-inline d-flex list-img-group">
			<?php
			$freshness_author = array_reverse(bbp_get_topic_engagements());
			$count = count($freshness_author);
			$len = $count < 3 ? $count : 3;
			for ($i = 0; $i < $len; $i++) {
				echo '<li class="list-inline-item"><a href="' . esc_url(bbp_get_user_profile_url($freshness_author[$i])) . '">' . get_avatar($freshness_author[$i], 35, '', '', array('class' => 'rounded-circle')) . '</a></li>';
			}
			?>
		</ul>
		<?php do_action('bbp_theme_after_topic_freshness_author'); ?>
	</td>
</tr>