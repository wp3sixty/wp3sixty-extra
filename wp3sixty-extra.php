<?php
/**
 * Plugin Name: Wp3sixty-extra
 * Version: 0.1-alpha
 * Description: wp3sixty extra CPTs
 * Author: wp3sixty
 * Author URI: wp3sixty.com
 * Plugin URI: wp3sixty.com
 * Text Domain: wp3sixty-extra
 * Domain Path: /languages
 * @package Wp3sixty-extra
 */

if ( ! defined( 'WP3SIXTY_EXTRA_PATH' ) ) {
	define( 'WP3SIXTY_EXTRA_PATH', plugin_dir_path( __FILE__ ) );
}

require_once( WP3SIXTY_EXTRA_PATH . 'include/class-wp-3sixty-core.php' );
require_once( WP3SIXTY_EXTRA_PATH . 'include/class-wp-3sixty-carousel.php' );
require_once( WP3SIXTY_EXTRA_PATH . 'include/class-wp-3sixty-metabox.php' );


if ( ! function_exists( 'wp3sixty_load_core' ) ) {
	function wp3sixty_load_core() {
		Wp_3sixty_Core::getInstance();
		new WP_3sixty_Carousel();
	}

	add_action( 'plugins_loaded', 'wp3sixty_load_core' );
}
