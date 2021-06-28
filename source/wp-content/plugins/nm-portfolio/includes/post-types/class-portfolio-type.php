<?php

/*
 *	NM: Portfolio post type class
 */
class NM_Portfolio_Type extends NM_Portfolio {
	
    
	public $portfolio_slug = '';
    public $portfolio_taxonomy_slug = '';
    
    
	/* Init */
	function init() {
		// Post type and taxonomy hooks
		add_action( 'init', array( $this, 'register_post_type' ) );
        add_action( 'init', array( $this, 'register_taxonomy' ) );
		add_action( 'save_post', array( $this, 'meta_box_save' ) );
        
        // Archive template hook
        add_filter( 'archive_template', array( $this, 'archive_template' ) );
        // Single item template hook
        add_filter( 'single_template', array( $this, 'single_item_template' ) );
        
        // Modify portfolio archive query hook
        add_action( 'pre_get_posts', array( $this, 'modify_portfolio_query' ) );
	}
	
    
	/* Register post type */
	function register_post_type() {
		global $nm_theme_options;
		
        $this->portfolio_slug = ( strlen( $nm_theme_options['portfolio_permalink'] ) > 0 ) ? $nm_theme_options['portfolio_permalink'] : _x( 'portfolio', 'portfolio permalink slug', 'nm-portfolio' );
        
		$labels = array(
			'name'					=> _x( 'Portfolio', 'post type general name', 'nm-portfolio' ),
			'singular_name'			=> __( 'Portfolio Item', 'nm-portfolio' ),
			'add_new' 				=> _x( 'Add New', 'portfolio item', 'nm-portfolio' ),
			'add_new_item' 			=> __( 'Add New Portfolio Item', 'nm-portfolio' ),
			'edit_item' 			=> __( 'Edit Portfolio Item', 'nm-portfolio' ),
			'new_item' 				=> __( 'New Portfolio Item', 'nm-portfolio' ),
			'view_item' 			=> __( 'View Portfolio Item', 'nm-portfolio' ),
			'search_items' 			=> __( 'Search Portfolio', 'nm-portfolio' ),
			'not_found' 			=> __( 'No portfolio items have been added yet', 'nm-portfolio' ),
			'not_found_in_trash'	=> __( 'Nothing found in Trash', 'nm-portfolio' ),
			'parent_item_colon' 	=> ''
		);
		
		$args = array(
			'labels'				=> $labels,
			'public'				=> false,
            'publicly_queryable'    => false,
			'show_ui'				=> true,
			'show_in_nav_menus' 	=> false,
			'show_in_menu' 			=> true,
			'show_in_admin_bar'		=> false,
			'hierarchical' 			=> false,
			'menu_icon'				=> 'dashicons-format-image',
			'supports'				=> array( 'title', 'editor', 'thumbnail' ),
			'register_meta_box_cb'	=> array( $this, 'meta_box_register' ),
			'taxonomies' 			=> array( 'portfolio-category' ),
			'has_archive' 			=> false
		);
		
        // Should portfolio be publicly queryable?
        if ( $nm_theme_options['portfolio_archive'] ) {
            $args['public'] = true;
            $args['publicly_queryable'] = true;
            $args['has_archive'] = true;
            $args['rewrite'] = array(
                'slug' 			=> untrailingslashit( $this->portfolio_slug ),
				'with_front'	=> false,
				'feeds' 		=> true,
                'ep_mask'       => EP_PERMALINK
            );
        }
        
        // Gutenberg editor
        if ( $nm_theme_options['portfolio_gutenberg'] ) {
            $args['show_in_rest'] = true;
        }
        
		register_post_type( 'portfolio', $args );
	}
	
	
	/* Register categories taxonomy */
	function register_taxonomy() {
		global $nm_theme_options;
		
        $this->portfolio_taxonomy_slug = ( strlen( $nm_theme_options['portfolio_category_permalink'] ) > 0 ) ? $nm_theme_options['portfolio_category_permalink'] : _x( 'portfolio-category', 'portfolio category permalink slug', 'nm-portfolio' );
        
		$args = array(
			'label'				 => _x( 'Portfolio Categories', 'category label', 'nm-portfolio' ),
			'public'			 => false,
            'publicly_queryable' => false,
			'show_ui'			 => true,
			'show_in_nav_menus'	 => false,
			'hierarchical'		 => true,
			'query_var'			 => true
		);
		
        // Should portfolio categories be publicly queryable?
        if ( $nm_theme_options['portfolio_archive'] ) {
            $args['public'] = true;
            $args['publicly_queryable'] = true;
            $args['rewrite'] = array(
                'slug'			=> $this->portfolio_taxonomy_slug,
                'with_front'   	=> false,
                'hierarchical'	=> true
            );
        }
        
		register_taxonomy( 'portfolio-category', 'portfolio', $args );
	}
	
	
	/* Meta box: Register */
	function meta_box_register() {
		add_meta_box(
			'nm-portfolio-item-meta',
			__( 'Portfolio Grid', 'nm-portfolio' ),
			array( $this, 'meta_box_output' ),
			'portfolio',
			'side',
			'core'
		);
	}
	
		
	/* Meta box: Fields */
	function meta_box_fields() {
		$meta_fields = array(
			__( 'Overlay Text Color', 'nm-portfolio' ) => array(
				'type'			=> 'select',
				'name' 			=> 'overlay_text_color',
				'description'	=> __( 'Text color for the "Overlay" layout.', 'nm-portfolio' ),
				'values'		=> array(
					'Light'	=> 'light',
					'Gray'	=> 'gray',
					'Dark'	=> 'dark'
				),
				'default'		=> 'gray'
			)/*,
			__( 'Input example', 'nm-portfolio' ) => array(
				'type'			=> 'input',
				'name' 			=> 'input_example',
				'description'	=> __( 'Input example.', 'nm-portfolio' )
			)*/
		);
		
		return $meta_fields;
	}
	
	
	/* Meta box: Output */
	function meta_box_output( $post ) {
		// Meta fields
		$meta_fields = $this->meta_box_fields();
		
		// Nonce field for validation in "nm_portfolio_save_meta_box_data()"
		wp_nonce_field( NM_NAMESPACE, 'nm_nonce_portfolio_meta_box' );
		
		// Get saved post meta
		$post_meta = get_post_meta( $post->ID, 'nm_portfolio_post_type_meta', true );
		
		$output = '<ul>';
		
		// Create meta fields markup
		foreach ( $meta_fields as $field => $field_data ) {
			// Get saved/default value
			if ( isset( $post_meta[$field_data['name']] ) ) {
				$value = $post_meta[$field_data['name']];
			} else {
				$value = ( isset( $field_data['default'] ) ) ? $field_data['default'] : '';
			}
			
			$output .= '
				<li>
					<div class="nm-wp-meta-label">
						<label for="' . $field_data['name'] . '">' . $field . '</label>
					</div>
					<div class="nm-wp-meta-input">';
			
			switch ( $field_data['type'] ) {
				
				// Field: Select
				case 'select' :
					$output .= '<select id="' . $field_data['name'] . '" name="' . $field_data['name'] . '">';
					
					foreach ( $field_data['values'] as $select_title => $select_value ) {
						$selected_attr = ( $value === $select_value ) ? ' selected="' . $select_value . '"' : '';
						
						$output .= '<option value="' . $select_value . '"' . $selected_attr . '>' . $select_title . '</option>';
					}
								
					$output .= '</select>';
				break;
				
				// Field: Input (default)
				default :
					$output .= '<input type="text" name="' . $field_data['name'] . '" value="' . $value . '" size="30" />';
				break;
			
			}
			
			$output .= '
					<p class="nm-meta-description">' . $field_data['description'] . '</p>									
				</div>
			</li>';
		}
		
		$output .= '</ul>';
		
		echo '<div class="nm-wp-meta sidebar">' . $output . '</div>';
	}
	
	
	/* Meta box: Save data */
	function meta_box_save( $post_id ) {
		// Verify this came from our meta box with proper authorization (save_post action can be triggered at other times)
		if ( function_exists( 'nm_verify_save_action' ) && nm_verify_save_action( $post_id, 'nm_nonce_portfolio_meta_box' ) ) {
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
            update_post_meta( $post_id, 'nm_portfolio_post_type_meta', $post_meta );
        }
	}
    
    
    /* Portfolio archive template */
    function archive_template( $archive_template ) {
        global $post;
        
        if ( is_post_type_archive( 'portfolio' ) || is_tax( 'portfolio-category' ) ) {
            // Enqueue portfolio scripts
            $this->enqueue_scripts();
            
            return nm_portfolio_include_dir( 'archive-portfolio.php' );
        }

        return $archive_template;
    }
    
    
    /* Single portfolio item template */
    function single_item_template( $single ) {
        global $post;

        if ( $post->post_type == 'portfolio' ) {
            return nm_portfolio_include_dir( 'single-portfolio.php' );
        }

        return $single;
    }
    
    
    /* Modify portfolio query */
    function modify_portfolio_query( $query ) {
        // Make sure this is the frontend Portfolio query
        if ( $query->is_main_query() && ! is_admin() ) {
            if ( is_post_type_archive( 'portfolio' ) || is_tax( 'portfolio-category' ) ) {
                global $nm_theme_options;

                //$category_slug = str_replace( '_', '-', $nm_theme_options['portfolio_category'] );
                $posts_per_page = ( strlen( $nm_theme_options['portfolio_items'] ) > 0 ) ? intval( $nm_theme_options['portfolio_items'] ) : -1;

                //$query->set( 'post_status', 'publish' );
                //$query->set( 'portfolio-category', $category_slug );
                $query->set( 'posts_per_page', $posts_per_page );
                $query->set( 'ignore_sticky_posts', 1 );
                $query->set( 'orderby', $nm_theme_options['portfolio_order_by'] );
                $query->set( 'order', $nm_theme_options['portfolio_order'] );
            }
        }
    }


}


global $NM_Portfolio_Type;
$NM_Portfolio_Type = new NM_Portfolio_Type();
$NM_Portfolio_Type->init();
