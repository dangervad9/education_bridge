<?php

/**
 * SocialV\Utility\Actions\Component class
 *
 * @package socialv
 */

namespace SocialV\Utility\Actions;

use SocialV\Utility\Component_Interface;
use SocialV\Utility\Templating_Component_Interface;

/**
 * Class for managing comments UI.
 *
 * Exposes template tags:
 * * `socialv()->the_comments( array $args = array() )`
 *
 * @link https://wordpress.org/plugins/amp/
 */
class Component implements Component_Interface, Templating_Component_Interface
{
	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string
	{
		return 'actions';
	}
	public function initialize()
	{
	}
	/**
	 * Gets template tags to expose as methods on the Template_Tags class instance, accessible through `socialv()`.
	 *
	 * @return array Associative array of $method_name => $callback_info pairs. Each $callback_info must either be
	 *               a callable or an array with key 'callable'. This approach is used to reserve the possibility of
	 *               adding support for further arguments in the future.
	 */
	public function template_tags(): array
	{
		return array(
			'socialv_get_blog_readmore_link' => array($this, 'socialv_get_blog_readmore_link'),
			'socialv_get_blog_readmore' => array($this, 'socialv_get_blog_readmore'),
			'socialv_get_comment_btn' => array($this, 'socialv_get_comment_btn'),
		);
	}

	//** Blog Read More Button Link **//
	public function socialv_get_blog_readmore_link($link, $label = "Read More")
	{
		echo '<div class="blog-button">		
				<a class="socialv-button socialv-button-link" href="' . esc_url($link) . '">' . esc_html($label) . ' 
					
				</a>
			</div>';
	}

	//** Blog Read More Button **//
	public function socialv_get_blog_readmore($link, $label)
	{
		echo '<div class="blog-button">
				<a class="socialv-button" href="' . esc_url($link) . '">' . esc_html($label) . '</a>
			</div>';
	}
	//** Submit Button **//
	public function socialv_get_comment_btn($tag = 'a',  $label = "Post Comment", $attr = array())
	{

		$classes = isset($attr['class']) ? $attr['class'] : '';

		$attr_render = '';
		$attr_render = ($tag == 'button') ? 'type=submit ' : '';

		foreach ($attr as $key => $value) {
			$attr_render .= $key . '=' . $value . ' ';
		}

		return '<' . tag_escape($tag) . '  class="socialv-button ' . esc_attr($classes) . '  " ' . esc_attr($attr_render) . '  >
				' . esc_html($label) .
			' </' . tag_escape($tag) . '>';
	}
	
}
