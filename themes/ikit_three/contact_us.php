<?php
/**
 * Template Name: Contact Us
 */
?>
<?php get_header();?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

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
            <?php the_content();?>
        </td>
        <td class="page-layout-4-sidebar">
            <?php dynamic_sidebar('page-sidebar');?>
        </td>
        </tr>
        </table>

    </td>

</tr>
</table>

<?php endwhile; ?>


<?php get_footer();?>