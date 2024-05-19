<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package docly
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

$is_comments = have_comments() ? 'have_comments' : 'no_comments';
?>

<?php if ( have_comments() ) : ?>
    <div class="comment_inner <?php echo esc_attr($is_comments); ?>" id="comments">
        <h2 class="c_head"> <?php docly_comment_count( get_the_ID() ) ?> </h2>
        <ul class="comment_box list-unstyled">
            <?php
            wp_list_comments(
                array(
                    'style'         => 'ul',
                    'short_ping'    => true,
                    'walker'        => new Docly_Walker_Comment,
                )
            );
            the_comments_navigation();
            ?>
        </ul>
    </div>
    <?php
endif;
?>

<div class="blog_comment_box <?php echo esc_attr($is_comments) ?>">
    <?php
    if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
        <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'docly' ); ?></p>
        <?php
    endif;
    ?>

    <?php
    $commenter      = wp_get_current_commenter();
    $req            = get_option( 'require_name_email' );
    $aria_req       = ( $req ? " aria-required='true'" : '' );
    $fields =  array(
        'author' => '<div class="col-md-6 form-group"> <input type="text" class="form-control" name="author" id="name" value="'.esc_attr($commenter['comment_author']).'" placeholder="'.esc_attr__( 'Name *', 'docly' ).'" '.$aria_req.'> </div>',
        'email'	=> '<div class="col-md-6 form-group"> <input type="email" class="form-control" name="email" id="email" value="'.esc_attr($commenter['comment_author_email']).'" placeholder="'.esc_attr__( 'Email *', 'docly' ).'" '.$aria_req.'> </div>',
        'url'	=> '<div class="col-md-12 form-group"><input type="url" class="form-control" name="url" value="'.esc_attr($commenter['comment_author_url']).'" placeholder="'.esc_attr__( 'Website (Optional)', 'docly' ).'"> </div>',
    );
    $comments_args = array(
        'fields'                => apply_filters( 'comment_form_default_fields', $fields ),
        'class_form'            => 'get_quote_form row',
        'class_submit'          => 'btn action_btn thm_btn',
        'title_reply_before'    => '<h2 class="c_head">',
        'title_reply'           => esc_html__( 'Leave a Comment', 'docly' ),
        'title_reply_after'     => '</h2>',
        'comment_notes_before'  => '',
        'comment_field'         => '<div class="col-md-12 form-group"><textarea name="comment" id="comment" class="form-control message" placeholder="'.esc_attr__( 'Comment', 'docly' ).'"></textarea></div>',
        'comment_notes_after'   => '',
    );
    comment_form($comments_args);
    ?>
</div>
