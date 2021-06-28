<?php
	
	// Shortcode: nm_team
	function nm_shortcode_team( $atts, $content = NULL ) {
		global $post, $wp_query;
		
		extract( shortcode_atts( array(
			'orderby'		=> 'name',
			'order'			=> 'asc',
			'columns'		=> '2',
			'items'			=> '',
			'image_style'	=> 'default',
			'ids'			=> ''
		), $atts ) );
		
		// Posts per page
		$posts_per_page = ( strlen( $items ) > 0 ) ? intval( $items ) : -1;
		
		// Post type query
		$args = array(
			'orderby'				=> $orderby,
			'order'					=> $order,
			'post_type' 			=> 'team',
			'post_status' 			=> 'publish',
			'posts_per_page'		=> $posts_per_page,
			'ignore_sticky_posts'	=> 1
		);
		
		// Post/member ID's
		if ( strlen( $ids ) > 0 ) {
			$ids = explode( ',', $ids );
			$args['post__in'] = array_map( 'trim', $ids );
		}
		
		$team = new WP_Query( $args );
		
		$output = '';
		
		while ( $team->have_posts() ) : $team->the_post();
			
			// Get post meta
			$member_meta = get_post_meta( $post->ID, 'nm_team_post_type_meta', true );
			
			// Image
			$member_image_id = get_post_thumbnail_id();
			if ( $member_image_id ) {
				$image_src = wp_get_attachment_image_src( $member_image_id, 'full' );
				$image_title = get_the_title( $member_image_id );
				
				$member_image = '<img src="' . $image_src[0] . '" alt="' . esc_attr( $image_title ) . '" />';
			} else {
				$member_image = '<span class="nm-img-placeholder"></span>';
			}
			
			// Content
			$member_name = '<h2>' . get_the_title() . '</h2>';
			$member_status = '';
			if ( isset( $member_meta['nm_team_member_status'] ) ) {
				$member_status = '<h3>' . $member_meta['nm_team_member_status'] . '</h3>';
				unset( $member_meta['nm_team_member_status'] ); // Remove "status" from meta array (social icons loop below)
			}
			$member_bio = '<div class="wpb_text_column">' . get_the_content() . '</div>';
			
			// Social icons
			if ( $member_meta ) {
				$icon_names = apply_filters( 'nm_team_members_icon_names', array(
					'nm_team_member_facebook'		=> 'facebook',
					'nm_team_member_instagram'		=> 'instagram',
					'nm_team_member_twitter'		=> 'twitter',
					'nm_team_member_google_plus'	=> 'google-plus',
					'nm_team_member_linkedin'		=> 'linkedin',
					'nm_team_member_vimeo'			=> 'vimeo-square',
					'nm_team_member_youtube'		=> 'youtube',
                    'nm_team_member_email'		    => 'envelope',
                    'nm_team_member_website'		=> 'user'
				) );
				
				$social_icons = '<ul class="nm-team-member-social-icons">';
				
				foreach( $member_meta as $name => $value ) {
					$value = ( $name != 'nm_team_member_email' ) ? esc_url( $value ) : 'mailto:' . sanitize_email( $value );
                    
                    $social_icons .= '<li><a href="' . $value . '" target="_blank"><i class="nm-font nm-font-' . $icon_names[$name] . '"></i></a></li>';
				}
				
				$social_icons .= '</ul>';
			} else {
				$social_icons = '';
			}
			
			// Output
			$output .= '
				<li>
					<div class="nm-team-member">
						<div class="nm-team-member-image ' . esc_attr( $image_style ) . '">' .
							$member_image . '
							<div class="nm-team-member-overlay">' .
								$social_icons . '
							</div>
						</div>
						<div class="nm-team-member-content">' .
							$member_name .
							$member_status .
							$member_bio . '
						</div>
					</div>
				</li>';
			
		endwhile;
			
		wp_reset_postdata();
		
		$output = '
			<ul class="nm-team small-block-grid-2 medium-block-grid-2 large-block-grid-' . esc_attr( $columns ) . '">' .
				$output . '
			</ul>';
			
		return $output;
	}
	
	add_shortcode( 'nm_team', 'nm_shortcode_team' );
	