<?php
$opt = get_option( 'docly_opt' );
$action_btn_link = function_exists('get_field') ? get_field('action_btn_link') : '';

$is_menu_btn = !empty($opt['is_menu_btn']) ? $opt['is_menu_btn'] : '';

// Button Title
$btn_title = '';
if ( !empty($action_btn_link['title']) ) {
	$btn_title = $action_btn_link['title'];
} else {
	$btn_title = ! empty( $opt['menu_btn_label'] ) ? $opt['menu_btn_label'] : '';
}

// Button URL
$btn_url = '#';
if ( !empty($action_btn_link['url']) ) {
    $btn_url = $action_btn_link['url'];
} else {
	$btn_url = !empty($opt['menu_btn_url']) ? $opt['menu_btn_url'] : '';
}

// Button Target
$btn_target = '';
if ( !empty($action_btn_link['target']) ) {
    $btn_target = "target='{$action_btn_link['target']}'";
} else {
    $btn_target = !empty($opt['menu_btn_target']) ? "target='{$opt['menu_btn_target']}'" : '';
}

$button_style = function_exists('get_field') ? get_field('button_style') : '';

$btn_type = '';
if ( !empty($button_style) ) {
    $btn_type = ($button_style == 'outline') ? 'nav_btn_two' : '';
}

if ( is_search() ) {
    $btn_type = 'nav_btn_two';
}

if ( class_exists('bbPress') ) {
	if ( !empty($button_style) ) {
		$btn_type = ($button_style == 'outline') ? 'nav_btn_two' : '';
	}

	if ( is_search() || bbp_is_single_user() ) {
		$btn_type = 'nav_btn_two';
	}
}

if ( $is_menu_btn == '1' && !empty($btn_title) ) :
    ?>
    <a class="nav_btn <?php echo esc_attr($btn_type) ?>" href="<?php echo esc_url($btn_url) ?>" <?php echo wp_kses_post($btn_target) ?>>
        <?php echo esc_html($btn_title) ?>
    </a>
    <?php
endif;