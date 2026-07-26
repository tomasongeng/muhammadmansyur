<?php
/**
 * ThemeREX Framework
 *
 * @package themerex
 * @since themerex 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Framework directory path from theme root
if ( ! defined( 'THEMEREX_FW_DIR' ) )		define( 'THEMEREX_FW_DIR', '/fw/' );
if ( ! defined( 'THEMEREX_THEME_PATH' ) ) define( 'THEMEREX_THEME_PATH', 	trailingslashit( get_template_directory() ) );


// Theme timing
if ( ! defined( 'THEMEREX_START_TIME' ) )	define( 'THEMEREX_START_TIME', microtime());			// Framework start time
if ( ! defined( 'THEMEREX_START_MEMORY' ) )	define( 'THEMEREX_START_MEMORY', memory_get_usage());	// Memory usage before core loading

// Global variables storage
global $THEMEREX_GLOBALS;
$THEMEREX_GLOBALS = array(
	'page_template' => ''
);

/* Theme setup section
-------------------------------------------------------------------- */
if ( !function_exists( 'themerex_loader_theme_setup' ) ) {
	add_action( 'after_setup_theme', 'themerex_loader_theme_setup', 20 );
	function themerex_loader_theme_setup() {
		// Before init theme
		do_action('themerex_action_before_init_theme');

		// Load current values for main theme options
		themerex_load_main_options();

		// Theme core init - only for admin side. In frontend it called from header.php
		if ( is_admin() ) {
			themerex_core_init_theme();
		}
	}
}


/* Include core parts
------------------------------------------------------------------------ */
// core.strings must be first - we use themerex_str...() in the themerex_get_file_dir()
// core.files must be first - we use themerex_get_file_dir() to include all rest parts
require_once (file_exists(get_stylesheet_directory().(THEMEREX_FW_DIR).'core/core.strings.php') ? get_stylesheet_directory() : get_template_directory()).(THEMEREX_FW_DIR).'core/core.strings.php';
require_once (file_exists(get_stylesheet_directory().(THEMEREX_FW_DIR).'core/core.files.php') ? get_stylesheet_directory() : get_template_directory()).(THEMEREX_FW_DIR).'core/core.files.php';
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/core.admin.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/core.arrays.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/core.date.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/core.debug.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/core.globals.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/core.html.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/core.http.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/core.ini.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/core.lists.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/core.media.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/core.messages.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/core.reviews.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/core.templates.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/core.theme.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/core.updater.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/core.wp.php');

require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/core.customizer/core.customizer.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/core.options/core.options.php');

require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/plugin.bb-press.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/plugin.buddy-press.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/plugin.revslider.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/plugin.gdpr-framework.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/plugin.gutenberg.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/plugin.royalslider.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/plugin.tribe-events.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/plugin.visual-composer.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/plugin.widgets.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/plugin.woocommerce.php');

require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/type.attachment.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/type.post.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/type.post_type.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/type.taxonomy.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/type.team.php');
require_once themerex_get_file_dir(THEMEREX_FW_DIR . 'core/type.testimonials.php');

// Include custom theme files
require_once themerex_get_file_dir('includes/plugin.learndash.php');
require_once themerex_get_file_dir('includes/type.courses.php');
require_once themerex_get_file_dir('includes/type.lessons.php');

// Include theme templates
require_once themerex_get_file_dir('templates/404.php');
require_once themerex_get_file_dir('templates/accordion.php');
require_once themerex_get_file_dir('templates/attachment.php');
require_once themerex_get_file_dir('templates/date.php');
require_once themerex_get_file_dir('templates/excerpt.php');
require_once themerex_get_file_dir('templates/list.php');
require_once themerex_get_file_dir('templates/masonry.php');
require_once themerex_get_file_dir('templates/news.php');
require_once themerex_get_file_dir('templates/no-articles.php');
require_once themerex_get_file_dir('templates/no-search.php');
require_once themerex_get_file_dir('templates/portfolio.php');
require_once themerex_get_file_dir('templates/related.php');
require_once themerex_get_file_dir('templates/single-courses.php');
require_once themerex_get_file_dir('templates/single-portfolio.php');
require_once themerex_get_file_dir('templates/single-standard.php');
require_once themerex_get_file_dir('templates/single-team.php');
?>