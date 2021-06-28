<?php

/*
 *	NM: Team members post type class
 */
class NM_Team_Members extends NM_Post_Types {
	
	
	/* Init */
	function init() {
		// Add hooks
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'save_post', array( $this, 'meta_box_save' ) );
	}
	
	
	/* Register post type */
	function register_post_type() {
		$labels = array(
			'name'					=> __( 'Team', 'nm-post-types' ),
			'singular_name'			=> __( 'Team Member', 'nm-post-types' ),
			'add_new' 				=> __( 'Add New', 'nm-post-types' ),
			'add_new_item' 			=> __( 'Add New Team Member', 'nm-post-types' ),
			'edit_item' 			=> __( 'Edit Team Member', 'nm-post-types' ),
			'new_item' 				=> __( 'New Team Member', 'nm-post-types' ),
			'view_item' 			=> __( 'View Team Member', 'nm-post-types' ),
			'search_items' 			=> __( 'Search Team Members', 'nm-post-types' ),
			'not_found' 			=> __( 'No team members have been added yet', 'nm-post-types' ),
			'not_found_in_trash'	=> __( 'Nothing found in Trash', 'nm-post-types' ),
			'parent_item_colon' 	=> ''
		);
		
		$args = array(
			'labels'				=> $labels,
			'public'				=> true,
			'exclude_from_search'	=> true,
			'publicly_queryable'	=> false,
			'show_in_admin_bar'		=> false,
			//'menu_position'			=> '70'
			'menu_icon'				=> 'dashicons-groups',
			'supports'				=> array( 'title', 'editor', 'thumbnail' ),
			'register_meta_box_cb'	=> array( $this, 'meta_box_register' )
		);
		
		register_post_type( 'team', $args );
	}
	
	
	/* Meta box: Register */
	function meta_box_register() {
		add_meta_box(
			'nm-team-member-meta',
			__( 'Details', 'nm-post-types' ),
			array( $this, 'meta_box_output' ),
			'team',
			'normal'
		);
	}
	
	
	/* Meta box: Fields */
	function meta_box_fields() {
		$meta_fields = array(
			__( 'Status', 'nm-post-types' )	=> array( 'name' => 'nm_team_member_status', 'description' => __( "Enter team member's status.", 'nm-post-types' ) ),
			'Facebook' 						=> array( 'name' => 'nm_team_member_facebook', 'description' => __( "Enter team member's Facebook profile URL.", 'nm-post-types' ) ),
			'Instagram' 					=> array( 'name' => 'nm_team_member_instagram', 'description' => __( "Enter team member's Instagram profile URL.", 'nm-post-types' ) ),
			'Twitter' 						=> array( 'name' => 'nm_team_member_twitter', 'description' => __( "Enter team member's Twitter profile URL.", 'nm-post-types' ) ),
			'Google+' 						=> array( 'name' => 'nm_team_member_google_plus', 'description' => __( "Enter team member's Google+ profile URL.", 'nm-post-types' ) ),
			'LinkedIn' 						=> array( 'name' => 'nm_team_member_linkedin', 'description' => __( "Enter team member's LinkedIn profile URL.", 'nm-post-types' ) ),
			'Vimeo' 						=> array( 'name' => 'nm_team_member_vimeo', 'description' => __( "Enter team member's Vimeo profile URL.", 'nm-post-types' ) ),
			'YouTube' 						=> array( 'name' => 'nm_team_member_youtube', 'description' => __( "Enter team member's YouTube profile URL.", 'nm-post-types' ) ),
            'E-mail'                        => array( 'name' => 'nm_team_member_email', 'description' => __( "Enter team member's e-mail address.", 'nm-post-types' ) ),
            'Website' 						=> array( 'name' => 'nm_team_member_website', 'description' => __( "Enter team member's website URL.", 'nm-post-types' ) )
		);
		
		return $meta_fields;
	}
	
	
	/* Meta box: Output */
	function meta_box_output( $post ) {
		// Meta fields
		$meta_fields = $this->meta_box_fields();
		
		// Nonce field for validation in "nm_team_save_meta_box_data()"
		wp_nonce_field( 'nm-theme', 'nm_nonce_team_meta_box' );
		
		// Get saved post meta
		$post_meta = get_post_meta( $post->ID, 'nm_team_post_type_meta', true );
		
		$output = '<ul>';
		
		foreach ( $meta_fields as $field => $field_data ) {
			$value = ( isset( $post_meta[$field_data['name']] ) ) ? $post_meta[$field_data['name']] : '';
			
			$output .= '
				<li>
					<div class="nm-wp-meta-label">
						<label for="' . $field_data['name'] . '">' . $field . '</label>
					</div>
					<div class="nm-wp-meta-input">
						<input type="text" name="' . $field_data['name'] . '" value="' . $value . '" size="30" />
						<p class="nm-meta-description">' . $field_data['description'] . '</p>
					</div>
				</li>';
		}
		
		$output .= '</ul>';
		
		echo '<div class="nm-wp-meta">' . $output . '</div>';
	}
	
	
	/* Meta box: Save data */
	function meta_box_save( $post_id ) {
		// Verify this came from our meta box with proper authorization (save_post action can be triggered at other times)
		if ( ! $this->meta_box_verify_save_action( $post_id, 'nm_nonce_team_meta_box' ) ) {
			return;
		}
		
		$meta_fields = $this->meta_box_fields();
		$post_meta = array();
		
		foreach ( $meta_fields as $field => $field_data ) {
			// Make sure a value is set
			if ( isset( $_POST[$field_data['name']] ) && strlen( $_POST[$field_data['name']] ) > 0 ) {
				// Sanitize user input.
				$post_meta[$field_data['name']] = sanitize_text_field( $_POST[$field_data['name']] );
			}
		}
	
		// Update the meta field in the database.
		update_post_meta( $post_id, 'nm_team_post_type_meta', $post_meta );
	}


}


$NM_Team_Members = new NM_Team_Members();
$NM_Team_Members->init();

