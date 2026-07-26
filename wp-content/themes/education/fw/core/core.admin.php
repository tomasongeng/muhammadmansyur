<?php
/**
 * ThemeREX Framework: Admin functions
 *
 * @package	themerex
 * @since	themerex 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* Admin actions and filters:
------------------------------------------------------------------------ */

if (is_admin()) {

	/* Theme setup section
	-------------------------------------------------------------------- */
	
	if ( !function_exists( 'themerex_admin_theme_setup' ) ) {
		add_action( 'themerex_action_before_init_theme', 'themerex_admin_theme_setup', 11 );
		function themerex_admin_theme_setup() {
			if ( is_admin() ) {
				add_action("admin_head",			'themerex_admin_prepare_scripts');
				add_action("admin_enqueue_scripts",	'themerex_admin_load_scripts');
				add_action('tgmpa_register',		'themerex_admin_register_plugins');

				// AJAX: Get terms for specified post type
				add_action('wp_ajax_themerex_admin_change_post_type', 		'themerex_callback_admin_change_post_type');
				add_action('wp_ajax_nopriv_themerex_admin_change_post_type','themerex_callback_admin_change_post_type');
			}
		}
	}

	// Load required styles and scripts for admin mode
	if ( !function_exists( 'themerex_admin_load_scripts' ) ) {
		//Handler of add_action("admin_enqueue_scripts", 'themerex_admin_load_scripts');
		function themerex_admin_load_scripts() {
			wp_enqueue_script( 'themerex-debug-script', themerex_get_file_url('js/core.debug.js'), array('jquery'), null, true );
				wp_enqueue_style( 'themerex-admin-style', themerex_get_file_url('css/core.admin.css'), array(), null );
			if (themerex_strpos(add_query_arg(array()), 'widgets.php')!==false) {
				wp_enqueue_style( 'themerex-fontello-style', themerex_get_file_url('css/fontello-admin/css/fontello-admin.css'), array(), null );
				wp_enqueue_style( 'themerex-animations-style', themerex_get_file_url('css/fontello-admin/css/animation.css'), array(), null );
				wp_enqueue_script( 'themerex-admin-script', themerex_get_file_url('js/core.admin.js'), array('jquery'), null, true );
			}
		}
	}

	// Prepare required styles and scripts for admin mode
	if ( !function_exists( 'themerex_admin_prepare_scripts' ) ) {
		//Handler of add_action("admin_head", 'themerex_admin_prepare_scripts');
		function themerex_admin_prepare_scripts() {
			?>
			<script>
				if (typeof THEMEREX_GLOBALS == 'undefined') var THEMEREX_GLOBALS = {};
				jQuery(document).ready(function() {
					THEMEREX_GLOBALS['admin_mode']	= true;
					THEMEREX_GLOBALS['ajax_nonce'] 	= "<?php echo wp_create_nonce('ajax_nonce'); ?>";
					THEMEREX_GLOBALS['ajax_url']	= "<?php echo admin_url('admin-ajax.php'); ?>";
					THEMEREX_GLOBALS['user_logged_in'] = true;
				});
			</script>
			<?php
		}
	}
	
	// AJAX: Get terms for specified post type
	if ( !function_exists( 'themerex_callback_admin_change_post_type' ) ) {
		//Handler of add_action('wp_ajax_themerex_admin_change_post_type', 		'themerex_callback_admin_change_post_type');
		//Handler of add_action('wp_ajax_nopriv_themerex_admin_change_post_type',	'themerex_callback_admin_change_post_type');
		function themerex_callback_admin_change_post_type() {
			if ( !wp_verify_nonce( $_REQUEST['nonce'], 'ajax_nonce' ) )
				die();
			$post_type = $_REQUEST['post_type'];
			$terms = themerex_get_list_terms(false, themerex_get_taxonomy_categories_by_post_type($post_type));
			$terms = themerex_array_merge(array(0 => esc_html__('- Select category -', 'education')), $terms);
			$response = array(
				'error' => '',
				'data' => array(
					'ids' => array_keys($terms),
					'titles' => array_values($terms)
				)
			);
			echo json_encode($response);
			die();
		}
	}

	// Return current post type in dashboard
	if ( !function_exists( 'themerex_admin_get_current_post_type' ) ) {
		function themerex_admin_get_current_post_type() {
			global $post, $typenow, $current_screen;
			if ( $post && $post->post_type )							//we have a post so we can just get the post type from that
				return $post->post_type;
			else if ( $typenow )										//check the global $typenow — set in admin.php
				return $typenow;
			else if ( $current_screen && $current_screen->post_type )	//check the global $current_screen object — set in sceen.php
				return $current_screen->post_type;
			else if ( isset( $_REQUEST['post_type'] ) )					//check the post_type querystring
				return sanitize_key( $_REQUEST['post_type'] );
			else if ( isset( $_REQUEST['post'] ) ) {					//lastly check the post id querystring
				$post = get_post( sanitize_key( $_REQUEST['post'] ) );
				return !empty($post->post_type) ? $post->post_type : '';
			} else														//we do not know the post type!
				return '';
		}
	}

    // Add admin menu pages
    if ( !function_exists( 'themerex_admin_add_menu_item' ) ) {
        function themerex_admin_add_menu_item($mode, $item, $pos='100') {
            static $shift = 0;
            if ($pos=='100') $pos .= '.'.$shift++;
            $fn = join('_', array('add', $mode, 'page'));
            if (empty($item['parent']))
                $fn($item['page_title'], $item['menu_title'], $item['capability'], $item['menu_slug'], $item['callback'], $item['icon'], $pos);
            else
                $fn($item['parent'], $item['page_title'], $item['menu_title'], $item['capability'], $item['menu_slug'], $item['callback'], $item['icon'], $pos);
        }
    }

	// Register optional plugins
	if ( !function_exists( 'themerex_admin_register_plugins' ) ) {
		function themerex_admin_register_plugins() {
			$plugins = apply_filters('themerex_filter_required_plugins', array(
				array(
					'name' 		=> 'WooCommerce',
					'slug' 		=> 'woocommerce',
					'required' 	=> false
				),
				array(
					'name' 		=> 'WPBakery PageBuilder',
					'slug' 		=> 'js_composer',
					'source'	=> themerex_get_file_dir('plugins/js_composer.zip'),
					'required' 	=> false
				),
				array(
					'name' 		=> 'Revolution Slider',
					'slug' 		=> 'revslider',
					'source'	=> themerex_get_file_dir('plugins/revslider.zip'),
					'required' 	=> false
				),
				array(
					'name' 		=> 'Tribe Events Calendar',
					'slug' 		=> 'the-events-calendar',
					'required' 	=> false
				),
//				array(
//                    'name' 		=> 'Additional Tags',
//                    'slug' 		=> 'additional-tags',
//                    'source'	=> themerex_get_file_dir('plugins/additional-tags.zip'),
//                    'required' 	=> true
//                ),
				array(
					'name' 		=> 'Instagram Widget',
					'slug' 		=> 'wp-instagram-widget',
					'required' 	=> false
				),
                array(
                    'name' 		=> 'GDPR Framework',
                    'slug' 		=> 'gdpr-framework',
                    'required' 	=> false
                ),
			));
			$config = array(
				'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
				'default_path' => '',                      // Default absolute path to bundled plugins.
				'menu'         => 'tgmpa-install-plugins', // Menu slug.
				'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
				'has_notices'  => true,                    // Show admin notices or not.
				'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
				'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
				'is_automatic' => true,                    // Automatically activate plugins after installation or not.
				'message'      => ''                       // Message to output right before the plugins table.
			);
	
			tgmpa( $plugins, $config );
		}
	}

	require_once( themerex_get_file_dir('lib/tgm/class-tgm-plugin-activation.php') );
}

?>