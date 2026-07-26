<?php
/**
 * ThemeREX Framework: Testimonial post type settings
 *
 * @package	themerex
 * @since	themerex 1.0
 */

// Theme init
if (!function_exists('themerex_testimonial_theme_setup')) {
	add_action( 'themerex_action_before_init_theme', 'themerex_testimonial_theme_setup' );
	function themerex_testimonial_theme_setup() {
	
		// Add item in the admin menu
        add_filter('trx_addons_filter_override_options', 			'themerex_testimonial_add_override_options');

		// Save data from meta box
		add_action('save_post',				'themerex_testimonial_save_data');

		// Meta box fields
		global $THEMEREX_GLOBALS;
		$THEMEREX_GLOBALS['testimonial_override_options'] = array(
			'id' => 'testimonial-override-options',
			'title' => __('Testimonial Details', 'education'),
			'page' => 'testimonial',
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				"testimonial_author" => array(
					"title" => __('Testimonial author',  'education'),
					"desc" => __("Name of the testimonial's author", 'education'),
					"class" => "testimonial_author",
					"std" => "",
					"type" => "text"),
				"testimonial_email" => array(
					"title" => __("Author's e-mail",  'education'),
					"desc" => __("E-mail of the testimonial's author - need to take Gravatar (if registered)", 'education'),
					"class" => "testimonial_email",
					"std" => "",
					"type" => "text"),
				"testimonial_link" => array(
					"title" => __('Testimonial link',  'education'),
					"desc" => __("URL of the testimonial source or author profile page", 'education'),
					"class" => "testimonial_link",
					"std" => "",
					"type" => "text")
			)
		);
		
		// Prepare type "Testimonial"
		themerex_require_data( 'post_type', 'testimonial', array(
			'label'               => __( 'Testimonial', 'education' ),
			'description'         => __( 'Testimonial Description', 'education' ),
			'labels'              => array(
				'name'                => _x( 'Testimonials', 'Post Type General Name', 'education' ),
				'singular_name'       => _x( 'Testimonial', 'Post Type Singular Name', 'education' ),
				'menu_name'           => __( 'Testimonials', 'education' ),
				'parent_item_colon'   => __( 'Parent Item:', 'education' ),
				'all_items'           => __( 'All Testimonials', 'education' ),
				'view_item'           => __( 'View Item', 'education' ),
				'add_new_item'        => __( 'Add New Testimonial', 'education' ),
				'add_new'             => __( 'Add New', 'education' ),
				'edit_item'           => __( 'Edit Item', 'education' ),
				'update_item'         => __( 'Update Item', 'education' ),
				'search_items'        => __( 'Search Item', 'education' ),
				'not_found'           => __( 'Not found', 'education' ),
				'not_found_in_trash'  => __( 'Not found in Trash', 'education' ),
			),
			'supports'            => array( 'title', 'editor', 'author', 'thumbnail'),
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => true,
			'menu_icon'			  => 'dashicons-cloud',
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 25,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'capability_type'     => 'page',
			)
		);
		
		// Prepare taxonomy for testimonial
		themerex_require_data( 'taxonomy', 'testimonial_group', array(
			'post_type'			=> array( 'testimonial' ),
			'hierarchical'      => true,
			'labels'            => array(
				'name'              => _x( 'Testimonials Group', 'taxonomy general name', 'education' ),
				'singular_name'     => _x( 'Group', 'taxonomy singular name', 'education' ),
				'search_items'      => __( 'Search Groups', 'education' ),
				'all_items'         => __( 'All Groups', 'education' ),
				'parent_item'       => __( 'Parent Group', 'education' ),
				'parent_item_colon' => __( 'Parent Group:', 'education' ),
				'edit_item'         => __( 'Edit Group', 'education' ),
				'update_item'       => __( 'Update Group', 'education' ),
				'add_new_item'      => __( 'Add New Group', 'education' ),
				'new_item_name'     => __( 'New Group Name', 'education' ),
				'menu_name'         => __( 'Testimonial Group', 'education' ),
			),
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'testimonial_group' ),
			)
		);
	}
}


// Add meta box
if (!function_exists('themerex_testimonial_add_override_options')) {
	//Handler of add_action('admin_menu', 'themerex_testimonial_add_override_options');
	function themerex_testimonial_add_override_options($boxes=array()) {
        $boxes[] = array_merge(themerex_get_global('testimonial_override_options'), array('callback' => 'themerex_testimonial_show_override_options'));
        return $boxes;
	}
}

// Callback function to show fields in meta box
if (!function_exists('themerex_testimonial_show_override_options')) {
	function themerex_testimonial_show_override_options() {
		global $post, $THEMEREX_GLOBALS;

		// Use nonce for verification
		echo '<input type="hidden" name="override_options_testimonial_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
		
		$data = get_post_meta($post->ID, 'testimonial_data', true);
	
		$fields = $THEMEREX_GLOBALS['testimonial_override_options']['fields'];
		?>
		<table class="testimonial_area">
		<?php
		foreach ($fields as $id=>$field) { 
			$meta = isset($data[$id]) ? $data[$id] : '';
			?>
			<tr class="testimonial_field <?php echo esc_attr($field['class']); ?>" valign="top">
				<td><label for="<?php echo esc_attr($id); ?>"><?php echo esc_attr($field['title']); ?></label></td>
				<td><input type="text" name="<?php echo esc_attr($id); ?>" id="<?php echo esc_attr($id); ?>" value="<?php echo esc_attr($meta); ?>" size="30" />
					<br><small><?php echo esc_attr($field['desc']); ?></small></td>
			</tr>
			<?php
		}
		?>
		</table>
		<?php
	}
}


// Save data from meta box
if (!function_exists('themerex_testimonial_save_data')) {
	//Handler of add_action('save_post', 'themerex_testimonial_save_data');
	function themerex_testimonial_save_data($post_id) {
		// verify nonce
		if (!isset($_POST['override_options_testimonial_nonce']) || !wp_verify_nonce($_POST['override_options_testimonial_nonce'], basename(__FILE__))) {
			return $post_id;
		}

		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}

		// check permissions
		if ($_POST['post_type']!='testimonial' || !current_user_can('edit_post', $post_id)) {
			return $post_id;
		}

		global $THEMEREX_GLOBALS;

		$data = array();

		$fields = $THEMEREX_GLOBALS['testimonial_override_options']['fields'];

		// Post type specific data handling
		foreach ($fields as $id=>$field) { 
			if (isset($_POST[$id])) 
				$data[$id] = stripslashes($_POST[$id]);
		}

		update_post_meta($post_id, 'testimonial_data', $data);
	}
}
?>