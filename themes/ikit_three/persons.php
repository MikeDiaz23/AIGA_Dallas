<?php
/**
 * Template Name: Persons
 */
?>
<?php get_header();?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post();
    global $id;
    global $post;

    // Get the posts
    $args = array();
    $args['posts_per_page'] = 999;
    $args['order'] = 'ASC';
    $args['post_status'] = 'publish';
    $args['post_type'] = array(IKIT_POST_TYPE_IKIT_PERSON);
    $args['orderby'] = 'meta_value';
    $args['meta_key'] = IKIT_CUSTOM_FIELD_GENERIC_ORDERING_DISPLAY_PRIORITY;

    // Filter
    $category_ids = wp_get_post_categories($post->ID);
    if(sizeof($category_ids) > 0) {
        $args['category__in'] = $category_ids;
    }

    $persons = get_posts($args);

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

                    foreach($persons as $person) {

                        $positions = ikit_person_get_positions($person->ID);
                        $images = ikit_person_get_images($person->ID);
                        $email = get_post_meta($person->ID, IKIT_CUSTOM_FIELD_IKIT_PERSON_EMAIL, true);

                        // Shows/hides data based on if the persons detail page theme option is enabled
                        if($g_theme_options[IKIT_THREE_THEME_OPTION_SINGLE_ENABLED_IKIT_PERSON] == true) {
                            $person_permalink = null;
                            $person_permalink = get_permalink($person->ID);
                        ?>

                            <div class="cat-plugin-fluid-grid-item grid-item person-item">
                                <div class="grid-item-inner">
                                    <a class="link-block" href="<?php echo $person_permalink; ?>">
                                        <?php if(!empty($images) && sizeof($images) > 0) { ?>
                                            <div class="person-item-image cat-plugin-anystretch-image link-block-image" cat_plugin_anystretch_image_alt="Person image" cat_plugin_anystretch_image_url="<?php $person_image = wp_get_attachment_image_src($images[0]['image'], 'full'); echo $person_image[0];?>"></div>
                                        <?php } ?>

                                        <div class="person-item-title">
                                            <?php echo $person->post_title; ?>
                                        </div>

                                        <?php if(!empty($positions) && sizeof($positions) > 0) { ?>
                                        <div class="person-item-positions">
                                            <?php for($i=0;$i<sizeof($positions);$i++) { ?>
                                                <span><?php echo $positions[$i]['title']; if($i != sizeof($positions) - 1) { echo ','; }; ?></span>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                    </a>
                                </div>
                            </div>

                        <?php } else { ?>

                            <div class="cat-plugin-fluid-grid-item grid-item person-item">
                                <div class="grid-item-inner">

                                    <?php if(!empty($images) && sizeof($images) > 0) { ?>
                                        <div class="person-item-image cat-plugin-anystretch-image" cat_plugin_anystretch_image_alt="Person image" cat_plugin_anystretch_image_url="<?php $person_image = wp_get_attachment_image_src($images[0]['image'], 'full'); echo $person_image[0];?>"></div>
                                    <?php } ?>

                                    <div class="person-item-title">
                                        <?php echo $person->post_title; ?>
                                    </div>

                                    <?php if(!empty($positions) && sizeof($positions) > 0) { ?>
                                    <div class="person-item-positions">
                                        <?php for($i=0;$i<sizeof($positions);$i++) { ?>
                                            <span><?php echo $positions[$i]['title']; if($i != sizeof($positions) - 1) { echo ','; }; ?></span>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>

                                    <div class="person-item-description">
                                        <?php echo $person->post_content; ?>
                                    </div>

                                    <?php if(empty($email) == false) { ?>
                                        <a class="box-button person-item-email" href="mailto:<?php echo $email; ?>">
                                            Email
                                        </a>
                                    <?php } ?>

                                </div>
                            </div>

                        <?php

                        }

                    }

                    ?>

                    </div>

                </div>

            </td>
            </tr>
            </table>

        </td>

    </tr>
    </table>

    <?php
endwhile;?>

<?php get_footer();?>