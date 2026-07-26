<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'themerex_template_no_articles_theme_setup' ) ) {
	add_action( 'themerex_action_before_init_theme', 'themerex_template_no_articles_theme_setup', 1 );
	function themerex_template_no_articles_theme_setup() {
		themerex_add_template(array(
			'layout' => 'no-articles',
			'mode'   => 'internal',
			'title'  => __('No articles found', 'education'),
			'w'		 => null,
			'h'		 => null
		));
	}
}

// Template output
if ( !function_exists( 'themerex_template_no_articles_output' ) ) {
	function themerex_template_no_articles_output($post_options, $post_data) {
		?>
		<article class="post_item">
			<div class="post_content">
				<h2 class="post_title"><?php _e('No posts found', 'education'); ?></h2>
				<p><?php _e( 'Sorry, but nothing matched your search criteria.', 'education' ); ?></p>
				<p><?php echo sprintf(__('Go back, or return to <a href="%s">%s</a> home page to choose a new page.', 'education'), home_url(), get_bloginfo()); ?>
				<br><?php _e('Please report any broken links to our team.', 'education'); ?></p>
				<?php if(function_exists('themerex_sc_search')) echo themerex_sc_search( array('open'=>"fixed") ); ?>
			</div>	<!-- /.post_content -->
		</article>	<!-- /.post_item -->
		<?php
	}
}
?>