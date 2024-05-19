<?php
/**
 * Custom comment walker for this theme.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since 1.0.0
 */

if ( ! class_exists('Docly_Walker_Comment') ) {
    /**
     * CUSTOM COMMENT WALKER
     * A custom walker for comments, based on the walker in Twenty Nineteen.
     */
    class Docly_Walker_Comment extends Walker_Comment {

        /**
         * Outputs a comment in the HTML5 format.
         *
         * @see wp_list_comments()
         * @see https://developer.wordpress.org/reference/functions/get_comment_author_url/
         * @see https://developer.wordpress.org/reference/functions/get_comment_author/
         * @see https://developer.wordpress.org/reference/functions/get_avatar/
         * @see https://developer.wordpress.org/reference/functions/get_comment_reply_link/
         * @see https://developer.wordpress.org/reference/functions/get_edit_comment_link/
         *
         * @param WP_Comment $comment Comment to display.
         * @param int        $depth   Depth of the current comment.
         * @param array      $args    An array of arguments.
         */
        protected function html5_comment( $comment, $depth, $args ) {
            $arrow_icon = is_rtl() ? 'arrow_left' : 'arrow_right';
            ?>
            <<?php echo ( 'div' === $args['style'] ) ? 'div' : 'li'; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'post_comment has_children' : 'post_comment', $comment ); ?>>
            <div class="comment_author d-flex">
                <?php
                if ( get_avatar($comment) ) {
                    echo get_avatar($comment, 50, null, null, array( 'class'=> 'img_rounded'));
                }
                ?>
                <div class="media-body">
                    <div class="comment_info">
                        <h3> <?php comment_author(); ?> </h3>
                        <div class="comment_date"> <?php comment_date(get_option( 'date_format')); ?> </div>
                    </div>
                    <?php if ( '0' === $comment->comment_approved ) : ?>
                        <em> <?php esc_html_e( 'Your comment is awaiting moderation.', 'docly' ) ?></em><br />
                    <?php endif; ?>
                    <?php comment_text(); ?>

                    <?php comment_reply_link(array_merge( $args, array( 'reply_text' => '<i class="'.esc_attr($arrow_icon ).'"></i>'.esc_html__('Reply', 'docly'), 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>

                </div>
            </div>
            <?php
        }
    }
}
