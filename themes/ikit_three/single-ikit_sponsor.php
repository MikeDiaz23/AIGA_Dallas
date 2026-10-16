<?php
/**
 * Template Name: Single Sponsor
 *
*/

?>
<?php get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post();
    global $id;

    $sponsor_url = get_post_meta($id, IKIT_CUSTOM_FIELD_IKIT_SPONSOR_URL, true);
    $attachment_image_src = wp_get_attachment_image_src(get_post_meta($id, IKIT_CUSTOM_FIELD_IKIT_SPONSOR_PRIMARY_IMAGE, true), 'full');

    ?>

    <table class="page-layout-4">
    <tr>

        <td class="page-layout-4-tools">
        </td>

        <td class="page-layout-4-content">

            <table>
            <tr>
            <td class="page-layout-4-body">

                <div class="page-layout-4-body-paragraph-text wp-editor">

                    <div class="sponsor-image">
                        <a target="_blank" href="<?php echo $sponsor_url; ?>"><img alt="Official sponsor image" width="<?php echo round($attachment_image_src[1]/2); ?>px" src="<?php echo $attachment_image_src[0]; ?>"/></a>
                    </div>

                    <?php the_content();?>

                </div>

                <a class="sponsor-learn-more box-button" target="_blank" href="<?php echo $sponsor_url; ?>">Learn More</a>

            </td>

            <td class="page-layout-4-attributes">
            </td>

            </tr>
            </table>


        </td>

    </tr>
    </table>

<?php endwhile; ?>
<?php get_footer(); ?>