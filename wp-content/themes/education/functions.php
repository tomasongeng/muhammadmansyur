<?php
/**
 * Theme sprecific functions and definitions
 */


/* Theme setup section
------------------------------------------------------------------- */

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) $content_width = 1170; /* pixels */

// Add theme specific actions and filters
// Attention! Function were add theme specific actions and filters handlers must have priority 1
if ( !function_exists( 'themerex_theme_setup' ) ) {
	add_action( 'themerex_action_before_init_theme', 'themerex_theme_setup', 1 );
	function themerex_theme_setup() {

		// Register theme menus
		add_filter( 'themerex_filter_add_theme_menus',		'themerex_add_theme_menus' );

		// Register theme sidebars
		add_filter( 'themerex_filter_add_theme_sidebars',	'themerex_add_theme_sidebars' );
	// Set options for importer
		add_filter( 'themerex_filter_importer_options',		'themerex_set_importer_options' );

		// Add theme required plugins
		add_filter( 'themerex_filter_required_plugins',		'themerex_add_required_plugins' );

        // Add tags to the head
        add_action('wp_head', 'themerex_head_add_page_meta', 1);
		

		// Set theme name and folder (for the update notifier)
		add_filter('themerex_filter_update_notifier', 		'themerex_set_theme_names_for_updater');

        // Gutenberg support
        add_theme_support( 'align-wide' );

        themerex_set_global('required_plugins', array(
                'woocommerce',
                'additional_tags',
                'visual_composer',
                'revslider'
			)
		);

	if ( is_dir(THEMEREX_THEME_PATH . 'demo/') ) {
            themerex_set_global('demo_data_url',  THEMEREX_THEME_PATH . 'demo');
        } else {
            themerex_set_global('demo_data_url',  esc_url(themerex_get_protocol().'://demofiles.themerex.net/education') ); // Demo-site domain
        }
	}
}


// Add/Remove theme nav menus
if ( !function_exists( 'themerex_add_theme_menus' ) ) {
	//Handler of add_filter( 'themerex_action_add_theme_menus', 'themerex_add_theme_menus' );
	function themerex_add_theme_menus($menus) {
		
		//For example:
		//$menus['menu_footer'] = __('Footer Menu', 'education');
		//if (isset($menus['menu_panel'])) unset($menus['menu_panel']);
		
		if (isset($menus['menu_side'])) unset($menus['menu_side']);
		return $menus;
	}
}


// Add theme specific widgetized areas
if ( !function_exists( 'themerex_add_theme_sidebars' ) ) {
	//Handler of add_filter( 'themerex_filter_add_theme_sidebars',	'themerex_add_theme_sidebars' );
	function themerex_add_theme_sidebars($sidebars=array()) {
		if (is_array($sidebars)) {
			$theme_sidebars = array(
				'sidebar_main'		=> __( 'Main Sidebar', 'education' ),
				'sidebar_footer'	=> __( 'Footer Sidebar', 'education' )
			);
			if (themerex_exists_woocommerce()) {
				$theme_sidebars['sidebar_cart']  = __( 'WooCommerce Cart Sidebar', 'education' );
			}
			$sidebars = array_merge($theme_sidebars, $sidebars);
		}
		return $sidebars;
	}
}


// Add theme required plugins
if ( !function_exists( 'themerex_add_required_plugins' ) ) {
	//Handler of add_filter( 'themerex_filter_required_plugins',		'themerex_add_required_plugins' );
	function themerex_add_required_plugins($plugins) {
		$plugins[] = array(
			'name' 		=> esc_html__('Additional Tags', 'education'),
			'version'	=> '1.2.1',					// Minimal required version
			'slug' 		=> 'additional-tags',
			'source'	=> themerex_get_file_dir('plugins/additional-tags.zip'),
			'required' 	=> true
		);
		return $plugins;
	}
}

// Set theme name and folder (for the update notifier)
if ( !function_exists( 'themerex_set_theme_names_for_updater' ) ) {
	//Handler of add_filter('themerex_filter_update_notifier', 'themerex_set_theme_names_for_updater');
	function themerex_set_theme_names_for_updater($opt) {
		$opt['theme_name']   = 'Education';
		$opt['theme_folder'] = 'education';
		return $opt;
	}
}

// Return GET or POST value
if (!function_exists('themerex_get_value_gp')) {
	function themerex_get_value_gp($name, $defa='') {
		$rez = $defa;
		$magic = function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc() == 1;
		if (isset($_GET[$name])) {
			$rez = $magic ? stripslashes(trim($_GET[$name])) : trim($_GET[$name]);
		} else if (isset($_POST[$name])) {
			$rez = $magic ? stripslashes(trim($_POST[$name])) : trim($_POST[$name]);
		}
		return $rez;
	}
}


