<?php
/**
 * Topics Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

do_action( 'bbp_template_before_topics_loop' );

bbp_get_template_part( 'loop-topics-head' );
?>

<div class="load-forum">
<?php
$paged          = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
$is_queried_obj = is_singular( 'forum' ) ? get_queried_object_id() : false;
$user_id        = is_singular( 'forum' ) ? false : bbp_get_displayed_user_field( 'ID' );
$args           = [
	'post_type'      => 'topic',
	'post_parent'    => $is_queried_obj,
	'post_status'    => 'publish',
	'order'          => 'DESC',
	'orderby'        => 'ID',
	'posts_per_page' => get_option( '_bbp_topics_per_page', 10 ),
	'paged'          => $paged,
	'author'         => $user_id,
];
$query          = new WP_Query( $args );

if ( $query->have_posts() && ! in_array( 'bbp-user-page', get_body_class() ) ) :
	echo '<div class="community-posts-wrapper bb-radius">';
	while ( $query->have_posts() ) :
		$query->the_post();
		global $post;
		 //$parent_post_id = get_post_meta( get_the_ID(), '_bbp_topic_id', true );
		 $parent_post_id = get_queried_object_id();
		 $favoriters     = get_post_meta( get_the_ID(), '_bbp_favorite', true );
		 $favorite_count = ! empty( $favoriters ) ? $favoriters[0] : '0';
		 $get_reply      = get_post_meta( get_the_ID(), '_bbp_reply_count', true );
		 $_reply_count   = isset( $get_reply ) && ! empty( $get_reply ) ? $get_reply : 0;
		?>
		<div class="community-post style-two">
			<div class="post-content">
				<div class="author-avatar">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ); ?>
				</div>
				<div class="entry-content">
					<?php
                        the_title( sprintf( '<a href="%s" rel="bookmark"> <h3 class="post-title">', get_permalink() ), '</h3></a>' );
                        do_action( 'bbpc-resolved-topics' );
					?>
					<?php do_action( 'bbp_theme_after_topic_title' ); ?>
					<ul class="meta">
						<li>
							<?php echo get_the_post_thumbnail( bbp_get_topic_forum_id(), [ 40, 40 ] ); ?>
							<a href="<?php echo get_permalink( bbp_get_topic_forum_id() ); ?>">
								<?php echo get_the_title( bbp_get_topic_forum_id() ); ?>
							</a>
						</li>
						<li><i class="icon_calendar"></i> <?php bbp_topic_post_date( get_the_ID() ); ?> </li>
					</ul>
				</div>
			</div>
			<div class="post-meta-wrapper">
				<ul class="post-meta-info">
					<li><a href="<?php echo get_permalink(); ?>">
						<i class="icon_chat_alt"></i> <?php echo esc_html( $_reply_count ); ?> </a>
					</li>
					<li><a href="<?php echo get_permalink(); ?>">
						<i class="icon_star"></i> <?php echo esc_html( $favorite_count ); ?> </a>
					</li>
				</ul>
			</div>
		</div>
		<?php
	endwhile;
	wp_reset_postdata();
	echo '</div>';

elseif ( in_array( 'bbp-user-page', get_body_class() ) ) :

	while ( bbp_topics() ) :
		bbp_the_topic();
		bbp_get_template_part( 'loop', 'single-topic' );
	endwhile;

else :
	echo '<h3 class="error">' . esc_html__( 'Oops! No Post Found', 'docly' ) . '</h3>';
endif;

echo '</div>';
