<?php

class NM_Instagram_Options {

	/**
	 *  Hold the class instance.
	 */
	private static $instance = null;

	/**
	 * Holds the default values
	 */
	private $defaults = array( 
		'access_token' => '', 
		'user_id' => '',
		'access_token_expires_in' => '', 
		'api_type' => 'personal', 
		'username' => '',
		'name' => '',
		'picture_url' => '',
	);

	/**
	 * Holds the values to be used in the fields callbacks
	 */
	private $options;

	/**
	 * Settings key in database, used in get_option() as first parameter
	 *
	 * @var string
	 */
	private $settings_key = 'nm_instagram_settings';

	/**
	 * Slug of the page, also used as identifier for hooks
	 *
	 * @var string
	 */
	private $slug = 'nm-instagram';

	/**
	 * Options group id, will be used as identifier for adding fields to options page
	 *
	 * @var string
	 */
	private $options_group_id = 'nm-instagram-group-id';

	/**
	 * Fields var
	 *
	 * @var string
	 */
	private $fields;


	/**
	 * Constructor
	 */
	public function __construct() {
		$this->init();
	}


	/**
	 * Get Class Instance
	 */
	public static function get_instance() {
		if ( self::$instance == null ) {
			self::$instance = new NM_Instagram_Options();
		}
		return self::$instance;
	}


	/**
	 * Initialize method
	 */
	public function init() {
		$database_options = get_option( $this->settings_key );
		$this->options = wp_parse_args( $database_options, $this->defaults );

		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// check for instagram type and if is business make get requests
		if ( !empty( $this->options['access_token'] ) && $this->options['api_type'] == 'business' ) {	
			$this->get_business_data_api();
		}

	}
    
     /**
     * Enqueue Admin Scripts
     */
    public function enqueue_admin_scripts() {
        global $pagenow;
        
        if ( $pagenow == 'options-general.php' && isset( $_GET['page'] ) && $_GET['page'] == $this->slug ) {
            wp_enqueue_script( 'nm_instagram_settings', NM_INSTAGRAM_URI . 'assets/js/nm-admin-instagram-settings.js', array( 'jquery' ), NM_INSTAGRAM_VERSION, true );
        }
    }

	/* Get fields data */
	function get_fields() {

		$fields = array(

			'access_token' => array(
				'id'       => 'access_token',
				'title'    => esc_html__( 'Access Token', 'nm-instagram' ),
				'sanitize' => 'text',
				'default'  => '',
			),

			'user_id' => array(
				'id'       => 'user_id',
				'title'    => '',//esc_html__( 'User ID', 'nm-instagram' ),
				'sanitize' => 'text',
				'default'  => '',
			),

			'access_token_expires_in' => array(
				'id'       => 'access_token_expires_in',
				'title'    => '',
				'sanitize' => 'text',
				'default'  => '',
			),

			'api_type' => array(
				'id'       => 'api_type',
				'title'    => '',
				'sanitize' => 'text',
				'default'  => '',
			),

		);

		$fields = apply_filters( 'nm_instagram_modify_options_fields', $fields );

		return $fields;

	}


	/**
	 * Add options page
	 */
	public function add_options_page() {
		// This page will be under "Settings"
		add_options_page(
			esc_html__( 'Savoy Theme - Instagram Gallery', 'nm-instagram' ),
			esc_html__( 'Savoy Theme - Instagram Gallery', 'nm-instagram' ),
			'manage_options',
			$this->slug,
			array( $this, 'print_settings_page' )
		);
	}

