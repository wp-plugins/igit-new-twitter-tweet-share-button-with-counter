<?php
/*
Plugin Name: IGIT New Twitter Tweet Button
Plugin URI: http://www.hackingethics.com/blog/wordpress-plugins/igit-new-twitter-tweet-share-button-with-counter-wordpress-plugin/
Description: Enable Tweet Share Button on every post and individual post.
Version: 1.4
Author: Ankur Gandhi
Author URI: http://www.hackingethics.com/

License: GNU General Public License (GPL), v3 (or newer)

License URI: http://www.gnu.org/licenses/gpl-3.0.html

Tags:Related posts, related post with images

Copyright (c) 2010 - 2012 Ankur Gandhi. All rights reserved.

 

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of

MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/
if (!defined('ABSPATH')) die("Aren't you supposed to come here via WP-Admin?");
if ( ! defined( 'WP_CONTENT_URL' ) )
      define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
      define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
      define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'IGIT_RPWT_CSS_URL' ) )
      define( 'IGIT_RPWT_CSS_URL', WP_CONTENT_URL. '/plugins/igit-tweet-share-button/css' );
require_once(dirname(__FILE__).'/inc/igit_tsb_init.php');
require_once(dirname(__FILE__).'/inc/admin_tsb_core.php');
if(is_admin())
{
	global $igit_tsb;
	add_action('init', create_function('', 'wp_enqueue_script("jquery");')); // Make sure jQuery is always loaded
	add_action('wp_head', 'igit_tsb_head');
	wp_enqueue_script('jquery-form');   
	add_action('admin_head', 'igit_tsb_action_javascript');

	add_action('wp_ajax_igit_tsb_save_ajax', 'igit_tsb_action_callback');
	add_action('admin_menu', 'igit_tsb_plugin_menu'); // for admin menu inside this after clicking on plugin file function will be called.
}
else
{
	add_action('wp_head', 'igit_tsb_head');
	$igit_tsb_lat = get_option('igit_tsb');
	if($igit_tsb_lat)
	{
		
		$igit_tsb = $igit_tsb_lat;
	}
	else
	{
		$igit_tsb_lat = $igit_tsb;
		
	}
	if($igit_tsb_lat['auto_tsb_show'] == "1")
	{
		if($igit_tsb['igit_tsb_placing'] <> "manually")
		{  
			add_filter('the_content', 'igit_tsb_button_placing');
		}
	}
	
}
?>