// AJAX: Login user
if ( !function_exists( 'themerex_users_login_user' ) ) {
	add_action('wp_ajax_themerex_login_user',			'themerex_users_login_user');
	add_action('wp_ajax_nopriv_themerex_login_user',	'themerex_users_login_user');
	function themerex_users_login_user() {
		
		if ( !wp_verify_nonce( wp_create_nonce(admin_url('admin-ajax.php')),  esc_url(admin_url('admin-ajax.php'))) )
			die();
		
		$user_log = substr($_REQUEST['user_log'], 0, 60);
		$user_pwd = substr($_REQUEST['user_pwd'], 0, 60);
		$remember = substr($_REQUEST['remember'], 0, 7)=='forever';
		
		$response = array(
			'error' => '',
			'redirect_to' => substr($_REQUEST['redirect_to'], 0, 200)
		);
		
		if ( is_email( $user_log ) ) {
			$user = get_user_by('email', $user_log );
			if ( $user ) $user_log = $user->user_login;
		}
		
		$rez = wp_signon( array(
			'user_login' => $user_log,
			'user_password' => $user_pwd,
			'remember' => $remember
		), false );
		
		if ( is_wp_error($rez) ) {
			$response['error'] = $rez->get_error_message();
		}
		
		echo json_encode($response);
		die();
	}
}

// Return text for the "I agree ..." checkbox
if ( ! function_exists( 'themerex_trx_addons_privacy_text' ) ) {
    add_filter( 'trx_addons_filter_privacy_text', 'themerex_trx_addons_privacy_text' );
    function themerex_trx_addons_privacy_text( $text='' ) {
        return themerex_get_privacy_text();
    }
}


// Add page meta to the head
if (!function_exists('themerex_head_add_page_meta')) {
    //Handler of add_action('wp_head', 'themerex_head_add_page_meta', 1);
    function themerex_head_add_page_meta() {
        $theme_skin = themerex_esc(themerex_get_custom_option('theme_skin'));
        if (themerex_get_theme_option('responsive_layouts') == 'yes') {
            ?>
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
            <?php
            }
        ?>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <?php
        $favicon = themerex_get_custom_option('favicon');
        if (!$favicon) {
            if ( file_exists(themerex_get_file_dir('skins/'.($theme_skin).'/images/favicon.ico')) )
                $favicon = themerex_get_file_url('skins/'.($theme_skin).'/images/favicon.ico');
            if ( !$favicon && file_exists(themerex_get_file_dir('favicon.ico')) )
                $favicon = themerex_get_file_url('favicon.ico');
    }
        if ($favicon) {
            ?>
            <link rel="icon" type="image/x-icon" href="<?php echo esc_url($favicon); ?>" />
            <?php
    }
    }
}

// Add theme required plugins
if ( !function_exists( 'themerex_add_trx_addons' ) ) {
    add_filter( 'trx_addons_active', 'themerex_add_trx_addons' );
    function themerex_add_trx_addons($enable=true) {
        return true;
    }
}

/* Include framework core files
------------------------------------------------------------------- */

require_once( get_template_directory().'/fw/loader.php' );

if ( !function_exists( 'themerex_custom_search_by_title' ) ) {
    function themerex_custom_search_by_title($search, $wp_query)
    {
        if (isset($_REQUEST['custom_search'])
            && !empty($search)
            && !empty($wp_query->query_vars['search_terms'])
        ) {
            global $wpdb;

            $q = $wp_query->query_vars;
            $n = !empty($q['exact']) ? '' : '%';

            $search = array();

            foreach (( array )$q['search_terms'] as $term)
                $search[] = $wpdb->prepare("$wpdb->posts.post_title LIKE %s", $n . $wpdb->esc_like($term) . $n);

            if (!is_user_logged_in())
                $search[] = "$wpdb->posts.post_password = ''";

            $search = ' AND ' . implode(' AND ', $search);
        }

        return $search;
    }

    add_filter('posts_search', 'themerex_custom_search_by_title', 10, 2);
}


if ( !function_exists( 'themerex_enqueue_comments_reply' ) ) {
	function themerex_enqueue_comments_reply()
	{
		if (get_option('thread_comments')) {
			wp_enqueue_script('comment-reply');
		}
	}

	add_action('comment_form_before', 'themerex_enqueue_comments_reply');
}

?>