	/**
	 * Options page callback
	 */
	public function print_settings_page() {
		?>
		<div id="nm-admin-instagram-options" class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<form method="post" action="options.php">
				<?php
					settings_fields( $this->options_group_id );
					do_settings_sections( $this->slug );
					submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Register and add settings
	 */
	public function page_init() {

		register_setting(
			$this->options_group_id, // Option group
			$this->settings_key, // Option name
			array( $this, 'sanitize' ) // Sanitize
		);

		$this->fields = $this->get_fields();

		if ( empty( $this->fields ) ) {
			return false;
		}

		$section_id = 'nm_instagram_section';

		add_settings_section( $section_id, '', '', $this->slug );

		foreach ( $this->fields as $field ) {

			if ( empty( $field['id'] ) ) {
				continue;
			}

			$action   = 'print_' . $field['id'] . '_field';
			$callback = method_exists( $this, $action ) ? array( $this, $action ) : $field['action'];

			add_settings_field(
				'nm_instagram_' . $field['id'] . '_id',
				$field['title'],
				$callback,
				$this->slug,
				$section_id,
				$this->options[ $field['id'] ]
			);
		}

	}

	/**
	 * Sanitize each setting field as needed
	 *
	 * @param unknown $input array $input Contains all settings fields as array keys
	 * @return mixed
	 */
	public function sanitize( $input ) {

		if ( empty( $this->fields ) || empty( $input ) ) {
			return false;
		}

		$new_input = array();
		foreach ( $this->fields as $field ) {
			if ( isset( $input[ $field['id'] ] ) ) {
				$new_input[ $field['id'] ] = $this->sanitize_field( $input[ $field['id'] ], $field['sanitize'] );
			}
		}

		return $new_input;
	}

	/**
	 * Dynamically sanitize field values
	 *
	 * @param unknown $value
	 * @param unknown $sensitization_type
	 * @return int|string
	 */
	private function sanitize_field( $value, $sensitization_type ) {
		switch ( $sensitization_type ) {

			case 'checkbox':
				$new_input = array();
				foreach ( $value as $key => $val ) {
					$new_input[ $key ] = ( isset( $value[ $key ] ) ) ?
					sanitize_text_field( $val ) :
					'';
				}
				return $new_input;
			break;

			case 'radio':
				return sanitize_text_field( $value );
			break;

			case 'text':
				return sanitize_text_field( $value );
			break;

			default:
				return $value;
				break;
		}
	}


	/**
	 * Print button field
	 */
	public function instagram_auth_button() {

		$oauth_personal_url = 'https://api.instagram.com/oauth/authorize?app_id=515358899130297&redirect_uri=https://mekshq.com/instagram-personal-api/&response_type=code&scope=user_profile,user_media&state='. esc_url( admin_url( 'options-general.php?page=' . $this->slug ) );
		
		$oauth_business_url = 'https://www.facebook.com/v7.0/dialog/oauth?client_id=591315618393932&redirect_uri=https://mekshq.com/instagram-business-api/&response_type=code&scope=pages_show_list,instagram_basic,instagram_manage_insights&state='. esc_url( admin_url( 'options-general.php?page=' . $this->slug ) );
        
        $include_business_button = apply_filters( 'nm_instagram_settings_business_auth', false );
        
        if ( $include_business_button ) {
            $buttons = sprintf( __( 'Generate access token: %1$sAuthorize Personal account%3$s or %2$sAuthorize Business account%3$s', 'nm-instagram' ),
                '<a href="' . $oauth_personal_url . '">',
                '<a href="' . $oauth_business_url . '">',
                '</a>'
            );
        } else {
            $buttons = sprintf( __( 'Generate access token: %sAuthorize account%s', 'nm-instagram' ),
                '<a href="' . $oauth_personal_url . '">',
                '</a>'
            );
        }
        
        echo '<div class="nm-admin-instagram-auth-buttons">' . $buttons . '</div>';
        
	}

	/**
	 * Print access token field
	 */
	public function print_access_token_field( $args ) {

		printf(
			'<label class="nm-instagram-access-token"><input type="text" id="nm-access-token" name="%s[access_token]" value="%s"/></label>',
			$this->settings_key,
			$args
		);
		$this->instagram_auth_button();

	}

	/**
	 * Print user ID field
	 */
	public function print_user_id_field( $args ) {

		printf(
			'<label class="nm-instagram-user-id"><input type="hidden" id="nm-user-id" name="%s[user_id]" value="%s"/></label>',
			$this->settings_key,
			$args
		);

	}

	/**
	 * Print access_token_expires_in field
	 */
	public function print_api_type_field( $args ) {

		printf(
			'<input type="hidden" id="nm-api-type" name="%s[api_type]" value="%s"/>',
			$this->settings_key,
			$args
		);

	}

	/**
	 * Print access_token_expires_in field
	 */
	public function print_access_token_expires_in_field( $args ) {

		printf(
			'<input type="hidden" id="nm-token-expires-in" name="%s[access_token_expires_in]" value="%s"/>',
			$this->settings_key,
			$args
		);

	}

	public function get_business_data_api() {

		$result = wp_remote_get( 'https://graph.facebook.com/v7.0/me/accounts?fields=access_token,name,username,picture,instagram_business_account&limit=600&access_token='.$this->options['access_token'] );

		$pages_data = '{}';

		if ( ! is_wp_error( $result ) ) {
			$pages_data = $result['body'];
		} else {
			$page_error = $result;
			print_r($page_error);
		}

		$data = json_decode($pages_data);

		//print_r($data);

		if ( isset( $data->data[0]->instagram_business_account->id ) ) {
			$this->options['user_id'] = $data->data[0]->instagram_business_account->id;
			$this->options['username'] = $data->data[0]->username;
			$this->options['name'] = $data->data[0]->name;
			$this->options['picture_url'] = $data->data[0]->picture->data->url;
			update_option( $this->$settings_key, $this->options );
		}
		
	}

}
