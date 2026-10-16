<?php
/**
 * Template Name: Section Table of Contents Alt 1 (Manual)
 */
 ?>

 <?php get_header();?>

 <?php if ( have_posts() ) while ( have_posts() ) : the_post();
    global $id;
    global $post;
    ?>

    <div class="page-header-3">
        <div class="page-header-3-title">
            <?php the_title(); ?>
        </div>
    </div>

    <table class="page-layout-4">
    <tr>

        <td class="page-layout-4-content">

            <table>
            <tr>
            <td class="page-layout-4-body">

                <div class="page-layout-4-body-description">
                    <div class="page-layout-4-body-description-inner">
                        <?php the_content();?>
                    </div>
                </div>

                <div class="page-layout-4-body-grid">
                    <div class="cat-plugin-fluid-grid grid items"
                        cat_plugin_fluid_grid_layout_mode="fitRows"
                        cat_plugin_fluid_grid_breakpoint_body_size_num_cols="<?php echo ikit_three_get_page_layout_4_body_grid_num_cols($post, 'section-toc-sidebar'); ?>"
                        cat_plugin_fluid_grid_breakpoint_body_size_classes="<?php echo IKIT_THREE_FLUID_GRID_BREAKPOINT_BODY_SIZE_CLASSES; ?>"
                        cat_plugin_fluid_grid_breakpoint_body_class="<?php echo IKIT_THREE_FLUID_GRID_BREAKPOINT_BODY_CLASS; ?>"
                    >

                        <?php

                        $content_items = get_field(IKIT_THREE_CUSTOM_FIELD_PAGE_TEMPLATE_SECTION_TOC_ALT_1_CONTENT_ITEMS, $id);
                        foreach($content_items as $content_item) {
                            ?>
                                <div class="cat-plugin-fluid-grid-item grid-item item">
                                    <div class="grid-item-inner">
                                        <?php if(empty($content_item['link_url']) == false) { ?>
                                        <a class="link-block" target="<?php echo $content_item['link_target']; ?>" href="<?php echo $content_item['link_url']; ?>">
                                        <?php } ?>
                                            <div class="box-item">
                                                <div class="item-title"><?php echo $content_item['title']; ?></div>
                                                <?php if(empty($content_item['description']) == false) { ?>
                                                    <div class="item-description"><?php echo $content_item['description']; ?></div>
                                                <?php } ?>
                                            </div>
                                        <?php if(empty($content_item['link_url']) == false) { ?>
                                        </a>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php
                        }

                        ?>

                    </div>
                </div>

            </td>
            <?php if(is_active_sidebar('section-toc-sidebar')) { ?>
                <td class="page-layout-4-sidebar">
                    <?php dynamic_sidebar('section-toc-sidebar');?>
                </td>
            <?php } ?>
            </tr>
            </table>

        </td>

    </tr>
    </table>

    <?php
endwhile;?>

<?php get_footer();?>
