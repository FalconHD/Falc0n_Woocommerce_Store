<?php
/*
 * NM - Theme Setup Wizard
 */

class NM_Setup {
	
	protected $version = '1.2';
	protected $theme_title = 'Savoy';
	/* Setup page */
	protected $page_slug = 'nm-theme-setup';
	protected $page_title = 'Theme Setup';
	/* TGMPA */
	protected $tgmpa_instance;
	protected $tgmpa_menu_slug = 'tgmpa-install-plugins';
	protected $tgmpa_url = 'themes.php?page=tgmpa-install-plugins';
	/* Widgets file URL */
    protected $widget_file_url = '';
    /* Setup completed check */
    protected $completed_task_content = false;
    protected $completed_task_settings = false;
    
    
	/*
	 * Constructor
	 */
	function __construct() {
        // Constants
        if ( ! defined( 'NM_IMPORT_URI' ) ) {
            define( 'NM_IMPORT_URI', NM_URI ); // URI used to fetch attachments (images) in the "NM_WP_Import" class
        }
        if ( ! defined( 'NM_IMPORT_LOCAL_IMAGES' ) ) {
            define( 'NM_IMPORT_LOCAL_IMAGES', true ); // Set to "false" to use the default attachment (image) URLs in the "content.xml" import file
        }
        
		// Includes
		require_once NM_DIR . '/tgmpa/class-tgm-plugin-activation.php';
		require_once NM_DIR . '/tgmpa/config.php';
		require_once NM_DIR . '/setup/includes/wordpress-importer/nm-wordpress-importer.php';
        require_once NM_DIR . '/setup/includes/class-whizzie-widget-importer.php';
		
        $this->widget_file_url  = NM_DIR . '/setup/content/widgets.wie';
        
        // Completed setup tasks
        $completed_setup_tasks = get_option( 'nm_setup_tasks_completed', array() );
        $this->completed_task_loaded = ( in_array( 'loaded', $completed_setup_tasks ) ) ? true : false;
        $this->completed_task_content = ( in_array( 'content', $completed_setup_tasks ) ) ? true : false;
        $this->completed_task_settings = ( in_array( 'settings', $completed_setup_tasks ) ) ? true : false;
        
		$this->init();
	}
	
    
    /*
     * Get instance
     */
	static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	
    
	/*
	 * Hooks and filters
	 */	
	function init() {
        add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );
		
        // Has the setup loaded previously?
        if ( ! $this->completed_task_loaded ) {
            add_action( 'after_switch_theme', array( $this, 'redirect_to_setup' ) );
            
            $this->content_install_set_completed_task( 'loaded' ); // Set "complete" step
        }
        add_action( 'admin_menu', array( $this, 'menu_page' ) );
		
        if ( class_exists( 'TGM_Plugin_Activation' ) && isset( $GLOBALS['tgmpa'] ) ) {
			add_action( 'init', array( $this, 'tgmpa_get_instance' ), 30 );
			add_action( 'init', array( $this, 'tgmpa_set_url' ), 40 );
		}
		//add_action( 'admin_init', array( $this, 'tgmpa_get_plugins' ), 30 );
		
        // AJAX hooks
        add_action( 'wp_ajax_page_builder_save_selection', array( $this, 'page_builder_save_selection' ) );
        add_action( 'wp_ajax_plugins_install', array( $this, 'plugins_install' ) );
		add_action( 'wp_ajax_content_install', array( $this, 'content_install' ) );
        
