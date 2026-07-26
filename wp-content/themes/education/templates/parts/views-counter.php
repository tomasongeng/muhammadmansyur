<?php if (themerex_get_theme_option('use_ajax_views_counter')=='yes') { ?>
<!-- Post/page views count increment -->
<script type="text/javascript">
	jQuery(document).ready(function() {
		setTimeout(function(){
			jQuery.post(THEMEREX_GLOBALS['ajax_url'], {
				action: 'post_counter',
				nonce: THEMEREX_GLOBALS['ajax_nonce'],
				post_id: <?php echo (int) $post_data['post_id']; ?>,
                <?php if ( function_exists( 'trx_addons_plugin_post_data_atts' )){ ?>
				views: <?php echo (int) $post_data['post_views'];
                    } ?>
			});
		}, 10);
	});
</script>
<?php } ?>
