<?php
/**
 * ThemeREX Framework: messages subsystem
 *
 * @package	themerex
 * @since	themerex 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('themerex_messages_theme_setup')) {
	add_action( 'themerex_action_before_init_theme', 'themerex_messages_theme_setup' );
	function themerex_messages_theme_setup() {
		// Core messages strings
		add_action('themerex_action_add_scripts_inline', 'themerex_messages_add_scripts_inline');
	}
}


/* Session messages
------------------------------------------------------------------------------------- */

if (!function_exists('themerex_get_error_msg')) {
	function themerex_get_error_msg() {
		global $THEMEREX_GLOBALS;
		return !empty($THEMEREX_GLOBALS['error_msg']) ? $THEMEREX_GLOBALS['error_msg'] : '';
	}
}

if (!function_exists('themerex_set_error_msg')) {
	function themerex_set_error_msg($msg) {
		global $THEMEREX_GLOBALS;
		$msg2 = themerex_get_error_msg();
		$THEMEREX_GLOBALS['error_msg'] = $msg2 . ($msg2=='' ? '' : '<br />') . ($msg);
	}
}

if (!function_exists('themerex_get_success_msg')) {
	function themerex_get_success_msg() {
		global $THEMEREX_GLOBALS;
		return !empty($THEMEREX_GLOBALS['success_msg']) ? $THEMEREX_GLOBALS['success_msg'] : '';
	}
}

if (!function_exists('themerex_set_success_msg')) {
	function themerex_set_success_msg($msg) {
		global $THEMEREX_GLOBALS;
		$msg2 = themerex_get_success_msg();
		$THEMEREX_GLOBALS['success_msg'] = $msg2 . ($msg2=='' ? '' : '<br />') . ($msg);
	}
}

if (!function_exists('themerex_get_notice_msg')) {
	function themerex_get_notice_msg() {
		global $THEMEREX_GLOBALS;
		return !empty($THEMEREX_GLOBALS['notice_msg']) ? $THEMEREX_GLOBALS['notice_msg'] : '';
	}
}

if (!function_exists('themerex_set_notice_msg')) {
	function themerex_set_notice_msg($msg) {
		global $THEMEREX_GLOBALS;
		$msg2 = themerex_get_notice_msg();
		$THEMEREX_GLOBALS['notice_msg'] = $msg2 . ($msg2=='' ? '' : '<br />') . ($msg);
	}
}


/* System messages (save when page reload)
------------------------------------------------------------------------------------- */
if (!function_exists('themerex_set_system_message')) {
	function themerex_set_system_message($msg, $status='info', $hdr='') {
		update_option('themerex_message', array('message' => $msg, 'status' => $status, 'header' => $hdr));
	}
}

if (!function_exists('themerex_get_system_message')) {
	function themerex_get_system_message($del=false) {
		$msg = get_option('themerex_message', false);
		if (!$msg)
			$msg = array('message' => '', 'status' => '', 'header' => '');
		else if ($del)
			themerex_del_system_message();
		return $msg;
	}
}

if (!function_exists('themerex_del_system_message')) {
	function themerex_del_system_message() {
		delete_option('themerex_message');
	}
}


/* Messages strings
------------------------------------------------------------------------------------- */