        add_filter( 'tgmpa_load', array( $this, 'tgmpa_load' ), 10, 1 );
	}
	
    
    /*
     * Theme activation redirect
     */
	function redirect_to_setup() {
		global $pagenow;
		if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) && current_user_can( 'manage_options' ) ) {
			wp_redirect( admin_url( 'themes.php?page=' . esc_attr( $this->page_slug ) ) );
		}
	}
	
    
    /*
     * Include assets
     */
	function assets() {
		wp_enqueue_style( 'nm-setup', NM_URI . '/setup/assets/nm-setup.css', array(), time() );
        wp_enqueue_script( 'nm-setup', NM_URI . '/setup/assets/nm-setup.js', array( 'jquery' ), time() );
        wp_localize_script( 'nm-setup', 'nm_setup_params', array(
            'ajaxurl'   => admin_url( 'admin-ajax.php' ),
            'wpnonce'   => wp_create_nonce( 'nm_setup_nonce' )
        ) );
	}
	
    
    /*
     * TGMPA: Check user privileges
     */
	function tgmpa_load( $status ) {
		return is_admin() || current_user_can( 'install_themes' );
	}
	
    
	/*
	 * TGMPA: Get configured instance
	 */
	function tgmpa_get_instance() {
		$this->tgmpa_instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
	}
	
    
	/*
	 * TGMPA: Update $tgmpa_menu_slug and $tgmpa_parent_slug from instance
	 */
	function tgmpa_set_url() {
		$this->tgmpa_menu_slug = ( property_exists( $this->tgmpa_instance, 'menu' ) ) ? $this->tgmpa_instance->menu : $this->tgmpa_menu_slug;
		$this->tgmpa_menu_slug = $this->tgmpa_menu_slug;
		$tgmpa_parent_slug = ( property_exists( $this->tgmpa_instance, 'parent_slug' ) && $this->tgmpa_instance->parent_slug !== 'themes.php' ) ? 'admin.php' : 'themes.php';
		$this->tgmpa_url = $tgmpa_parent_slug . '?page=' . $this->tgmpa_menu_slug;
	}
    
    
    /*
	 * TGMPA: Get registered plugins
	 */
	function tgmpa_get_plugins() {
		$instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
		$plugins = array(
			'all' 		=> array(),
			'install'	=> array(),
			'update'	=> array(),
			'activate'	=> array()
		);
        $method_name = 'is_plug' . 'in_active'; // TC
		foreach( $instance->plugins as $slug=>$plugin ) {
			/*if ( $instance->is_plugin_active( $slug ) && false === $instance->does_plugin_have_update( $slug ) ) {*/
            if ( $instance->$method_name( $slug ) && false === $instance->does_plugin_have_update( $slug ) ) {
				// Plugin is installed and up to date
                continue;
			} else {
                $plugins['all'][$slug] = $plugin;
				if ( ! $instance->is_plugin_installed( $slug ) ) {
					$plugins['install'][$slug] = $plugin;
				} else {
					if ( false !== $instance->does_plugin_have_update( $slug ) ) {
						$plugins['update'][$slug] = $plugin;
					}
					if ( $instance->can_plugin_activate( $slug ) ) {
						$plugins['activate'][$slug] = $plugin;
					}
				}
			}
		}
		return $plugins;
	}
	
    
	/*
	 * Admin page
	 */
	function menu_page() {
        add_theme_page( $this->page_title, $this->page_title, 'manage_options', $this->page_slug, array( $this, 'view' ) );
	}
    
    
    /*
	 * Setup steps
	 */
	function get_steps() {
		$steps = array( 
			'intro' => array(
				'id'	        => 'intro',
                'callback'      => 'do_next_step',
				'view'	        => 'view_intro'
			),
            'page_builder_select' => array(
				'id'	        => 'page_builder_select',
                'callback'      => 'page_builder_select',
				'view'	        => 'view_page_builder_select'
			),
			'plugins' => array(
				'id'	        => 'plugins',
				'menu_title'    => 'Plugins',
                'callback'      => 'plugins_install',
				'view'          => 'view_plugins'
			),
			'content' => array(
				'id'	        => 'content',
				'menu_title'    => 'Content',
                'callback'      => 'content_install',
				'view'	        => 'view_content'
			),
			'final' => array(
				'id'            => 'final',
				'menu_title'    => 'Done!',
                'callback'      => '',
				'view'	        => 'view_final'
			)
		);
		
		return $steps;
	}
	
    
	/*
	 * Setup view
	 */
	function view() {
		tgmpa_load_bulk_installer();
		// Install plugins with TGM
		if ( ! class_exists( 'TGM_Plugin_Activation' ) || ! isset( $GLOBALS['tgmpa'] ) ) {
			die( 'Failed to find TGM' );
		}
		$url = wp_nonce_url( add_query_arg( array( 'plugins' => 'go' ) ), 'nm-setup' );
		
		// Copied from TGM
		$method = ''; // Leave blank so WP_Filesystem can populate it as necessary.
		$fields = array_keys( $_POST ); // Extra fields to pass to WP_Filesystem.
		if ( false === ( $creds = request_filesystem_credentials( esc_url_raw( $url ), $method, false, false, $fields ) ) ) {
			return true; // Stop the normal page form from displaying, credential request form will be shown.
		}
		// Now we have some credentials, setup WP_Filesystem.
		if ( ! WP_Filesystem( $creds ) ) {
			// Our credentials were no good, ask the user for them again.
			request_filesystem_credentials( esc_url_raw( $url ), $method, true, false, $fields );
			return true;
		}
		/* If we arrive here, we have the filesystem */
        
        $steps = $this->get_steps();
        ?>
		<div class="nm-setup wrap">
			<?php printf( '<h1>%s</h1>', esc_html( $this->page_title ) ); ?>
            
            <div id="nm-setup-notice" class="hide">
                <p></p>
            </div>
            
            <ul class="nm-setup-breadcrumbs">
            <?php foreach( $steps as $step ) {
                if ( isset( $step['menu_title'] ) && $step['menu_title'] ) {
                    echo '<li class="nav-step-' . esc_attr( $step['id'] ) . '"><span>' . $step['menu_title'] . '</span></li>';
                }
            }
            ?>
            </ul>
			
            <div class="nm-setup-view card">
                <div class="nm-setup-cover"></div>
                
				<ul class="nm-setup-steps">
				<?php foreach( $steps as $step ) {
					echo '<li data-step="' . esc_attr( $step['id'] ) . '" class="step step-' . esc_attr( $step['id'] ) . '">';
                        $content = call_user_func( array( $this, $step['view'] ) );
                        echo $content;
					echo '</li>';
				}
                ?>
				</ul>
                
                <div class="nm-setup-spinner">
                    <!--<span class="spinner"></span>-->
                    <img src="images/spinner.gif">
                </div>
			</div>
		</div>
	<?php
    }
	
    
	/*
	 * Setup view: Intro
	 */
	function view_intro() {
        $data_callback = 'do_next_step';
        $data_step = 'intro';
        
		ob_start();
        
        if ( ! $this->completed_task_content ) :
        ?>
        <h2>Welcome to <?php echo $this->theme_title; ?></h2>
        <img src="<?php echo NM_URI . '/setup/assets/img/nm-setup.jpg'; ?>">
        <div class="nm-setup-summary">
            <p><?php esc_html_e( "This wizard will help you install the theme's plugins and demo content.", 'nm-framework-admin' ); ?></p>
        </div>
        <div class="nm-setup-button-wrap">
            <a href="#" class="button button-primary nm-setup-button" data-callback="<?php echo esc_attr( $data_callback ); ?>" data-step="<?php echo esc_attr( $data_step ); ?>"><?php esc_html_e( 'Start', 'nm-framework-admin' ); ?></a>
        </div>
        <?php else : ?>
        <h2><?php esc_html_e( 'Welcome Back', 'nm-framework-admin' ); ?></h2>
        <img src="<?php echo NM_URI . '/setup/assets/img/nm-setup.jpg'; ?>">
        <div class="nm-setup-summary">
            <p><?php esc_html_e( 'It looks like the setup wizard has already been running, want to start it again?', 'nm-framework-admin' ); ?></p>
        </div>
        <div class="nm-setup-button-wrap">
            <a href="<?php echo admin_url(); ?>" class="button button-secondary"><?php esc_html_e( 'Cancel', 'nm-framework-admin' ); ?></a>
            <a href="#" class="button button-primary nm-setup-button" data-callback="<?php echo esc_attr( $data_callback ); ?>" data-step="<?php echo esc_attr( $data_step ); ?>"><?php esc_html_e( 'Start Setup Again', 'nm-framework-admin' ); ?></a>
        </div>
        <?php
        endif;
        
        $content = ob_get_clean();
        return $content;
	}
	
    
    /*
	 * Setup view: Page builder selection
	 */
	function view_page_builder_select() {
		$page_builder_selection = get_option( 'nm_page_builder_selection', 'elementor' );
        
        ob_start();
        
        ?>
        <h2><?php esc_html_e( 'Page Builder', 'nm-framework-admin' ); ?></h2>
        <div class="nm-setup-summary">
            <p><?php esc_html_e( "Select the Page Builder you would like to use (it's possible to disable the selected page builder after the setup).", 'nm-framework-admin' ); ?></p>
        </div>
        <ul id="nm-setup-page-builder-select" class="nm-setup-page-builder-select">
            <li>
                <label for="nm-setup-page-builder-elementor">
                    <img src="<?php echo esc_url( NM_URI . '/setup/assets/img/plugin-elementor.jpg' ); ?>">
                    <div>
                        Elementor
                        <span><?php esc_html_e( 'Frontend Page Builder', 'nm-framework-admin' ); ?></span>
                        <a href="https://elementor.com/" target="_blank"><?php esc_html_e( 'Learn more', 'nm-framework-admin' ); ?></a>
                        <input type="radio" id="nm-setup-page-builder-elementor" name="page_builder" value="elementor" <?php checked( $page_builder_selection, 'elementor' ); ?>>
                    </div>
                </label>
            </li>
            <li>
                <label for="nm-setup-page-builder-wpbakery">
                    <img src="<?php echo esc_url( NM_URI . '/setup/assets/img/plugin-js_composer.jpg' ); ?>">
                    <div>
                        WPBakery
                        <span><?php esc_html_e( 'Backend Page Builder', 'nm-framework-admin' ); ?></span>
                        <a href="https://wpbakery.com/" target="_blank"><?php esc_html_e( 'Learn more', 'nm-framework-admin' ); ?></a>
                        <input type="radio" id="nm-setup-page-builder-wpbakery" name="page_builder" value="wpbakery" <?php checked( $page_builder_selection, 'wpbakery' ); ?>>
                    </div>
                </label>
            </li>
        </ul>
        <div class="nm-setup-button-wrap">
            <a href="#" class="button button-primary nm-setup-button" data-callback="page_builder_select" data-step="page_builder_select"><?php esc_html_e( 'Select', 'nm-framework-admin' ); ?></a>
        </div>
        <?php
        
        $content = ob_get_clean();
        return $content;
    }
    
    
	/*
	 * Setup view: Plugins
	 */
	function view_plugins() {
		$plugins = $this->tgmpa_get_plugins();
        
		// Create plugin list
        $plugin_lis = '';
		foreach( $plugins['all'] as $slug => $plugin ) {
			$plugin_lis .= '<li data-slug="' . esc_attr( $slug ) . '"><div>';
            $plugin_lis .= '<img src="' . NM_URI . '/setup/assets/img/plugin-' . $slug . '.jpg">' . esc_html( $plugin['name'] ) . '<span>';
			$keys = array();
			if ( isset( $plugins['install'][$slug] ) ) {
			    $keys[] = 'Installation';
			}
			if ( isset( $plugins['update'][$slug] ) ) {
			    $keys[] = 'Update';
			}
			if ( isset( $plugins['activate'][$slug] ) ) {
			    $keys[] = 'Activation';
			}
			$plugin_lis .= implode( ' and ', $keys ) . ' required';
			$plugin_lis .= '</span></div></li>';
		}				
        
        ob_start();
        ?>
        <h2><?php esc_html_e( 'Install Plugins', 'nm-framework-admin' ); ?></h2>
        <?php if ( ! empty( $plugins['all'] ) ) : ?>
        <div class="nm-setup-summary">
            <p><?php esc_html_e( "Let's start by installing some required WordPress plugins (it's possible to deactivate these plugins after the setup).", 'nm-framework-admin' ); ?></p>
        </div>
        <ul class="nm-setup-tasks nm-setup-tasks-plugins">
            <?php echo $plugin_lis; ?>
        </ul>
        <div class="nm-setup-button-wrap"><a href="#" class="button button-primary nm-setup-button" data-callback="plugins_install" data-step="plugins"><?php esc_html_e( 'Install', 'nm-framework-admin' ); ?></a></div>
        <?php else : ?>
        <div class="nm-setup-summary">
            <p><?php esc_html_e( 'All required plugins are installed.', 'nm-framework-admin' ); ?></p>
        </div>
        <div class="nm-setup-button-wrap"><a href="#" class="button button-primary nm-setup-button" data-callback="do_next_step" data-step="plugins"><?php esc_html_e( 'OK', 'nm-framework-admin' ); ?></a></div>
        <?php
        endif;
        
        $content = ob_get_clean();
        return $content;
	}
	
    
	/*
	 * Setup view: Content
	 */
	function view_content() {
        $content_status = ( $this->completed_task_content ) ? esc_html__( 'Installed', 'nm-framework-admin' ) : esc_html__( 'Not installed', 'nm-framework-admin' );
        $settings_status = ( $this->completed_task_settings ) ? esc_html__( 'Configured', 'nm-framework-admin' ) : esc_html__( 'Not configured', 'nm-framework-admin' );
        $button_title = ( $this->completed_task_content ) ? esc_html__( 'Import Again', 'nm-framework-admin' ) : esc_html__( 'Install', 'nm-framework-admin' );
        
        ob_start();
        ?>
        <h2><?php esc_html_e( 'Import Content', 'nm-framework-admin' ); ?></h2>
        <div class="nm-setup-summary">
            <p><?php esc_html_e( 'Do you want to import the demo content? Note that this can take some time.', 'nm-framework-admin' ); ?></p>
            <ul class="nm-setup-tasks nm-setup-tasks-content">
                <li class="nm-setup-task-content"><img src="<?php echo esc_url( NM_URI . '/setup/assets/img/content-import.jpg' ); ?>"><div>Content<span>Status: <?php echo $content_status; ?></span></div></li>
                <li class="nm-setup-task-settings"><img src="<?php echo esc_url( NM_URI . '/setup/assets/img/content-settings.jpg' ); ?>"><div>Settings<span>Status: <?php echo $settings_status; ?></span></div></li>
            </ul>
        </div>
        <div class="nm-setup-button-wrap">
            <a href="#" class="button button-secondary nm-setup-button" data-callback="do_next_step" data-step="content"><?php esc_html_e( 'Skip', 'nm-framework-admin' ); ?></a>
            <a href="#" class="button button-primary nm-setup-button" data-callback="content_install" data-step="content"><?php echo $button_title; ?></a>
        </div>
        <?php
        $content = ob_get_clean();
        return $content;
	}
	
    
	/*
	 * Setup view: Final
	 */
	function view_final() {
        ob_start();
        ?>
        <h2><?php esc_html_e( 'All Done', 'nm-framework-admin' ); ?></h2>
        <img src="<?php echo NM_URI . '/setup/assets/img/nm-setup-complete.jpg'; ?>">
        <div class="nm-setup-summary">
            <p><?php esc_html_e( 'The theme should now be set-up, have fun!', 'nm-framework-admin' ); ?></p>
        </div>
        <div class="nm-setup-info">
            <h3><?php esc_html_e( "What's Next?", 'nm-framework-admin' ); ?></h3>
            <ul>
                <li><a href="http://docs.nordicmade.com/savoy/#general-updating-theme" class="dashicons-before dashicons-update" target="_blank"><?php esc_html_e( 'Activate theme updates', 'nm-framework-admin' ); ?></a></li>
                <!--<li><a href="<?php echo admin_url( 'admin.php?page=wc-admin&path=/setup-wizard' ); ?>" class="dashicons-before dashicons-admin-settings"><?php esc_html_e( 'WooCommerce setup wizard', 'nm-framework-admin' ); ?></a></li>-->
                <li><a href="http://docs.nordicmade.com/savoy/" class="dashicons-before dashicons-editor-help" target="_blank"><?php esc_html_e( 'Theme documentation', 'nm-framework-admin' ); ?></a></li>
            </ul>
        </div>
        <div class="nm-setup-button-wrap"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button button-primary" target="_blank"><?php esc_html_e( 'View Site', 'nm-framework-admin' ); ?></a></div>
        <?php
        $content = ob_get_clean();
        return $content;
	}
    
    
    /*
	 * Page builder - AJAX: Save selection
	 */
	function page_builder_save_selection() {
        check_ajax_referer( 'nm_setup_nonce', 'wpnonce' );
        
        if ( isset( $_POST['selection'] ) ) {
            update_option( 'nm_page_builder_selection', $_POST['selection'] );
        
            echo 'Page builder selection: ' . $_POST['selection'];
        }
        
		exit;
	}
	
    
    /*
     * Plugins - AJAX: Activate/update/install
     */
	function plugins_install() {
		if ( ! check_ajax_referer( 'nm_setup_nonce', 'wpnonce' ) || empty( $_POST['slug'] ) ) {
			wp_send_json_error( array( 'error' => 1, 'message' => esc_html__( 'No Slug Found', 'nm-framework-admin' ) ) );
		}
		$json = array();
		// send back some json we use to hit up TGM
		$plugins = $this->tgmpa_get_plugins();
		
		// what are we doing with this plugin?
		foreach ( $plugins['activate'] as $slug => $plugin ) {
			if ( $_POST['slug'] == $slug ) {
				$json = array(
					'url'           => admin_url( $this->tgmpa_url ),
					'plugin'        => array( $slug ),
					'tgmpa-page'    => $this->tgmpa_menu_slug,
					'plugin_status' => 'all',
					'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
					'action'        => 'tgmpa-bulk-activate',
					'action2'       => - 1,
					'message'       => esc_html__( 'Activating Plugin', 'nm-framework-admin' ),
				);
				break;
			}
		}
		foreach ( $plugins['update'] as $slug => $plugin ) {
			if ( $_POST['slug'] == $slug ) {
				$json = array(
					'url'           => admin_url( $this->tgmpa_url ),
					'plugin'        => array( $slug ),
					'tgmpa-page'    => $this->tgmpa_menu_slug,
					'plugin_status' => 'all',
					'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
					'action'        => 'tgmpa-bulk-update',
					'action2'       => - 1,
					'message'       => esc_html__( 'Updating Plugin', 'nm-framework-admin' ),
				);
				break;
			}
		}
		foreach ( $plugins['install'] as $slug => $plugin ) {
			if ( $_POST['slug'] == $slug ) {
				$json = array(
					'url'           => admin_url( $this->tgmpa_url ),
					'plugin'        => array( $slug ),
					'tgmpa-page'    => $this->tgmpa_menu_slug,
					'plugin_status' => 'all',
					'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
					'action'        => 'tgmpa-bulk-install',
					'action2'       => - 1,
					'message'       => esc_html__( 'Installing Plugin', 'nm-framework-admin' ),
				);
				break;
			}
		}
		if ( $json ) {
			$json['hash'] = md5( serialize( $json ) ); // Used for checking if duplicates happen, move to next plugin
			wp_send_json( $json );
		} else {
			wp_send_json( array( 'done' => 1, 'message' => esc_html__( 'Success', 'nm-framework-admin' ) ) );
		}
		exit;
	}
    
    
	/*
	 * Content - AJAX: Install
	 */
	function content_install() {
        check_ajax_referer( 'nm_setup_nonce', 'wpnonce' );
        
        // Make sure WooCommerce plugin is activated
        $woocommerce_required = apply_filters( 'nm_setup_woocommerce_required', true );
        if ( $woocommerce_required && ! class_exists( 'woocommerce' ) ) {
            echo 'woocommerce na';
            exit;
        }
        
        $installation_task = ( isset( $_POST['task'] ) ) ? $_POST['task'] : null;
        
        switch ( $installation_task ) {
            
            /* Save WooCommerce taxonomies */
            case 'woocommerce_taxonomies':
                $this->content_install_woocommerce_taxonomies();
                echo 'woocommerce_taxonomies';
            break;
            
                
            /* Import content */
            case 'content':
                $this->content_install_import_content();
                
                $this->content_install_set_completed_task( 'content' ); // Set "complete" step
                echo 'content';
            break;
            
            
            /* Import widgets */
            case 'widgets':
                $this->content_install_widgets();
                
                $this->content_install_set_completed_task( 'widgets' ); // Set "complete" step
                echo 'widgets';
            break;
            
            
            /* Save/update settings */
            case 'settings':
                $this->content_install_menus(); // WP menus
                $this->content_install_wp_options(); // WP options
                $this->content_install_theme_options(); // Theme options
                $this->content_install_color_widget_option(); // Save custom colors for "Color" product-taxonomy
                $this->content_install_delete_default_post(); // Delete default "Hello World" post
                $this->content_install_permalinks(); // WP permalink structure
                
                $this->content_install_set_completed_task( 'settings' ); // Set "complete" step
                echo 'settings';
            break;
        
        }
        
		exit;
	}
    
    
    /*
	 * Content - AJAX: Install -> WooCommerce taxonomies
	 */
    function content_install_woocommerce_taxonomies() {
        // Save WooCommerce product-taxonomies before importing the content so product-attributes can be saved
        // An "invalid taxonomy" error is displayed when importing otherwise since each attribute is a custom taxonomy
        $attribute_taxonomies = array();
        $attribute_taxonomies[] = array(
            'id'            => '',
            'name'          => 'Color',
            'slug'          => 'color',
            //'type'          => 'select',
            'type'          => 'color',
            'orderby'       => 'menu_order',
            'has_archives'  => false
        );
        $attribute_taxonomies[] = array(
            'id'            => '',
            'name'          => 'Size',
            'slug'          => 'size',
            //'type'          => 'select',
            'type'          => 'size',
            'orderby'       => 'menu_order',
            'has_archives'  => false
        );
        
        if ( function_exists( 'wc_create_attribute' ) ) {
            // Add custom attributes types so the attribute "Type" setting is set correctly
            add_filter( 'product_attributes_type_selector', function( $attribute_types ) {
                $attribute_types['color'] = esc_html__( 'Color', 'nm-framework-admin' );
                $attribute_types['size'] = esc_html__( 'Label', 'nm-framework-admin' );
                return $attribute_types;
            } );
            
            foreach( $attribute_taxonomies as $attribute_taxonomy ) {
                wc_create_attribute( $attribute_taxonomy );
            }
        }
    }
    
    
    /*
	 * Content - AJAX: Install -> Content
	 */
    function content_install_import_content() {
        $page_builder_selection = get_option( 'nm_page_builder_selection', 'wpbakery' );
        $content_file_url = ( $page_builder_selection == 'elementor' ) ? NM_DIR . '/setup/content/content-elementor.xml' : NM_DIR . '/setup/content/content.xml';
        
        if ( file_exists( $content_file_url ) ) {
            $import = new NM_WP_Import();

            // Set-up import settings: Code from "dispatch()" function of "NM_WP_Import" import class
            $import->fetch_attachments = true; // Download and import file attachments
            set_time_limit( 0 );

            $import->import( $content_file_url );
        }
    }
    
    
    /*
	 * Content - AJAX: Install -> Widgets
	 */
    function content_install_widgets() {
        if ( file_exists( $this->widget_file_url ) ) {
            $Whizzie_Widget_Importer = new Whizzie_Widget_Importer;
            $results = $Whizzie_Widget_Importer->import_widgets( $this->widget_file_url );

            //wp_send_json( $results );
        } else {
            //wp_send_json( array( 'done' => 1, 'message' => 'File does not exist' ) );
            echo 'Widgets file does not exist';
        }
    }
    
    
    /*
	 * Content - AJAX: Install -> Settings -> Menus
	 */
    function content_install_menus() {
        // Set menu locations
        $menu_locations = array(
            'top-bar-menu'  => 'Top Bar',
            'main-menu'     => 'Main',
            'mobile-menu'   => 'Mobile',
            'footer-menu'   => 'Footer'
        );
        foreach( $menu_locations as $menu_location_id => $menu_name ) {
            $menu = get_term_by( 'name', $menu_name, 'nav_menu' );

            if ( $menu ) {
                $menu_locations[$menu_location_id] = $menu->term_id;
            } else {
                $menu_locations[$menu_location_id] = '';
            }
        }
        set_theme_mod( 'nav_menu_locations', $menu_locations );
        
        // Main menu: Add thumbnail images
        $main_menu = wp_get_nav_menu_items( 'Main' );
        $this->menu_add_thumbnail_images( $main_menu );
    }
    
    
    /*
	 * Menu - Add thumbnail images to "Categories" menu-items
	 */
    function menu_add_thumbnail_images( $menu ) {
        foreach( $menu as $menu_item ) {
            if ( $menu_item->object == 'product_cat' || strpos( $menu_item->post_name, 'shop-all' ) !== false ) {
                //if ( $menu_item->title !== 'Shop - Single Category' ) { // Exclude category-link in the "Shop" menu
                    
                    $args = array(
                        'post_type'         => 'attachment',
                        'name'              => 'menu-thumbnail', // Menu-image name/slug
                        'posts_per_page'    => 1,
                        'post_status'       => 'inherit',
                    );
                    $menu_image = get_posts( $args );
                    if ( $menu_image ) {
                        $menu_image = array_pop( $menu_image );
                        update_post_meta( $menu_item->ID, '_nm_menu_item_thumbnail', intval( $menu_image->ID ) );
                    }
                    
                //}
            }
        }
    }
    
    
    /*
	 * Content - AJAX: Install -> Settings -> WordPress options
	 */
    function content_install_wp_options() {
        update_option( 'show_on_front', 'page' );
        
        /* WP: Default page options */
        $shop_page = get_page_by_title( 'Shop' );
        if ( $shop_page ) {
            update_option( 'page_on_front', $shop_page->ID );
        }
        
        $blog_page = get_page_by_title( 'Blog' );
        if ( $blog_page ) {
            update_option( 'page_for_posts', $blog_page->ID );
        }
        
        update_option( 'posts_per_page', 9 );
        
        
        /* WooCommerce: Default options */
        if ( $shop_page ) {
            update_option( 'woocommerce_shop_page_id', $shop_page->ID );
        }
        
        /* Set by WooCommerce: $cart_page = get_page_by_title( 'Cart' );
        if ( $cart_page ) {
            update_option( 'woocommerce_cart_page_id', $cart_page->ID );
        }
        
        $checkout_page = get_page_by_title( 'Checkout' );
        if ( $checkout_page ) {
            update_option( 'woocommerce_checkout_page_id', $checkout_page->ID );
        }
        
        $myaccount_page = get_page_by_title( 'My Account' );
        if ( $myaccount_page ) {
            update_option( 'woocommerce_myaccount_page_id', $myaccount_page->ID );
        }*/
        
        update_option( 'woocommerce_enable_myaccount_registration', 'yes' );
        
        
        /* Elementor: Default post types */
        $elementor_cpt = get_option( 'elementor_cpt_support', array() );
        if ( empty( $elementor_cpt ) ) {
            $elementor_cpt = array( 'page', 'post', 'portfolio' );
            update_option( 'elementor_cpt_support', $elementor_cpt );
        } else if ( ! in_array( 'portfolio', $elementor_cpt ) ) {
            $elementor_cpt[] = 'portfolio';
            update_option( 'elementor_cpt_support', $cpt_support );
        }
    }
        
    
    /*
	 * Content - AJAX: Install -> Settings -> Theme options
	 */
    function content_install_theme_options() {
        if ( class_exists( 'Redux' ) ) {
            global $nm_theme_options;
            
            $nm_theme_options = get_option( 'nm_theme_options' );
            if ( ! $nm_theme_options ) {
                require( NM_DIR . '/options/default-options.php' );
            }
            
            $setup_options = array(
                'home_header_border' => 0,
                'footer_bar_text' => '&copy; By <a href="#">NordicMade</a>',
                'footer_bar_content' => 'social_icons',
                'shop_page_id' => 757, // "Home - Banner Slider" page ID
                'shop_filters' => 'header',
                'single_product_sale_flash' => 'pct',
                'wishlist_page_id' => 21,
                'wishlist_show_variations' => 1,
                'wishlist_share' => 1,
                'blog_categories_hide_empty' => 1,
                'social_profiles' => array(
                    'facebook' => 'https://www.facebook.com',
                    'instagram' => 'https://www.instagram.com',
                    'twitter' => 'https://www.twitter.com',
                    'flickr' => '',
                    'linkedin' => '',
                    'pinterest' => '',
                    'rss' => '',
                    'snapchat' => '',
                    'behance' => '',
                    'dribbble' => '',
                    'soundcloud' => '',
                    'tumblr' => '',
                    'vimeo' => '',
                    'vk' => '',
                    'weibo' => '',
                    'youtube' => ''
                )
            );
            
            foreach( $setup_options as $option => $value ) {
                if ( isset( $nm_theme_options[$option] ) ) {
                    $nm_theme_options[$option] = $value;
                    Redux::setOption( 'nm_theme_options', $option, $value );
                }
            }
            
            // Update theme-options option
            update_option( 'nm_theme_options', $nm_theme_options );
            
            // Re-generate theme styles after updating options
            //nm_custom_styles_generate();
        }
    }
    
    
    /*
	 * Content - AJAX: Install -> Settings -> Color widget option
	 */
    function content_install_color_widget_option() {
        $colors = array( 'blue' => '#1e73be', 'brown' => '#736751', 'gray' => '#c0c0c0', 'green' => '#05ac92', 'orange' => '#dc9814', 'white' => '#ffffff' );
        $color_attributes = get_terms( 'pa_color' );
        $colors_option = array();

        // Create option array
        foreach( $color_attributes as $color_attribute ) {
            if ( isset( $colors[$color_attribute->slug] ) ) {
                $colors_option[$color_attribute->term_id] = $colors[$color_attribute->slug];
            }
        }

        if ( ! empty( $colors_option ) ) {
            update_option( 'nm_pa_colors', $colors_option );
        }
    }
    
    
    /*
	 * Content - AJAX: Install -> Settings -> Delete default post
	 */
    function content_install_delete_default_post() {
        $default_post = get_page_by_title( 'Hello world!', OBJECT, 'post' );
        if ( $default_post ) {
            wp_delete_post( $default_post->ID );
        }
    }
    
    
    /*
	 * Content - AJAX: Install -> Settings -> Permalnks
	 */
    function content_install_permalinks() {
        if ( ! $this->completed_task_settings ) {
            global $wp_rewrite;
            $wp_rewrite->set_permalink_structure( '/%year%/%monthnum%/%day%/%postname%/' );
            //$wp_rewrite->set_permalink_structure( '/%postname%/' );
            update_option( 'rewrite_rules', false );
            $wp_rewrite->flush_rules( true );
        }
    }
    
    
    /*
	 * Content - AJAX: Install -> Settings -> Set completed task options
	 */
    function content_install_set_completed_task( $task ) {
        $completed_tasks = get_option( 'nm_setup_tasks_completed', array() );
                
        array_push( $completed_tasks, $task );
        
        update_option( 'nm_setup_tasks_completed', $completed_tasks );
    }
	
}

$nm_setup = new NM_Setup();
