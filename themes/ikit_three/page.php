<?php
/**
 * Template Name: Page
 */

if ( have_posts() ) while ( have_posts() ) : the_post();

global $id;

$sso_key = ikit_sso_get_redirect_token();
if(empty($sso_key)) {

    // If a locked page and trying to view without sso key, redirect to sso
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
    global $post;
    ?>

    <div class="page-header-3">
        <div class="page-header-3-title">
            <?php ikit_three_render_toc_title($post); ?>
        </div>
    </div>

    <table class="page-layout-4">
    <tr>

        <td class="page-layout-4-tools">

            <?php if(ikit_three_has_toc($post)) {?>
                <div class="page-layout-4-tool">
                    <?php ikit_three_render_toc($post); ?>
                </div>
            <?php } ?>

        </td>

        <td class="page-layout-4-content">

            <table>
            <tr>
            <td class="page-layout-4-body">
                <div class="page-layout-4-body-paragraph-text wp-editor">
                    <?php the_content();?>
                </div>
            </td>
            <td class="page-layout-4-sidebar">
                <?php dynamic_sidebar('page-sidebar');?>
            </td>
            </tr>
            </table>

        </td>

    </tr>
    </table>

    <?php
endwhile;?>

<?php get_footer();?>