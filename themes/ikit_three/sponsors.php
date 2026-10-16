<?php
/**
 * Template Name: Sponsors
 */
?>
<?php get_header();?>

<?php

// Get the nav item this page corresponds to
foreach($g_main_nav_menu_items_all as $main_nav_menu_item) {
    if($main_nav_menu_item->object_id == $post->ID) {
        $selected_main_nav_menu_item = $main_nav_menu_item;
        break;
    }
}

?>

<div class="page-header-3">
    <div class="page-header-3-title">
        <?php ikit_three_render_toc_title($post); ?>
    </div>
</div>


<table class="page-layout-4">
<tr>

    <!-- Hide so grid can fill remaining space -->
    <?php if(ikit_three_has_toc($post)) {?>
    <td class="page-layout-4-tools">
        <div class="page-layout-4-tool">
            <?php ikit_three_render_toc($post); ?>
        </div>
    </td>
    <?php } ?>

    <td class="page-layout-4-content">

        <table>
        <tr>
        <td class="page-layout-4-body">

            <div class="page-layout-4-body-grid">

                <div class="cat-plugin-fluid-grid grid"
                    cat_plugin_fluid_grid_layout_mode="fitRows"
                    cat_plugin_fluid_grid_breakpoint_body_size_num_cols="<?php echo ikit_three_get_page_layout_4_body_grid_num_cols($post, null); ?>"
                    cat_plugin_fluid_grid_breakpoint_body_size_classes="<?php echo IKIT_THREE_FLUID_GRID_BREAKPOINT_BODY_SIZE_CLASSES; ?>"
                    cat_plugin_fluid_grid_breakpoint_body_class="<?php echo IKIT_THREE_FLUID_GRID_BREAKPOINT_BODY_CLASS; ?>"
                >

                <?php
                    $post_count = 0;
                    global $g_national_sponsors;
                ?>

                <?php foreach($g_national_sponsors as $sponsor) { ?>

                    <?php
                    $sponsor_permalink = ikit_three_sponsor_get_permalink($sponsor->ID);
                    $sponsor_permalink_target = ikit_three_sponsor_get_permalink_target($sponsor->ID);
                    $attachment_image_src = wp_get_attachment_image_src(get_post_meta($sponsor->ID, IKIT_CUSTOM_FIELD_IKIT_SPONSOR_PRIMARY_IMAGE, true), 'full')
                    ?>

                    <div class="cat-plugin-fluid-grid-item grid-item">
                        <div class="grid-item-inner">
                            <div class="sponsor-category">Official</div>
                            <a class="link-block cat-plugin-click-redirect" cat_plugin_click_redirect_target="<?php echo $sponsor_permalink_target; ?>" cat_plugin_click_redirect_url="<?php echo $sponsor_permalink; ?>">
                                <div class="sponsor-image"><img alt="Official sponsor image" width="<?php echo round($attachment_image_src[1]/2); ?>px" src="<?php echo $attachment_image_src[0]; ?>"/></div>
                                <?php if($g_theme_options[IKIT_THREE_THEME_OPTION_SINGLE_ENABLED_IKIT_SPONSOR] == false) { ?>
                                    <div class="sponsor-description"><?php echo $sponsor->post_content; ?></div>
                                <?php } ?>
                            </a>
                        </div>
                    </div>

                    <?php $post_count++; ?>

                <?php } ?>


                <?php if(count($g_local_sponsors) > 0) { ?>

                    <?php $post_count = 0; ?>

                    <?php foreach($g_local_sponsors as $sponsor) { ?>

                        <?php
                        $sponsor_url = get_post_meta($sponsor->ID, IKIT_CUSTOM_FIELD_IKIT_SPONSOR_URL, true);
                        $sponsor_url_target = "_blank";

                        // Option to have sponsor detail page
                        if($g_theme_options[IKIT_THREE_THEME_OPTION_SINGLE_ENABLED_IKIT_SPONSOR] == true) {
                            $sponsor_url = get_permalink($sponsor->ID);
                            $sponsor_url_target = "_self";
                        }

                        $attachment_image_src = wp_get_attachment_image_src(get_post_meta($sponsor->ID, IKIT_CUSTOM_FIELD_IKIT_SPONSOR_PRIMARY_IMAGE, true), 'full')
                        ?>

                        <div class="cat-plugin-fluid-grid-item grid-item">
                            <div class="grid-item-inner">
                                <?php
                                $category = get_the_category($sponsor->ID);
                                if(count($category) > 0) {
                                    ?>
                                    <div class="sponsor-category">
                                        <?php echo $category[0]->name; ?>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="link-block cat-plugin-click-redirect" cat_plugin_click_redirect_target="<?php echo $sponsor_url_target; ?>" cat_plugin_click_redirect_url="<?php echo $sponsor_url; ?>">
                                    <div class="sponsor-image"><img alt="Local sponsor image" width="<?php echo round($attachment_image_src[1]/2); ?>px" src="<?php echo $attachment_image_src[0]; ?>"/></div>
                                    <?php if($g_theme_options[IKIT_THREE_THEME_OPTION_SINGLE_ENABLED_IKIT_SPONSOR] == false) { ?>
                                    <div class="sponsor-description"><?php echo $sponsor->post_content; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <?php $post_count++; ?>

                    <?php } ?>

                <?php } ?>

                </div>

            </div>

        </td>
        </tr>
        </table>

    </td>

</tr>
</table>

<?php get_footer();?>