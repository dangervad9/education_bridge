<?php

namespace SocialV\Utility\Nav_Walker;

use SocialV\Utility\Component_Interface;

class Component extends \Walker_Nav_Menu implements Component_Interface
{
    public $submenu_unique_id = '';
    public function get_slug(): string
    {
        return 'nav_walker';
    }

    public function initialize()
    {
    }
    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul id=\"$this->submenu_unique_id\"  class=\"sub-nav collapse\">\n";
    }

    public function end_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    /**
     * @see Walker::start_el()
     */
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = ($depth) ? str_repeat($t, $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'nav-item';

        // set active class for current nav menu item
        if ($item->current == 1) {
            $classes[] = 'active';
        }

        // set active class for current nav menu item parent
        if (in_array('current-menu-parent',  $classes)) {
            $classes[] = 'active';
        }

        /**
         * Filters the arguments for a single nav menu item.
         */
        $args = apply_filters('nav_menu_item_args', $args, $item, $depth);

        // add a divider in dropdown menus
        if (strcasecmp($item->attr_title, 'divider') == 0 && $depth === 1) {
            $output .= $indent . '<li class="divider">';
        } else if (strcasecmp($item->title, 'divider') == 0 && $depth === 1) {
            $output .= $indent . '<li class="divider">';
        } else {
            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));

            if (in_array('menu-item-has-children', $classes)) {
                if ($depth === 1) {
                    $class_names = $class_names ? ' class="mega-menucolumn ' . esc_attr($class_names) . '"' : '';
                } else {
                    $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
                }
            } else {
                $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
            }

            $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
            $id = $id ? ' id="' . esc_attr($id) . '"' : '';

            $output .= $indent . '<li' . $id . $class_names . '>';

            $atts = array();
            $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
            $atts['target'] = !empty($item->target)     ? $item->target     : '';
            $atts['rel']    = !empty($item->xfn)        ? $item->xfn        : '';

            if (in_array('menu-item-has-children', $classes)) {
                $atts['href']   = '#dropdown-' . $item->ID;
                $atts['data-bs-toggle']    = 'collapse';
                $atts['class']            = 'nav-link collapsed';
                $atts['role'] = 'button';
                $atts['aria-expanded'] = 'false';
                $this->submenu_unique_id = 'dropdown-' . $item->ID;
            } else {
                $atts['href']   = !empty($item->url) ? $item->url  : '';
                $atts['class']            = 'nav-link';
            }

            $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

            $attributes = '';
            foreach ($atts as $attr => $value) {
                if (!empty($value)) {
                    $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            if (!in_array('icon-only', $classes)) {

                $title = apply_filters('the_title', $item->title, $item->ID);

                $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);
            }

            $menu_icon = get_post_meta($item->ID, '_select_icon', true);
            $title = '';
            $img = wp_get_attachment_image_url($menu_icon);
            $img_alt = get_post_meta($menu_icon, '_wp_attachment_image_alt', true);
            $item_tooltip = "data-bs-toggle=tooltip data-bs-placement=right";
            global $wp_filesystem;
            require_once ABSPATH . '/wp-admin/includes/file.php';
            WP_Filesystem();
            if (!empty($menu_icon)) :
                $img = explode("?", $img)[0];
                $img_type = wp_check_filetype($img);
                if ($img_type['ext'] == 'svg') {
                    $title .= "<i class=icon " . $item_tooltip . " title='" . esc_attr($item->title) . "'>" . $wp_filesystem->get_contents($img) . "</i>";
                } else {
                    if (in_array($img_type['ext'], ['png', 'jpg', 'jpeg'])) {
                        $title .= "<i class=icon " . $item_tooltip . " title='" . esc_attr($item->title) . "'><img src=" . esc_url($img) . "  alt=" . esc_attr($img_alt) . " loading=lazy></i>";
                    }
                }
            else :
                $title .= "<i class=icon " . $item_tooltip . "><svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                <g id='Iconly/Bulk/Category'>
                <g id='Category'>
                <path id='Fill 1' opacity='0.4' d='M16.0754 2H19.4614C20.8636 2 21.9999 3.14585 21.9999 4.55996V7.97452C21.9999 9.38864 20.8636 10.5345 19.4614 10.5345H16.0754C14.6731 10.5345 13.5369 9.38864 13.5369 7.97452V4.55996C13.5369 3.14585 14.6731 2 16.0754 2Z' fill='currentColor'/>
                <path id='Combined Shape' fill-rule='evenodd' clip-rule='evenodd' d='M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z' fill='currentColor'/>
                </g>
                </g>
                </svg></i>";
            endif;
            $title .= '<span class="menu-title">' . $item->title . '</span>';

            $item_output = $args->before;
            $item_output .= '<a' . $attributes . '>';

            $item_output .= $args->link_before . $title . $args->link_after;

            if (in_array('menu-item-has-children', $classes)) {
                $item_output .= '<i class="right-icon">
                <span class="icon-menu-aerrow-right"></span>
                </i>';
            }

            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }
    }

    /**
     * Ends the element output, if needed.
     *
     */
    public function end_el(&$output, $item, $depth = 0, $args = array())
    {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $output .= "</li>{$n}";
    }
}