if (!function_exists('themerex_messages_add_scripts_inline')) {
	function themerex_messages_add_scripts_inline() {
		global $THEMEREX_GLOBALS;
		echo '<script type="text/javascript">'
			. 'jQuery(document).ready(function() {'
			// Strings for translation
			. 'THEMEREX_GLOBALS["strings"] = {'
				. 'bookmark_add: 		"' . addslashes(__('Add the bookmark', 'education')) . '",'
				. 'bookmark_added:		"' . addslashes(__('Current page has been successfully added to the bookmarks. You can see it in the right panel on the tab \'Bookmarks\'', 'education')) . '",'
				. 'bookmark_del: 		"' . addslashes(__('Delete this bookmark', 'education')) . '",'
				. 'bookmark_title:		"' . addslashes(__('Enter bookmark title', 'education')) . '",'
				. 'bookmark_exists:		"' . addslashes(__('Current page already exists in the bookmarks list', 'education')) . '",'
				. 'search_error:		"' . addslashes(__('Error occurs in AJAX search! Please, type your query and press search icon for the traditional search way.', 'education')) . '",'
				. 'email_confirm:		"' . addslashes(__('On the e-mail address <b>%s</b> we sent a confirmation email.<br>Please, open it and click on the link.', 'education')) . '",'
				. 'reviews_vote:		"' . addslashes(__('Thanks for your vote! New average rating is:', 'education')) . '",'
				. 'reviews_error:		"' . addslashes(__('Error saving your vote! Please, try again later.', 'education')) . '",'
				. 'error_like:			"' . addslashes(__('Error saving your like! Please, try again later.', 'education')) . '",'
				. 'error_global:		"' . addslashes(__('Global error text', 'education')) . '",'
				. 'name_empty:			"' . addslashes(__('The name can\'t be empty', 'education')) . '",'
				. 'name_long:			"' . addslashes(__('Too long name', 'education')) . '",'
				. 'email_empty:			"' . addslashes(__('Too short (or empty) email address', 'education')) . '",'
				. 'email_long:			"' . addslashes(__('Too long email address', 'education')) . '",'
				. 'email_not_valid:		"' . addslashes(__('Invalid email address', 'education')) . '",'
				. 'subject_empty:		"' . addslashes(__('The subject can\'t be empty', 'education')) . '",'
				. 'subject_long:		"' . addslashes(__('Too long subject', 'education')) . '",'
				. 'text_empty:			"' . addslashes(__('The message text can\'t be empty', 'education')) . '",'
				. 'text_long:			"' . addslashes(__('Too long message text', 'education')) . '",'
				. 'send_complete:		"' . addslashes(__("Send message complete!", 'education')) . '",'
				. 'send_error:			"' . addslashes(__('Transmit failed!', 'education')) . '",'
				. 'login_empty:			"' . addslashes(__('The Login field can\'t be empty', 'education')) . '",'
				. 'login_long:			"' . addslashes(__('Too long login field', 'education')) . '",'
				. 'login_success:		"' . addslashes(__('Login success! The page will be reloaded in 3 sec.', 'education')) . '",'
				. 'login_failed:		"' . addslashes(__('Login failed!', 'education')) . '",'
				. 'password_empty:		"' . addslashes(__('The password can\'t be empty and shorter then 4 characters', 'education')) . '",'
				. 'password_long:		"' . addslashes(__('Too long password', 'education')) . '",'
				. 'password_not_equal:	"' . addslashes(__('The passwords in both fields are not equal', 'education')) . '",'
				. 'registration_success:"' . addslashes(__('Registration success! Please log in!', 'education')) . '",'
				. 'registration_failed:	"' . addslashes(__('Registration failed!', 'education')) . '",'
				. 'geocode_error:		"' . addslashes(__('Geocode was not successful for the following reason:', 'education')) . '",'
				. 'googlemap_not_avail:	"' . addslashes(__('Google map API not available!', 'education')) . '",'
				. 'editor_save_success:	"' . addslashes(__("Post content saved!", 'education')) . '",'
				. 'editor_save_error:	"' . addslashes(__("Error saving post data!", 'education')) . '",'
				. 'editor_delete_post:	"' . addslashes(__("You really want to delete the current post?", 'education')) . '",'
				. 'editor_delete_post_header:"' . addslashes(__("Delete post", 'education')) . '",'
				. 'editor_delete_success:	"' . addslashes(__("Post deleted!", 'education')) . '",'
				. 'editor_delete_error:		"' . addslashes(__("Error deleting post!", 'education')) . '",'
				. 'editor_caption_cancel:	"' . addslashes(__('Cancel', 'education')) . '",'
				. 'editor_caption_close:	"' . addslashes(__('Close', 'education')) . '",'
			// Google Map
				. 'msg_sc_googlemap_not_avail:      "' . addslashes(__('Googlemap service is not available', 'education')) . '",'
				. 'msg_sc_googlemap_geocoder_error:	"' . addslashes(__('Error while geocode address', 'education')) . '",'
				. '};'
			. '});'
			. '</script>';
	}
}
?>