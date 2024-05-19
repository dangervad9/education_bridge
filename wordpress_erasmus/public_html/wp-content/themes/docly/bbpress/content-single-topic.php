<?php
/**
 * Single Topic Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

$main_column = is_active_sidebar( 'forum_archive_sidebar' ) ? '8' : '12';
?>

<section <?php bbp_topic_class( get_the_ID(), [ 'forum-single-content' ] ); ?>>
	<div class="row">
		<div class="col-lg-<?php echo esc_attr( $main_column ); ?>">

			<?php if ( post_password_required() ) : ?>

				<?php bbp_get_template_part( 'form', 'protected' ); ?>

			<?php else : ?>

				<!-- Forum post top area -->
				<div class="row">
					<div class="col-lg-9">
						<div class="forum-post-top">
							<div class="bbp-author-link post-author">
								<?php echo get_avatar( get_the_author_meta( 'ID' ), 50 ); ?>
							</div>
							<div class="forum-post-author">
								<a class="author-name" href="<?php echo bbp_get_topic_author_url(); ?>">
									<?php echo get_the_author_meta( 'display_name' ); ?>
								</a>
								<div class="forum-author-meta">
									<div class="author-badge">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16px" height="15px">
											<path fill-rule="evenodd"  fill="rgb(131, 135, 147)"
												  d="M11.729,12.136 L11.582,12.167 C11.362,12.415 11.125,12.645 10.869,12.857 L14.999,12.857 C15.134,12.857 15.255,12.944 15.307,13.077 C15.359,13.211 15.331,13.365 15.235,13.467 L14.488,14.268 C14.053,14.733 13.452,15.000 12.838,15.000 L2.495,15.000 C1.872,15.000 1.286,14.740 0.845,14.268 L0.098,13.467 C0.002,13.365 -0.026,13.211 0.026,13.077 C0.077,12.944 0.199,12.857 0.334,12.857 L4.463,12.857 C2.928,11.585 2.000,9.630 2.000,7.499 L2.000,6.785 C2.000,6.194 2.449,5.713 3.000,5.713 L12.333,5.713 C12.885,5.713 13.333,6.194 13.333,6.785 L13.333,7.343 C13.869,7.160 14.736,6.973 15.355,7.400 C15.783,7.696 16.000,8.209 16.000,8.928 C16.000,11.239 11.903,12.100 11.729,12.136 ZM14.994,8.002 C14.557,7.698 13.715,7.941 13.294,8.113 C13.197,9.261 12.837,10.339 12.255,11.269 C13.480,10.911 15.333,10.116 15.333,8.928 C15.333,8.462 15.223,8.158 14.994,8.002 ZM10.261,4.419 C10.376,4.573 10.353,4.798 10.209,4.921 C10.148,4.974 10.074,4.999 10.001,4.999 C9.903,4.999 9.807,4.954 9.740,4.865 C9.198,4.139 9.198,3.002 9.741,2.277 C10.086,1.816 10.086,1.040 9.742,0.580 C9.627,0.426 9.650,0.201 9.794,0.078 C9.937,-0.044 10.146,-0.020 10.263,0.134 C10.805,0.860 10.805,1.996 10.263,2.722 C9.917,3.183 9.917,3.959 10.261,4.419 ZM8.259,4.419 C8.373,4.573 8.350,4.798 8.207,4.921 C8.145,4.974 8.071,4.999 7.999,4.999 C7.901,4.999 7.804,4.954 7.738,4.865 C7.195,4.139 7.195,3.002 7.738,2.277 C8.082,1.816 8.082,1.040 7.739,0.580 C7.624,0.426 7.647,0.201 7.791,0.078 C7.935,-0.045 8.145,-0.020 8.259,0.134 C8.802,0.860 8.802,1.996 8.259,2.722 C7.915,3.183 7.915,3.959 8.259,4.419 ZM6.261,4.418 C6.376,4.572 6.353,4.797 6.210,4.920 C6.148,4.973 6.074,4.999 6.001,4.999 C5.903,4.999 5.807,4.953 5.741,4.865 C5.198,4.139 5.198,3.002 5.741,2.276 C6.085,1.815 6.085,1.039 5.742,0.580 C5.627,0.426 5.650,0.201 5.794,0.078 C5.937,-0.046 6.147,-0.020 6.262,0.133 C6.804,0.859 6.804,1.996 6.262,2.721 C5.918,3.182 5.918,3.959 6.261,4.418 Z"/>
										</svg>
										<span>
											<?php
											bbp_topic_author_role(
												[
													'topic_id' => get_the_ID(),
													'before'   => '',
													'after'    => '',
												]
											);
											?>
										</span>
									</div>
									<div class="author-badge">
										<i class="icon_calendar"></i>
										<?php bbp_topic_post_date( get_the_ID() ); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="action-button-container">
							<?php
							bbp_topic_subscription_link(
								[
									'before'      => '',
									'after'       => '',
									'unsubscribe' => esc_html__( 'Subscribed', 'docly' ),
								]
							);
							?>
						</div>
					</div>
				</div>

				<!-- Forum post content -->
				<div class="q-title">
					<span class="question-icon" title="Question">Q:</span>
					<h1>
						<?php
						the_title();
						do_action( 'bbpc-resolved-topics' );
						?>
					</h1>
				</div>
				<div class="forum-post-content">
					<div class="content">
						<?php bbp_topic_content(); ?>
					</div>
					<div class="forum-post-btm">
						<?php if ( bbp_get_topic_tag_list( get_the_ID() ) ) : ?>
							<div class="taxonomy forum-post-tags">
								<?php
								bbp_topic_tag_list(
									'',
									[
										'before' => '<i class="icon_tags_alt"></i> <strong>' . esc_html__( 'Tagged:', 'docly' ) . '</strong>&nbsp; <span class="tags">',
										'after'  => '</span>',
									]
								);
								?>
							</div>
						<?php endif; ?>
						<div class="taxonomy forum-post-cat">
							<?php echo get_the_post_thumbnail( bbp_get_topic_forum_id(), 'docly_20x20' ); ?>
							<a href="<?php bbp_forum_permalink( bbp_get_topic_forum_id() ); ?>">
								<?php echo bbp_get_topic_forum_title(); ?>
							</a>
						</div>
					</div>
					<div class="action-button-container action-btns">
						<?php if ( is_user_logged_in() ) : ?>
							<ul class="list-unstyled d-flex bbp-admin-links">
								<?php
								$admin_link_args = [
									'before' => '<li>',
									'after'  => '</li>',
									'sep'    => '</li><li>',
								];
								bbp_topic_admin_links( $admin_link_args );
								?>
							</ul>
						<?php endif; ?>
						<?php
						bbp_topic_favorite_link(
							[
								'before' => '',
							]
						);
						?>
					</div>
				</div>

				<?php if ( bbp_has_replies() ) : ?>

					<?php bbp_get_template_part( 'loop', 'replies' ); ?>

				<?php endif; ?>

				<?php bbp_get_template_part( 'form', 'reply' ); ?>

				<?php bbp_get_template_part( 'alert', 'topic-lock' ); ?>

				<?php do_action( 'bbp_template_after_single_topic' ); ?>

			<?php endif; ?>

		</div>
		<!-- /.col-lg-8 -->

		<?php get_sidebar( 'forum' ); ?>
		<!-- /.col-lg-4 -->
	</div>
</section>
