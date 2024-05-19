<?php
$opt = get_option( 'docly_opt' );
$ancestors = array();
$root = $parent = false;
if ( $post->post_parent ) {
    $ancestors = get_post_ancestors($post->ID);
    $root = count($ancestors) - 1;
    $parent = $ancestors[$root];
} else {
    $parent = $post->ID;
}

// var_dump( $parent, $ancestors, $root );
$walker = new Docly_Walker_Docs();
$children = wp_list_pages(array(
    'title_li' => '',
    'order' => 'menu_order',
    'child_of' => $parent,
    'echo' => false,
    'post_type' => 'docs',
    'walker' => $walker,
));
?>
<div class="mobile_main_menu sticky">
    <div class="container">
        <div class="mobile_menu_left">
            <button type="button" class="navbar-toggler mobile_menu_btn">
                <span class="menu_toggle ">
                    <span class="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </span>
            </button>
            <?php Docly_helper()->logo(); ?>
        </div>
        <div class="mobile_menu_right">
           <?php get_template_part( 'template-parts/header-elements/action-button' ); ?>
        </div>
    </div>
</div>
<div class="click_capture"></div>
<div class="side_menu">
    <div class="mobile_menu_header">
        <div class="close_nav">
            <i class="arrow_left"></i>
            <i class="icon_close"></i>
        </div>
        <?php if ( !empty($opt['sticky_logo']['url']) ) : ?>
            <div class="mobile_logo">
                <a href="<?php echo esc_url(home_url('/')) ?>">
                    <img src="<?php echo esc_url($opt['sticky_logo']['url']) ?>" alt="<?php bloginfo('name'); ?>">
                </a>
            </div>
        <?php endif; ?>
    </div>
    <div class="mobile_nav_wrapper">
        <nav class="mobile_nav_top">
            <?php
            if ( has_nav_menu('main_menu') ) {
                wp_nav_menu( array (
                    'menu' => 'main_menu',
                    'theme_location' => 'main_menu',
                    'container' => null,
                    'menu_class' => "navbar-nav menu ml-auto",
                    'walker' => new Docly_Mobile_Nav_Walker(),
                    'depth' => 4
                ));
            }
            ?>
        </nav>
        <div class="mobile_nav_bottom">
            <aside class="doc_left_sidebarlist">
                <h2 class="doc-title">
                    <?php echo get_post_field( 'post_title', $parent, 'display' ); ?>
                </h2>
                <div class="scroll">
                    <ul class="list-unstyled nav-sidebar">
                        <?php
                        echo wp_list_pages(array(
                            'title_li' => '',
                            'order' => 'menu_order',
                            'child_of' => $parent,
                            'echo' => false,
                            'post_type' => 'docs',
                            'walker' => $walker,
                        ));
                        ?>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</div>