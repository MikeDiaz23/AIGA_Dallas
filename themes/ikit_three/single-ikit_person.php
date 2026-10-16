<?php
/**
 * Template Name: Single Person
 */
?>

<?php get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post();
    global $id;

    // Get the hero image (if present)
    $images = ikit_person_get_images($id);
    $positions = ikit_person_get_positions($id);

    $post_image = null;
    if(sizeof($images) > 0) {
        if(sizeof($images) > 1) {
            $post_images = wp_get_attachment_image_src($images[1]['image'], 'full');
            $post_image = $post_images[0];
        }
        else {
            $post_images = wp_get_attachment_image_src($images[0]['image'], 'full');
            $post_image = $post_images[0];
        }
    }

    $email = get_post_meta($id, IKIT_CUSTOM_FIELD_IKIT_PERSON_EMAIL, true);

    ?>

    <div class="page-header-4">

        <?php if(empty($post_image) == false && $g_theme_options[IKIT_THREE_THEME_OPTION_PERSONS_SINGLE_SMALL_HERO_IMAGE_ENABLED] == false) { ?>
            <div class="page-header-4-title-container">
                <div class="page-header-4-title">
                    <?php the_title(); ?>
                    <div class="header-person-positions">
                        <?php for($i=0;$i<sizeof($positions);$i++) { ?>
                            <span><?php echo $positions[$i]['title']; if($i != sizeof($positions) - 1) { echo ','; }; ?></span>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="page-header-4-image-container">
                <div class="page-header-4-image cat-plugin-anystretch-image" cat_plugin_anystretch_image_alt="Person image" cat_plugin_anystretch_image_url="<?php echo ikit_three_image_resize($post_image, IKIT_THREE_IMAGE_RESIZE_LARGE); ?>"></div>
            </div>
        <?php } else { ?>
            <div class="page-header-5-title-container">
                <div class="page-header-5-title">
                    <?php the_title(); ?>
                    <div class="header-person-positions">
                        <?php for($i=0;$i<sizeof($positions);$i++) { ?>
                            <span><?php echo $positions[$i]['title']; if($i != sizeof($positions) - 1) { echo ','; }; ?></span>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>

    <table class="page-layout-4">
    <tr>

        <td class="page-layout-4-tools">
        </td>

        <td class="page-layout-4-content">

            <table>
            <tr>
            <td class="page-layout-4-body">
                <?php if(empty($post_image) == false && $g_theme_options[IKIT_THREE_THEME_OPTION_PERSONS_SINGLE_SMALL_HERO_IMAGE_ENABLED] == true) { ?>
                <div class="page-layout-4-body-image cat-plugin-anystretch-image" cat_plugin_anystretch_image_alt="Person image" cat_plugin_anystretch_image_url="<?php echo $post_image;?>"></div>
                <?php } ?>
                <div class="page-layout-4-body-paragraph-text wp-editor">
                    <?php the_content(); ?>
                </div>
            </td>

            <td class="page-layout-4-attributes">
                <div class="page-layout-4-attributes-inner">
                <?php if(empty($email) == false) { ?>
                    <div class="page-layout-4-attribute">
                        <a class="box-button person-item-email" href="mailto:<?php echo $email; ?>">
                            Email
                        </a>
                    </div>
                <?php } ?>
                </div>
            </td>

            </tr>
            </table>

        </td>

    </tr>
    </table>

    <?php endwhile; ?>



<?php get_footer(); ?>