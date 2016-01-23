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


require_once( plugin_dir_path( __FILE__ ) . 'include/class-wp-3sixty-core.php' );
require_once( plugin_dir_path( __FILE__ ) . 'include/class-wp-3sixty-carousel.php' );

if ( ! function_exists( 'wp3sixty_load_core' ) ) {
	function wp3sixty_load_core() {
		Wp_3sixty_Core::getInstance();
		new WP_3sixty_Carousel();
	}
	add_action( 'plugins_loaded', 'wp3sixty_load_core' );
}
