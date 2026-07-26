<?php
/* GDPR Framework support functions
------------------------------------------------------------------------------- */



// Filter to add in the required plugins list
if ( !function_exists( 'themerex_gdpr_required_plugins' ) ) {
	add_filter('themerex_filter_required_plugins',	'themerex_gdpr_required_plugins');
	function themerex_gdpr_required_plugins($list=array()) {
            if (in_array('gdpr-framework', (array)themerex_get_global('required_plugins'))){
                $list[] = array(
                    'name' 		=> esc_html__('GDRP Framework', 'education'),
                    'slug' 		=> 'gdpr-framework',
                    'required' 	=> false
                );
            }
		return $list;
	}
}

// Check if cf7 installed and activated
if ( !function_exists( 'themerex_exists_gdpr' ) ) {
	function themerex_exists_gdpr() {
		return defined('GDPR_FRAMEWORK_VERSION');
	}
}
?>