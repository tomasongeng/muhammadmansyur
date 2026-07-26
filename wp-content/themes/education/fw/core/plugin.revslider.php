<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Check if RevSlider installed and activated
if ( !function_exists( 'themerex_exists_revslider' ) ) {
	function themerex_exists_revslider() {
		return function_exists('rev_slider_shortcode');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'themerex_revslider_required_plugins' ) ) {
	//Handler of add_filter('themerex_filter_required_plugins',	'themerex_revslider_required_plugins');
	function themerex_revslider_required_plugins($list=array()) {
		if (in_array('revslider', (array)themerex_get_global('required_plugins'))) {
//			$path = themerex_get_file_dir('plugins/install/revslider.zip');
			$path = themerex_get_file_dir('fw/plugins/revslider.zip');
			if (file_exists($path)) {
				$list[] = array(
					'name' 		=> esc_html__('Revolution Slider', 'education'),
					'slug' 		=> 'revslider',
					'source'	=> $path,
					'required' 	=> false
					);
			}
		}
		return $list;
	}
}


// Check if Additional tags installed and activated
if ( !function_exists( 'themerex_exists_additional_tags' ) ) {
    function themerex_exists_additional_tags() {
        return function_exists('themerex_additional_tags');
	}
}
?>