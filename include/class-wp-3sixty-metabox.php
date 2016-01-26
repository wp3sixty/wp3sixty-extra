<?php

// Wireup actions
add_action( 'init', 'wp3sixty_extra_init' );


function wp3sixty_extra_init() {
	add_action( 'add_meta_boxes', 'wp3sixty_extra_add_meta_box', 20, 2 );
	add_action( 'save_post', 'wp3sixty_extra_save_meta_box' );

}

/**
 * Creates custom meta box for Extension post type.
 *
 * post_type : wp3sixty_extension
 *
 * @return add_meta_box()
 */
function wp3sixty_extra_add_meta_box() {

    return add_meta_box(
        'wp3sixty_extra_slug',
        __( 'Plugin Slug', 'wp3sixty' ),
        'wp3sixty_extra_output_meta_box',
        'plugin', 'normal', 'high'
    );
}


/**
 * Displays custom meta box output on Extension post type admin screen.
 *
 * @param Object 	$post
 */
function wp3sixty_extra_output_meta_box( $post ) {
  $current_value = get_post_meta( $post->ID, '_wp3sixty_extension_slug', true );

  echo '<label for="wp3sixty_extension_slug">';
       _e("Plugin Slug", 'wp3sixty' );
  echo '</label> ';
  echo '<input type="text" id="wp3sixty_extension_slug" name="wp3sixty_extension_slug" value="' . esc_attr( $current_value ) . '" size="25" />';

  wp_nonce_field( 'wp3sixty_extra_meta_box_nonce', 'meta_box_nonce' );
}

/**
 * Saves updated value for the meta box to post meta.
 *
 * post_meta : wp3sixty_extension_slug
 *
 * @param int 	$post_id
 */
function wp3sixty_extra_save_meta_box( $post_id ) {

	// return early if autosave.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {

		return;
	}

	// return early if our nonce is not set or does not match.
    if ( ! isset( $_POST['meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['meta_box_nonce'], 'wp3sixty_extra_meta_box_nonce' ) ) {

    	return;
    }

    // return early if user cannot edit the post.
    if ( ! current_user_can( 'edit_post' ) ) {

    	return;
    }

  	$extension_slug = sanitize_title_with_dashes( $_POST['wp3sixty_extension_slug'] );

	// If no extension slug provided, skip plugin api search
	if ( '' == $extension_slug ) {
		return;
	}

	$plugin_data = wp3sixty_ping_plugin_api( $extension_slug );

	// If plugin api call returns an error no plugin was found, bail
	if ( is_wp_error ( $plugin_data ) ) {
		return;
	}

  	if ( isset( $plugin_data->name ) ) {
  		wp3sixty_save_plugin_data( $plugin_data, $post_id );
  	} else {
		$theme_data = wp3sixty_ping_theme_api( $extension_slug );
		if ( is_wp_error($theme_data) ) {
			return;
		}

		if ( isset( $theme_data->name ) ) {
	  		wp3sixty_save_theme_data( $theme_data, $post_id );
	  	}
	}

  	return update_post_meta( $post_id, '_wp3sixty_extension_slug', $extension_slug );
}

function wp3sixty_ping_plugin_api( $extension_slug ) {
	require_once( ABSPATH . '/wp-admin/includes/plugin-install.php' );

	return plugins_api( 'plugin_information', array( 'slug' => wp_unslash( $extension_slug ), 'fields' => array( 'short_description' => true ) ) );
}

function wp3sixty_ping_theme_api( $theme_slug ) {
	require_once( ABSPATH . '/wp-admin/includes/theme.php' );

	return themes_api( 'theme_information', array( 'slug' => wp_unslash( $theme_slug ) ) );
}

function wp3sixty_save_plugin_data( $plugin_data, $post_id ) {

	if ( isset( $plugin_data->sections['description'] ) ) {

		$allowed_tags = array(
		    'a' 	 => array(
		        'href' 	=> array(),
		        'title' => array()
		    ),
		    'br' 	 => array(),
		    'em' 	 => array(),
		    'strong' => array()
		);

		$cleaned_plugin_description = wp_kses( $plugin_data->sections['description'], $allowed_tags );

		// save API response to post meta.
		update_post_meta( $post_id, 'wp3sixty_extension_description', $cleaned_plugin_description );

		// check the current post content
		$current_content = get_post_field( 'post_content', $post_id );

		if ( empty( $current_content ) ) {
			// unhooked save post action to prevent infinite loop.
			remove_action( 'save_post', 'wp3sixty_extra_save_meta_box' );
			// update the post content with plugin description
			wp_update_post( array(
							'ID'           => $post_id,
							'post_content' => $cleaned_plugin_description
			               ) );
			// re-hook the save post action.
			add_action( 'save_post', 'wp3sixty_extra_save_meta_box', 10 );
		}
	}

	// save remaining API responses to post meta.
	// TODO : Need to check these values are set before updating post meta.
	update_post_meta( $post_id, 'wp3sixty_extension_name', sanitize_text_field( $plugin_data->name ) );
	update_post_meta( $post_id, 'wp3sixty_extension_version', sanitize_text_field( $plugin_data->version ) );
	update_post_meta( $post_id, 'wp3sixty_extension_last_updated', sanitize_text_field( $plugin_data->last_updated ) );
	update_post_meta( $post_id, 'wp3sixty_extension_short_description', sanitize_text_field( $plugin_data->short_description ) );
	update_post_meta( $post_id, 'wp3sixty_extension_download_link', sanitize_text_field( $plugin_data->download_link ) );

	return;
}

function wp3sixty_save_theme_data( $theme_data, $post_id ) {

	if ( isset( $theme_data->sections['description'] ) ) {

		$allowed_tags = array(
		    'a' 	 => array(
		        'href' 	=> array(),
		        'title' => array()
		    ),
		    'br' 	 => array(),
		    'em' 	 => array(),
		    'strong' => array()
		);

		$cleaned_theme_description = wp_kses( $theme_data->sections['description'], $allowed_tags );

		// save API response to post meta.
		update_post_meta( $post_id, 'wp3sixty_extension_description', $cleaned_theme_description );

		// check the current post content
		$current_content = get_post_field( 'post_content', $post_id );

		if ( empty( $current_content ) ) {
			// unhooked save post action to prevent infinite loop.
			remove_action( 'save_post', 'wp3sixty_extra_save_meta_box' );
			// update the post content with plugin description
			wp_update_post( array(
							'ID'           => $post_id,
							'post_content' => $cleaned_theme_description
			               ) );
			// re-hook the save post action.
			add_action( 'save_post', 'wp3sixty_extra_save_meta_box', 10 );
		}
	}

	// save remaining API responses to post meta.
	// TODO : Need to check these values are set before updating post meta.
	update_post_meta( $post_id, 'wp3sixty_extension_name', sanitize_text_field( $theme_data->name ) );
	update_post_meta( $post_id, 'wp3sixty_extension_version', sanitize_text_field( $theme_data->version ) );
	update_post_meta( $post_id, 'wp3sixty_extension_last_updated', sanitize_text_field( $theme_data->last_updated ) );
	update_post_meta( $post_id, 'wp3sixty_extension_screenshot_url', sanitize_text_field( $theme_data->screenshot_url ) );
	update_post_meta( $post_id, 'wp3sixty_extension_download_link', sanitize_text_field( $theme_data->download_link ) );

	return;
}
