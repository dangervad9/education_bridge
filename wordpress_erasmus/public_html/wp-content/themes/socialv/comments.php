<?php

/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package socialv
 */

namespace SocialV\Utility;

$post_section = socialv()->post_style();
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
	return;
}

socialv()->print_styles('socialv-comments');

?>
<div id="comments" class="comments-area">
	<?php
	// You can start editing here -- including this comment!
	if (have_comments()) {
	?>
		<h3 class="comments-title">
			<?php
			$comments_number = get_comments_number();
			echo esc_html($comments_number);
			if ($comments_number == 1) {
				esc_html_e(' Comment', 'socialv');
			} else {
				esc_html_e(' Comments', 'socialv');
			}
			?>
		</h3>
		<?php the_comments_navigation(); ?>

		<?php socialv()->the_comments(); ?>

		<?php
		if (!comments_open()) {
		?>
			<p class="no-comments"><?php esc_html_e('Comments are closed.', 'socialv'); ?></p>
	<?php
		}
	}

	$comment_btn = socialv()->socialv_get_comment_btn($tag = "button", $label = esc_html__('Post Comment','socialv'), $attr = array('class' => 'submit'));
	$args = array(
		'label_submit' => esc_html__('Post Comment', 'socialv'),
		'comment_notes_before' => esc_html__('Your email address will not be published. Required fields are marked *', 'socialv') . '',
		'comment_field' => '<div class="comment-form-comment form-floating">
								<textarea id="comment" name="comment" class="form-control" placeholder="' . esc_attr__('Comment', 'socialv') . '" required="required"></textarea>
								<label for="comment">' . esc_html__('Comment*', 'socialv') . '</label>
							</div>',
		'format'            => 'xhtml',
		'fields' => array(
			'author' => '<div class="row">
							<div class="col-lg-4">
								<div class="comment-form-author form-floating">
									<input id="author" name="author" class="form-control" aria-required="true" required="required" placeholder="' . esc_attr__('Name*', 'socialv') . '" />
									<label for="author">' . esc_html__('Name*', 'socialv') . '</label>
								</div>
							</div>',
			'email' => '<div class="col-lg-4">
							<div class="comment-form-email form-floating">
								<input id="email" name="email" class="form-control" required="required" placeholder="' . esc_attr__('Email*', 'socialv') . '" />
								<label for="email">' . esc_html__('Email*', 'socialv') . '</label>
							</div>
						</div>',
			'url' => 	'<div class="col-lg-4">
							<div class="comment-form-url form-floating">
								<input id="url" name="url"  class="form-control" placeholder="' . esc_attr__('Website', 'socialv') . '" />
								<label for="url">' . esc_html__('Website', 'socialv') . '</label>
							</div>
						</div>
					</div>',
			'cookies' => 	'<div class="socialv-check">
								<label>
									<input type="checkbox" required="required" /> <span>' . esc_html__("Save my name, email, and website in this browser for the next time I comment.", "socialv") . '</span>
								</label>
							</div>',
		),
		'submit_button'	=> $comment_btn,
	);
	comment_form($args);
	?>
</div><!-- #comments -->