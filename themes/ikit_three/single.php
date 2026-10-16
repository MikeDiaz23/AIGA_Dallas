<?php
/**
 * Template Name: Single
 *
*/

if ( have_posts() ) while ( have_posts() ) : the_post();

global $id;

$sso_key = ikit_sso_get_redirect_token();
if(empty($sso_key)) {

    // If a locked post and trying to view without sso key, redirect to sso
    if(ikit_sso_has_lock($id)) {
        wp_redirect(ikit_sso_get_login_url(get_permalink(), IKIT_SSO_REDIRECT_SOURCE_LOCK));
        exit;
    }
}

endwhile;

?>
<?php get_header();?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post();
    global $id;
    $post_image = ikit_post_get_image_url($id, 'full', null);
    ?>



    <div class="page-header-4">

        <?php if(empty($post_image) == false && $g_theme_options[IKIT_THREE_THEME_OPTION_NEWS_SINGLE_SMALL_HERO_IMAGE_ENABLED] == false) { ?>
            <div class="page-header-4-title-container">
                <div class="page-header-4-title">
                    <?php the_title(); ?>
                </div>
            </div>
            <div class="page-header-4-image-container">
                <div class="page-header-4-image cat-plugin-anystretch-image" cat_plugin_anystretch_image_alt="News image" cat_plugin_anystretch_image_url="<?php echo ikit_three_image_resize($post_image, IKIT_THREE_IMAGE_RESIZE_LARGE); ?>"></div>
            </div>
        <?php } else { ?>
            <div class="page-header-5-title-container">
                <div class="page-header-5-title">
                    <?php the_title(); ?>
                </div>
            </div>
        <?php } ?>
    </div>

    <table class="page-layout-4">
    <tr>

        <td class="page-layout-4-tools">
            <div class="page-layout-4-tool">
                <?php ikit_three_render_social_share(); ?>
            </div>
        </td>

        <td class="page-layout-4-content">

            <table>
            <tr>
            <td class="page-layout-4-body">

                <?php if(empty($post_image) == false && $g_theme_options[IKIT_THREE_THEME_OPTION_NEWS_SINGLE_SMALL_HERO_IMAGE_ENABLED] == true) { ?>
                <div class="page-layout-4-body-image cat-plugin-anystretch-image" cat_plugin_anystretch_image_alt="News image" cat_plugin_anystretch_image_url="<?php echo $post_image; ?>"></div>
                <?php } ?>
                <div class="page-layout-4-body-paragraph-text wp-editor">
                    <?php the_content();?>
                </div>
            </td>

            <td class="page-layout-4-attributes">

                <div class="page-layout-4-attributes-inner">

                    <div class="page-layout-4-attribute">
                        <div class="page-layout-4-attribute-text">
                        <div>By <?php echo ikit_post_get_author($id, get_the_author()); ?></div>
                        <?php if(ikit_three_get_post_date($post) != null) { ?>
                            <div>Published <?php echo mysql2date('F j, Y', get_gmt_from_date($post->post_date), false);?></div>
                        <?php } ?>
                        </div>
                    </div>

                    <div class="page-layout-4-attribute">
                        <div class="page-layout-4-attribute-actions">
                        <?php
                        $category_ids = wp_get_post_categories($post->ID);
                        foreach($category_ids as $category_id) {
                            $category = get_category($category_id);
                            ?>
                            <a class="box-button category-button" href="<?php echo get_category_link($category); ?>"><?php echo $category->name; ?></a>
                            <?php
                        }
                        ?>
                        </div>
                    </div>

                </div>

            </td>

            </tr>
            </table>

        </td>

    </tr>
    </table>

    <?php ikit_three_render_related_items($post->ID); ?>

    <?php if($g_theme_options[IKIT_THREE_THEME_OPTION_COMMENTS_ENABLED_POST]) { ?>
        <?php if(comments_open($post->ID)) { ?>
            <?php ikit_three_render_comments(); ?>
        <?php } ?>
    <?php }?>

    <?php
endwhile;?>

<?php get_footer();?>