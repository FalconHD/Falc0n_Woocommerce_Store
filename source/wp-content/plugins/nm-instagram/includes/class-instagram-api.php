<?php

class NM_Instagram_API {
    
    /**
	 * @var NM_Instagram_API The reference to *Singleton* instance of this class
	 */
	private static $instance;
    
    
	protected $defaults;
    
    
	private $access_token;
	private $user_id;
	private $api_type;
	private $photo_limit;
	private $username;
	private $business_username;
    
    
    /**
	 * Returns the *Singleton* instance of this class.
	 */
	public static function getInstance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
        
		return self::$instance;
	}
    
    
	/**
	 * Constructor
	 */
    protected function __construct() {
		$this->defaults = array();
        
        $widget_settings = get_option( 'nm_instagram_settings' );
        
        $this->access_token 	 = isset( $widget_settings['access_token'] ) ? $widget_settings['access_token'] : '';
        $this->user_id      	 = isset( $widget_settings['user_id'] ) ? $widget_settings['user_id'] : '';
        $this->business_username = isset( $widget_settings['username'] ) ? $widget_settings['username'] : '';
        $this->api_type     	 = isset( $widget_settings['api_type'] ) ? $widget_settings['api_type'] : 'personal';
        
        // refresh access_token
		$this->refresh_access_token( $widget_settings );
	}
    
    
	/**
	 * Get items/photos
	 */
	public function get_items( $username_hashtag, $image_limit = 12, $transient_time ) {
		$this->photo_limit = intval( $image_limit );
        
        $transient_time = apply_filters( 'nm_instagram_transient_time', $transient_time );
        
        $photos = $this->get_photos( $username_hashtag, $transient_time );

		if ( is_wp_error( $photos ) ) {
            $error = array();
            $error['error'] = $photos->get_error_message();
            
            return $error;
		}
        
        return $photos;
	}
    
    
    
    /** Code below from "../inc/class-instagram-widget.php" file of "Meks Easy Photo Feed Widget v1.2.0" plugin: https://wordpress.org/plugins/meks-easy-instagram-widget/ : **/
    
    
    
	/**
	 * Check is user authenticated
	 *
	 * @return bool
	 */
	public function is_authorized(){

		return !empty($this->access_token);
	}
    
    
	/**
	 * Get photos form Instagram base on username or hashtag with transient caching for one day
	 *
	 * @since 1.0.0
	 *
	 * @param string $username_or_hashtag Searched username or hashtag
	 * @param int    $transient_time Time in seconds
	 * @return array  List of all photos sizes with additional information
	 */
	protected function get_photos( $usernames_or_hashtags, $transient_time ) {
		
        $key_name = $usernames_or_hashtags; 
		if ( empty( $usernames_or_hashtags ) ) {
		  $key_name = $this->user_id;
		}
		$transient_key = $this->generate_transient_key( $key_name );

		$cached = get_transient( $transient_key );

		if ( ! empty( $cached ) ) {
            // NM
		  //return $cached;
            $bypass_cache = apply_filters( 'nm_instagram_bypass_cache', false );
            if ( $bypass_cache ) {
                delete_transient( $transient_key );
            } else {
                return $cached;
            }
            // /NM
		}        

		$usernames_or_hashtags = explode( ',', $usernames_or_hashtags );

		if ( $this->is_authorized() && count( $usernames_or_hashtags ) > 1 ) {
			$usernames_or_hashtags = str_replace( '@', '', current( $usernames_or_hashtags ) );
			$usernames_or_hashtags = array( $usernames_or_hashtags );

		}

		$images = array();

		if ( !empty( $usernames_or_hashtags ) && ( $this->api_type == 'business' || !$this->is_authorized() ) ) {

			foreach ( $usernames_or_hashtags as  $username_or_hashtag ) {
	
				$this->username = trim( $username_or_hashtag );
	
				$data = $this->get_instagram_data();
	
				if ( is_wp_error( $data ) ) {
					return $data;
				}
	
				$images[] = $data;
			}

		} else {

			$this->username = !empty( $usernames_or_hashtags ) ? $usernames_or_hashtags = str_replace( '@', '', current( $usernames_or_hashtags ) ) : '';
			$images[] = $this->get_instagram_data();
		}


		$images = array_reduce( $images, 'array_merge', array() );

		usort(
			$images,
			function ( $a, $b ) {
				if ( $a['time'] == $b['time'] ) {
					return 0;
				}
				return ( $a['time'] < $b['time'] ) ? 1 : -1;
			}
		);

		if ( !$this->is_authorized() && $transient_time < ( 12 * HOUR_IN_SECONDS ) ) {
			$transient_time = DAY_IN_SECONDS;
		}
        
        set_transient( $transient_key, $images, $transient_time );
        
		return $images;
	}
    
    
	/**
	 * Generates transient key to cache the results
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	function generate_transient_key( $usernames_or_hashtags ) {

		$transient_key = md5( 'meks_instagram_widget_' . $usernames_or_hashtags );

		return $transient_key;

	}
    
    
	/**
	 * Function to return endpoint URL or simple URL for follow link
	 *
	 * @since 1.0.0
	 *
	 * @param string $searched_term
	 * @param string $proxy
	 * @return string    - URL
	 */
	protected function get_instagram_url() {

		$searched_term = trim( strtolower( $this->username ) );

		switch ( substr( $searched_term, 0, 1 ) ) {
			case '#':
				//$url = 'https://instagram.com/explore/tags/' . str_replace( '#', '', $searched_term );
				$url = 'https://instagram.com/' . str_replace( '#', '', $searched_term );
				break;

			default:
				$url = 'https://instagram.com/' . str_replace( '@', '', $searched_term );
				break;
		}

		return $url;
	}
    
    
	/**
	 * Make remote request base on Instagram endpoints, get JSON and collect all images.
	 *
	 * @since 1.0.0
	 *
	 * @return array  - List of collected images
	 */
	protected function get_instagram_data() {

		if ( !$this->is_authorized() ) {
			return $this->get_instagram_data_without_token();
		}

		return $this->get_instagram_data_with_token();

	}
    
    
    /**
	 * Make request with token.
	 *
	 * @since 1.0.0
	 *
	 * @return array List of collected images
	 */
	protected function get_instagram_data_with_token() {

		if ( 'business' == $this->api_type ) {
			
			$this->username = str_replace( '@', '', $this->username );
			$this->username = str_replace( '#', '', $this->username );
	
			if ( empty($this->username) || $this->username == $this->business_username ) {
				$response = wp_remote_get( 'https://graph.facebook.com/v7.0/' . $this->user_id . '/media?fields=media_url,thumbnail_url,caption,id,media_type,timestamp,username,comments_count,like_count,permalink,children{media_url,id,media_type,timestamp,permalink,thumbnail_url}&limit='. $this->photo_limit .'&access_token=' . $this->access_token );
			} else {
				$response = wp_remote_get( 'https://graph.facebook.com/v7.0/' . $this->user_id . '?fields=business_discovery.username('. $this->username .'){followers_count,media_count,media{media_url,media_type,caption,permalink,timestamp,comments_count,like_count}}&limit='. $this->photo_limit .'&access_token=' . $this->access_token );
			}

		} else {
			$response = wp_remote_get( 'https://graph.instagram.com/'. $this->user_id .'/media?fields=media_url,thumbnail_url,caption,id,media_type,timestamp,username,comments_count,like_count,permalink,children{media_url,id,media_type,timestamp,permalink,thumbnail_url}&limit='. $this->photo_limit .'&access_token='.$this->access_token );
		}

		$data = json_decode( wp_remote_retrieve_body( $response ) );

		if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) ) {
			//NM $error_message = __('Connection error. Connection fail between instagram and your server. Please try again', 'meks-easy-instagram-widget');
            $error_message = __('Connection error. Connection fail between instagram and your server. Please try again', 'nm-instagram');
			if ( isset($data->error->message) ) {
				$error_message = str_replace( '(#100)', 'Error message: ', $data->error->message );
			}
			return new WP_Error( 'invalid-token', esc_html( $error_message ) );
		}

		//$data = json_decode( wp_remote_retrieve_body( $response ) );
		//print_r($data);

		$images = $this->parse_instagram_images_with_token( $data );

		if ( empty( $images ) ) {
			//NM return new WP_Error( 'no_images', esc_html__( 'Images not found. This may be a temporary problem. Please try again soon.', 'meks-easy-instagram-widget' ) );
            return new WP_Error( 'no_images', esc_html__( 'Images not found. This may be a temporary problem. Please try again soon.', 'nm-instagram' ) );
		}

		return $images;

	}
    
    
    /**
	 * Make request without token
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	protected function get_instagram_data_without_token() {

		$url = $this->get_instagram_url();

		$request = wp_remote_get( $url );
		$body    = wp_remote_retrieve_body( $request );

		$shared = explode( 'window._sharedData = ', $body );
        // NM: Prevent PHP notice if invalid username
        if ( ! isset( $shared[1] ) ) {
            return new WP_Error( 'blocked', esc_html__( 'Instagram has returned empty data.', 'nm-instagram' ) );
        }
        // /NM
		$json   = explode( ';</script>', $shared[1] );
		$data   = json_decode( $json[0], true );


		//print_r($data);

		if ( empty( $data ) ) {
			//NM return new WP_Error( 'blocked',  sprintf( esc_html__('Instagram has returned empty data. Please authorize your Instagram account in the %s plugin settings %s.', 'meks-easy-instagram-widget' ), '<a href="'.esc_url( admin_url( 'options-general.php?page=meks-instagram' ) ).'">', '</a>') );
            return new WP_Error( 'blocked',  sprintf( esc_html__('Instagram has returned empty data. Please %sauthorize your Instagram account%s.', 'nm-instagram' ), '<a href="'.esc_url( admin_url( 'options-general.php?page=nm-instagram' ) ).'">', '</a>') );
		}

		if ( isset( $data['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ) {
			$images = $data['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
		} elseif ( isset( $data['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'] ) ) {
			$images = $data['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
		} else {
			//NM return new WP_Error( 'blocked',  sprintf( esc_html__('Instagram has returned empty data. Please authorize your Instagram account in the %s plugin settings %s.', 'meks-easy-instagram-widget' ), '<a href="'.esc_url( admin_url( 'options-general.php?page=meks-instagram' ) ).'">', '</a>') );
            return new WP_Error( 'blocked',  sprintf( esc_html__('Instagram has returned empty data. Please %sauthorize your Instagram account%s.', 'nm-instagram' ), '<a href="'.esc_url( admin_url( 'options-general.php?page=nm-instagram' ) ).'">', '</a>') );
		}

		
		$images = $this->parse_instagram_images_without_token( $images );
		
		if ( empty( $images ) ) {
			//NM return new WP_Error( 'no_images', esc_html__( 'Images not found. This may be a temporary problem. Please try again soon.', 'meks-easy-instagram-widget' ) );
            return new WP_Error( 'no_images', esc_html__( 'Images not found. This may be a temporary problem. Please try again soon.', 'nm-instagram' ) );
		}

		return $images;

	}
    
    
    /**
	 * Parse instagram images
	 *
	 * @since  1.0.1
	 *
	 * @param array $data
	 * @return array  - List of images prepared for displaying
	 */
	protected function parse_instagram_images_with_token( $data ) {

		$pretty_images = array();

		if ( 'business' == $this->api_type && ( !empty( $this->username ) && $this->username != $this->business_username ) ) {
			$images_data = $data->business_discovery->media->data;
		} else {
			$images_data = $data->data;
		}

		foreach ( $images_data as $image ) {

			if ( 'business' == $this->api_type && ( !empty( $this->username ) && $this->username != $this->business_username ) && $image->media_type == 'VIDEO' ) {
				continue;
			}

			$pretty_images[] = array(
				'caption'   => isset( $image->caption ) ? $image->caption : '',
				'link'      => trailingslashit( $image->permalink ),
				'time'      => $image->timestamp,
				'comments'  => isset( $image->comments_count ) ? $image->comments_count : '',
				'likes'     => isset( $image->like_count ) ? $image->like_count : '',
				'thumbnail' => $image->permalink.'media?size=t',
				'small'     => $image->permalink.'media?size=t',
				'medium'    => $image->permalink.'media?size=m',
				'large'     => $image->permalink.'media?size=l',
				'original'  => $image->media_type == 'VIDEO' ? $image->thumbnail_url : $image->media_url,
			);

		}

		return $pretty_images;
	}
    
    
	/**
	 * Parse instagram images
	 *
	 * @since  1.0.1
	 *
	 * @param array $images - Raw Images
	 * @return array           - List of images prepared for displaying
	 */
	protected function parse_instagram_images_without_token( $images ) {

		$pretty_images = array();

		foreach ( $images as $image ) {

			$pretty_images[] = array(
				'caption'   => isset( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'] ) ? $image['node']['edge_media_to_caption']['edges'][0]['node']['text'] : '',
				'link'      => trailingslashit( 'https://instagram.com/p/' . $image['node']['shortcode'] ),
				'time'      => $image['node']['taken_at_timestamp'],
				'comments'  => $image['node']['edge_media_to_comment']['count'],
				'likes'     => $image['node']['edge_liked_by']['count'],
				'thumbnail' => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][0]['src'] ), // 150
				'small'     => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][1]['src'] ), // 240
				'medium'    => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][2]['src'] ), // 320
				'large'     => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][3]['src'] ), // 480
				'original'  => preg_replace( '/^https?\:/i', '', $image['node']['display_url'] ),
			);

		}

		return $pretty_images;
	}
    
    
	/**
	 * Check if is one username or hashtag.
	 *
	 * @since 1.0.0
	 *
	 * @param string $usernames_or_hashtags String from username or hashtag input field
	 * @return string    Follow URL or empty string
	 */
	//NM protected function get_follow_link( $usernames_or_hashtags ) {
    public function get_follow_link( $usernames_or_hashtags ) {

		$usernames_hashtags_array   = explode( ',', $usernames_or_hashtags );
		$usernames_hashtags   = str_replace( '@', '', current( $usernames_hashtags_array ) );
		$this->username = $usernames_hashtags;
		
		return $this->get_instagram_url();
	}
    
    
    public function refresh_access_token( $options ) {

		if ( empty( $options ) ) {
			//NM $options = get_option( 'meks_instagram_settings' );
            $options = get_option( 'nm_instagram_settings' );
		}
        
		if ( empty( $options['access_token_expires_in'] ) || empty( $options['access_token'] ) ) {
			return false;
		}

		$refresh_time_past = $options['access_token_expires_in'] - ( 30 * 86400 ); // if past 30 days (60 - 30) 

		if ( $refresh_time_past > time() ) { 
			return false;
		}

		if ( 'business' == $this->api_type ) {
			$refresh_token_response = wp_remote_get( 'https://graph.facebook.com/v7.0/oauth/access_token?grant_type=fb_exchange_token&client_id=591315618393932&client_secret=14ae546b96c0684cc67a8d4b10eb3a7b&fb_exchange_token='. $options['access_token'] );
		} else {
			$refresh_token_response = wp_remote_get( 'https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token='. $options['access_token'] );

		}

		$refresh_data = json_decode( wp_remote_retrieve_body( $refresh_token_response ) );

		if ( is_wp_error( $refresh_token_response ) || isset( $refresh_data->error ) ) {
			//NM $error_message = __('Some problem with connection and with refresh token', 'meks-easy-instagram-widget');
            $error_message = __('Some problem with connection and refresh token', 'nm-instagram');
			if ( isset($refresh_data->error->message) ) {
				$error_message = $refresh_data->error->message;
			}
			return new WP_Error( 'refresh-invalid-token', esc_html( $error_message ) );
		} 

		$options['access_token'] = $refresh_data->access_token;
		
		if ( isset( $refresh_data->expires_in) ){
			$options['access_token_expires_in'] = $refresh_data->expires_in + time();
		} else {
			$options['access_token_expires_in'] = ( 60 * 86400 ) + time();
		}

		//NM update_option( 'meks_instagram_settings', $options );
        update_option( 'nm_instagram_settings', $options );
		
	}
}
