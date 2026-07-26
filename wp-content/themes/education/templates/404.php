<?php
/*
 * The template for displaying "Page 404"
*/

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'themerex_template_404_theme_setup' ) ) {
	add_action( 'themerex_action_before_init_theme', 'themerex_template_404_theme_setup', 1 );
	function themerex_template_404_theme_setup() {
		themerex_add_template(array(
			'layout' => '404',
			'mode'   => 'internal',
			'title'  => 'Page 404',
			'theme_options' => array(
				'article_style' => 'stretch'
			),
			'w'		 => null,
			'h'		 => null
			));
	}
}

// Template output
if ( !function_exists( 'themerex_template_404_output' ) ) {
	function themerex_template_404_output() {
		?>
		<article class="post_item post_item_404">
			<div class="post_content">
				<h1 class="page_title"><?php _e( '404', 'education' ); ?></h1>
				<h2 class="page_subtitle"><?php _e('The requested page cannot be found', 'education'); ?></h2>
				<p class="page_description"><?php echo sprintf( __('Can\'t find what you need? Take a moment and do a search below or start from <a href="%s">our homepage</a>.', 'education'), home_url() ); ?></p>
				<div class="page_search"><?php if(function_exists('themerex_sc_search')) echo themerex_sc_search(array( 'style'=>"flat", 'open'=>"fixed", 'title'=>__('Search here...', 'education'))); ?></div>
			</div>
		</article>
		<?php
	}
}
?>