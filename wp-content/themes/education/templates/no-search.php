<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'themerex_template_no_search_theme_setup' ) ) {
	add_action( 'themerex_action_before_init_theme', 'themerex_template_no_search_theme_setup', 1 );
	function themerex_template_no_search_theme_setup() {
		themerex_add_template(array(
			'layout' => 'no-search',
			'mode'   => 'internal',
			'title'  => __('No search results found', 'education'),
			'w'		 => null,
			'h'		 => null
		));
	}
}

// Template output
if ( !function_exists( 'themerex_template_no_search_output' ) ) {
	function themerex_template_no_search_output($post_options, $post_data) {
		?>
		<article class="post_item">
			<div class="post_content">
				<h2 class="post_title"><?php _e('Search Results for:', 'education'); ?></h2>
				<h1 class="post_subtitle"><?php echo get_search_query(); ?></h1>
				<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'education' ); ?></p>
				<p><?php echo sprintf(__('Go back, or return to <a href="%s">%s</a> home page to choose a new page.', 'education'), home_url(), get_bloginfo()); ?>
				<br><?php _e('Please report any broken links to our team.', 'education'); ?></p>
				<?php if(function_exists('themerex_sc_search')) echo themerex_sc_search( array('open'=>"fixed") ); ?>
			</div>	<!-- /.post_content -->
		</article>	<!-- /.post_item -->
		<?php
	}
}
?>