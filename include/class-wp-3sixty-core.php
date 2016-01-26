<?php
/**
 * Created by PhpStorm.
 * User: spock
 * Date: 24/1/16
 * Time: 12:00 AM
 */

if ( ! class_exists( 'Wp_3sixty_Core' ) ) {
	class Wp_3sixty_Core {

		private static $instance;

		public static function getInstance() {
			if ( null === static::$instance ) {
				static::$instance = new static();
			}

			return static::$instance;
		}

		protected function __construct() {
			add_action( 'init', array( $this, 'theme_cpt_register' ), 0 );
			add_action( 'init', array( $this, 'plugin_cpt_register' ), 0 );

			add_filter( 'template_include', array( $this, 'plugin_template' ), 99 );

		}

		// Register Custom Post Type
		function plugin_cpt_register() {

			$labels = array(
				'name'                  => _x( 'Plugins', 'plugins', 'wp3sixty-extra' ),
				'singular_name'         => _x( 'Plugin', 'plugin', 'wp3sixty-extra' ),
				'menu_name'             => __( 'Plugin', 'wp3sixty-extra' ),
				'name_admin_bar'        => __( 'Plugin', 'wp3sixty-extra' ),
				'archives'              => __( 'Plugin Archives', 'wp3sixty-extra' ),
				'parent_item_colon'     => __( 'Parent Plugin:', 'wp3sixty-extra' ),
				'all_items'             => __( 'All Plugins', 'wp3sixty-extra' ),
				'add_new_item'          => __( 'Add New Plugin', 'wp3sixty-extra' ),
				'add_new'               => __( 'Add New', 'wp3sixty-extra' ),
				'new_item'              => __( 'New Plugin', 'wp3sixty-extra' ),
				'edit_item'             => __( 'Edit Plugin', 'wp3sixty-extra' ),
				'update_item'           => __( 'Update Plugin', 'wp3sixty-extra' ),
				'view_item'             => __( 'View Plugin', 'wp3sixty-extra' ),
				'search_items'          => __( 'Search Plugin', 'wp3sixty-extra' ),
				'not_found'             => __( 'Not found', 'wp3sixty-extra' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'wp3sixty-extra' ),
				'featured_image'        => __( 'Featured Image', 'wp3sixty-extra' ),
				'set_featured_image'    => __( 'Set featured image', 'wp3sixty-extra' ),
				'remove_featured_image' => __( 'Remove featured image', 'wp3sixty-extra' ),
				'use_featured_image'    => __( 'Use as featured image', 'wp3sixty-extra' ),
				'insert_into_item'      => __( 'Insert into plugin', 'wp3sixty-extra' ),
				'uploaded_to_this_item' => __( 'Uploaded to this plugin', 'wp3sixty-extra' ),
				'items_list'            => __( 'Items plugin', 'wp3sixty-extra' ),
				'items_list_navigation' => __( 'Plugin list navigation', 'wp3sixty-extra' ),
				'filter_items_list'     => __( 'Filter plugins list', 'wp3sixty-extra' ),
			);
			$args   = array(
				'label'               => __( 'plugin', 'wp3sixty-extra' ),
				'description'         => __( 'plugin cpt', 'wp3sixty-extra' ),
				'labels'              => $labels,
				'supports'            => array(
					'title',
					'editor',
					'excerpt',
					'author',
					'thumbnail',
					'comments',
					'revisions',
					'custom-fields',
					'post-formats',
				),
				'taxonomies'          => array( 'category', 'post_tag' ),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 5,
				'menu_icon'           => 'dashicons-hammer',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'page',
			);
			register_post_type( 'plugin', $args );

		}

		function theme_cpt_register() {

			$labels = array(
				'name'                  => _x( 'Themes', 'themes', 'wp3sixty-extra' ),
				'singular_name'         => _x( 'Theme', 'theme', 'wp3sixty-extra' ),
				'menu_name'             => __( 'Theme', 'wp3sixty-extra' ),
				'name_admin_bar'        => __( 'Theme', 'wp3sixty-extra' ),
				'archives'              => __( 'Theme Archives', 'wp3sixty-extra' ),
				'parent_item_colon'     => __( 'Parent Theme:', 'wp3sixty-extra' ),
				'all_items'             => __( 'All Themes', 'wp3sixty-extra' ),
				'add_new_item'          => __( 'Add New Theme', 'wp3sixty-extra' ),
				'add_new'               => __( 'Add New', 'wp3sixty-extra' ),
				'new_item'              => __( 'New Theme', 'wp3sixty-extra' ),
				'edit_item'             => __( 'Edit Theme', 'wp3sixty-extra' ),
				'update_item'           => __( 'Update Theme', 'wp3sixty-extra' ),
				'view_item'             => __( 'View Theme', 'wp3sixty-extra' ),
				'search_items'          => __( 'Search Theme', 'wp3sixty-extra' ),
				'not_found'             => __( 'Not found', 'wp3sixty-extra' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'wp3sixty-extra' ),
				'featured_image'        => __( 'Featured Image', 'wp3sixty-extra' ),
				'set_featured_image'    => __( 'Set featured image', 'wp3sixty-extra' ),
				'remove_featured_image' => __( 'Remove featured image', 'wp3sixty-extra' ),
				'use_featured_image'    => __( 'Use as featured image', 'wp3sixty-extra' ),
				'insert_into_item'      => __( 'Insert into theme', 'wp3sixty-extra' ),
				'uploaded_to_this_item' => __( 'Uploaded to this theme', 'wp3sixty-extra' ),
				'items_list'            => __( 'Items theme', 'wp3sixty-extra' ),
				'items_list_navigation' => __( 'Themes list navigation', 'wp3sixty-extra' ),
				'filter_items_list'     => __( 'Filter themes list', 'wp3sixty-extra' ),
			);
			$args   = array(
				'label'               => __( 'theme', 'wp3sixty-extra' ),
				'description'         => __( 'theme cpt', 'wp3sixty-extra' ),
				'labels'              => $labels,
				'supports'            => array(
					'title',
					'editor',
					'excerpt',
					'author',
					'thumbnail',
					'comments',
					'revisions',
					'custom-fields',
					'post-formats',
				),
				'taxonomies'          => array( 'category', 'post_tag' ),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 5,
				'menu_icon'           => 'dashicons-admin-customizer',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'page',
			);
			register_post_type( 'theme', $args );
		}

		private function __clone() {
		}

		private function __wakeup() {
		}

		public function plugin_template( $template ) {
			if ( is_singular( 'plugin' ) ) {
				$new_template = locate_template( array( 'wp3sixty-template/plugin-template.php' ), true );
				if ( '' != $new_template ) {
					return $new_template;
				} else {
					return WP3SIXTY_EXTRA_PATH . 'template/plugin-template.php';
				}
			}
			return $template;
		}

	}
}
