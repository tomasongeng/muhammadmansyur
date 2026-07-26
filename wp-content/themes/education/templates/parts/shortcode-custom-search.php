<div <?php
    echo ($id ? ' id="'.esc_attr($id).'"' : '') . ' class="custom_search_wrap search_style_' .esc_attr($style)
        . (!themerex_sc_param_is_off($open) ? ' search_opened' : '')
        . ($open=='fixed' ? ' search_fixed' : '')
        . (themerex_sc_param_is_on($ajax) ? ' search_ajax' : '')
        . ($class ? ' '.esc_attr($class) : '')
        . '"'
        . ($css!='' ? ' style="'.esc_attr($css).'"' : '')
        . (!themerex_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(themerex_sc_get_animation_classes($animation)).'"' : '')
        . '>';
    ?>
        <div class="search_form_wrap">
		    <form role="search" method="get" class="search_form" action="<?php echo esc_url( home_url( '/' ) ) ?>">
                <input type="hidden" name="post_type" value="<?php themerex_show_layout($post_type) ?>">
                <input type="hidden" name="custom_search" value="true">
                <div class="fields_group">
                    <?php if (!empty($title)) : ?>
                        <label><?php themerex_show_layout($title) ?></label>
                    <?php endif; ?>
                    <input type="text" class="search_field"
                           value="<?php echo esc_attr(get_search_query()) ?>"
                           name="s"
                           title="<?php echo esc_attr($title) ?>" />
                </div>
                <?php if (themerex_sc_param_is_on($use_tags) && !empty($terms)) : ?>
                    <div class="fields_group">
                        <?php if (!empty($tags_title)) :?>
                            <label><?php themerex_show_layout($tags_title) ?></label>
                        <?php endif; ?>
                        <select name="<?php themerex_show_layout($tags_slug); ?>">
                            <option value=""><?php _e('All', 'education') ?></option>
                            <?php
                            foreach ($terms as $term) { ?>
                                <option value="<?php themerex_show_layout($term->slug) ?>"><?php themerex_show_layout($term->name) ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                <?php endif; ?>
                <?php if (themerex_sc_param_is_on($categories) && !empty($categories)) :?>
                    <div class="fields_group">
                        <?php if (!empty($categories_title)) : ?>
                            <label><?php themerex_show_layout($categories_title) ?></label>
                        <?php endif; ?>
                        <select name="<?php themerex_show_layout($categories_slug); ?>">
                            <option value=""><?php _e('All', 'education') ?></option>
                            <?php
                            foreach ($categories as $cat) {
                                ?>
                                <option value="<?php themerex_show_layout($cat->slug) ?>"><?php themerex_show_layout($cat->name) ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                <?php endif; ?>
                <button type="submit" class="search_submit title="<?php _e('Start search', 'education') ?>">
                    <?php echo (!empty($button) ) ? $button : '' ;?>
                </button>
            </form>
        </div>
<!--        <div class="search_results widget_area bg_tint_light"><a class="search_results_close icon-delete-2"></a><div class="search_results_content"></div></div>-->
</div>