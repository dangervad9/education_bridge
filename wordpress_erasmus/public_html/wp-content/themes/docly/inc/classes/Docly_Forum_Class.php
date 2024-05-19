<?php
/**
 * Docly theme helper functions and resources
 */
if ( !class_exists( 'Docly_Forum_Class' ) ) {
    class Docly_Forum_Class {
        /**
         * Hold an instance of Docly_Forum_Class class.
         * @var Docly_Forum_Class
         */
        protected static $instance = null;

        /**
         * Main Docly_Forum_Class instance.
         * @return Docly_Forum_Class - Main instance.
         */
        public static function instance() {

            if ( null == self::$instance ) {
                self::$instance = new Docly_Forum_Class();
            }

            return self::$instance;
        }
        /**
         * Adds a reference of this object to $instance, populates default strings,
         * @see __construct
         */
        public function __construct() {

        }

        /**
         * Authors Name
         *
         * @return string
         */
        public static function forum_topics_authors() {
            global $wpdb;
            $d_users = [];
            $doclyusers = get_users();

            if ( $doclyusers ) {
                foreach ( $doclyusers as $doclyuser ) {
                    $post_count = count_user_posts( $doclyuser->ID, 'topic' );
                    $d_users[$doclyuser->ID] = $post_count;
                }
                arsort( $d_users );
                $i = 0;
                foreach ( $d_users as $key => $value ) {
                    $i++;

                    $user = get_userdata( $key );
                    $parent_id = get_queried_object_id();
                    //$users_post_count = count_user_posts( $user->ID, 'topic' );
                    $users_post_count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_author = '" . $user->ID . "' AND post_type = 'topic' AND post_status = 'publish' AND post_parent = '" . $parent_id . "' " );
                    $author_posts_url = get_author_posts_url( $key );
                    $post_count = $users_post_count;
                    if ( $post_count > 0 ) {
	                    echo '<div class="userlist">';
	                    echo '<a class="dropdown-item current-user docly-data data-auth" data-nonce="' . wp_create_nonce( 'docly-nonce' ) . '" data-rel="' . $user->display_name . '" data-type="author" data-count="' . $post_count . '" data-parent="' . get_queried_object_id() . '" data-id="' . intval( $user->ID ) . '" href="#' . $user->display_name . '">
                            <img src="' . get_avatar_url( $user->ID ) . '" alt="' . $user->display_name . '">' . $user->display_name . '<span class="count">' . $post_count . '</span>
                          </a>';
	                    echo '</div>';
                    }
                }
            }
        }

        /**
         * Tag Name
         *
         * @return string
         */
        public static function forum_topics_tags() {
            $args = [
                'post_type'           => 'topic',
                'post_parent'         => get_queried_object_id(),
                'post_status'         => 'publish',
                'order'               => 'ASC',
                'orderby'             => 'ID',
                'posts_per_page'      => -1,
            ];
            $doclytags = new WP_Query( $args );

            if ( $doclytags->have_posts() ):
	            $i=1;
                while ( $doclytags->have_posts() ): $doclytags->the_post();
                    global $post;
                    $get_tags = get_the_terms( get_the_ID(), 'topic-tag' );
	                if ( $get_tags ) {
		                foreach ( $get_tags as $tag ) {
                            $post_count = $tag->count;
                            echo '<div class="tagList" id="'.$tag->slug.'">';
                            echo '<a class="dropdown-item docly-data data-tag" data-parent="'.get_queried_object_id().'" data-nonce="'.wp_create_nonce('docly-nonce').'" data-rel="'.$tag->slug.'" data-type="tag" data-count="' . $post_count . '" data-id="' . intval( $tag->term_id ) . '" href="#' . esc_attr( $tag->slug ) . '"><span class="color-purple"></span>' . $tag->name . '</a>';
                            echo '</div>';
		                }
	                }
                    $i++;
                endwhile;
            endif;
        }

        /**
         * Tag Name
         *
         * @return string
         */
        public static function forum_topics_open_close() {
	        $is_queried_obj = is_singular('forum') ? get_queried_object_id() : false;
	        $user_id = is_singular('forum') ? false : bbp_get_displayed_user_field('ID');
            $op = [
                'post_type'   => 'topic',
                'post_parent' => $is_queried_obj,
                'post_status' => 'publish',
                'author'      => $user_id
            ];

            $cl = [
                'post_type'   => 'topic',
                'post_parent' => $is_queried_obj,
                'post_status' => 'closed',
                'author'      => $user_id
            ];

            $open = new WP_Query( $op );
            $closed = new WP_Query( $cl );
            ?>
             <div class="support-info">
                <?php
                if ( in_array('bbp-user-page', get_body_class()) ) :
                    ?>
                    <ul class="support-total-info">
                        <li class="open-ticket">
                            <?php esc_html_e( 'TOPIC', 'docly' ); ?>
                        </li>
                    </ul>
                    <ul class="category-menu">
                        <li> <?php esc_html_e( 'Comments', 'docly' ); ?> </li>
                        <li> <?php esc_html_e( 'Favorites', 'docly' ); ?> </li>
                    </ul>
                    <?php
                else :
                    ?>
                    <ul class="support-total-info">
                        <li class="open-ticket">
                            <i class="icon_info_alt"></i>
                            <a href="#open" class="loading open-data" data-nonce="<?php echo wp_create_nonce( 'docly-nonce' );?>" data-type="open" data-userid="<?php echo esc_attr($user_id) ?>" data-parent="<?php echo esc_attr($is_queried_obj); ?>">
                                <?php echo esc_html($open->found_posts) . esc_html__( ' Open', 'docly' ); ?>
                            </a>
                        </li>
                        <li class="close-ticket">
                            <i class="icon_check"></i>
                            <a href="#closed" class="open-data" data-nonce="<?php echo wp_create_nonce( 'docly-nonce' );?>" data-type="closed" data-parent="<?php echo esc_attr($is_queried_obj); ?>" data-userid="<?php echo esc_attr($user_id) ?>">
                                <?php echo esc_html($closed->found_posts) . esc_html__( ' Closed', 'docly' ); ?>
                            </a>
                        </li>
                        <li class="close-ticket reset-btn reset-none">
                            <i class="icon_refresh"></i>
                            <a href="#open" class="open-data" data-nonce="<?php echo wp_create_nonce( 'docly-nonce' );?>" data-type="open" data-parent="<?php echo esc_attr($is_queried_obj); ?>" data-userid="<?php echo esc_attr($user_id) ?>">
                                <?php esc_html_e( 'Reset', 'docly' ); ?>
                            </a>
                        </li>
                    </ul>
                    <?php
                endif;
                ?>
            </div>
            <?php
        }
    }
}

/**
 * Instance of Docly_Forum_Class class
 */
function Docly_Forum() {
    return Docly_Forum_Class::instance();
}