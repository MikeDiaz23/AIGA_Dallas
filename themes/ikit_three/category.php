<?php
/**
 * Template Name: Category
 */
?>
<?php get_header();?>

<?php

    $category = $wp_query->get_queried_object();

?>

<script type="text/javascript">

jQuery.category = function() {

};

jQuery.category.onStartDomReady = function() {

    jQuery.ikit_three.infinityFetcher.contentContainer = $('.infinity-fetcher-content');
    jQuery.ikit_three.infinityFetcher.fetchButton = $('.infinity-fetcher-fetch-button');
    jQuery.ikit_three.infinityFetcher.fetchingUrl = "<?php echo IKIT_AJAX_URL; ?>";
    jQuery.ikit_three.infinityFetcher.fetchingUrlData['action'] = 'ikit_three_ajax_render_news';
    jQuery.ikit_three.infinityFetcher.fetchingUrlData['category'] = '<?php echo $category->slug; ?>';
    jQuery.ikit_three.infinityFetcher.fetchingUrlData['category_view'] = true;

    // Hide fetch button if no more pages
    if(parseInt($('.infinity-fetcher-content .data').attr('num_pages')) <= parseInt($('.infinity-fetcher-content .data').attr('page'))) {
        $('.infinity-fetcher-fetch-button').hide();
    }

};

jQuery.category.afterFetchFinished = function(response, page, numPages) {
    jQuery.ikit_three.infinityFetcher.afterFetchGrid('.infinity-fetcher-content', response, page, numPages, true);
    jQuery.cat.plugin.anystretchImage.layout();
};

jQuery.ikit_three.infinityFetcher.afterFetchFinishedFunctions.push(jQuery.category.afterFetchFinished);
jQuery.ikit_three.onStartDomReadyFunctions.push(jQuery.category.onStartDomReady);

</script>

<div class="page-header-3">
    <div class="page-header-3-title">
        <a href="<?php echo ikit_get_request_url(false); ?>">News / <?php echo $category->name; ?></a>
    </div>
</div>

<table class="page-layout-4">
<tr>

    <td class="page-layout-4-content">

        <table>
        <tr>
        <td class="page-layout-4-body">

            <?php

            $data = array();
            $data['category'] = $category->slug;
            $data['category_view'] = true;

            $rendered = ikit_three_ajax_render('ikit_three_ajax_render_news', $data);

            ?>

            <?php if(empty($rendered) == false) { ?>

                <div class="page-layout-4-body-grid">

                    <div class="cat-plugin-fluid-grid grid infinity-fetcher-content"
                        cat_plugin_fluid_grid_layout_mode="fitRows"
                        cat_plugin_fluid_grid_breakpoint_body_size_num_cols="<?php echo IKIT_THREE_PAGE_LAYOUT_4_BODY_FULL_FLUID_GRID_BREAKPOINT_BODY_SIZE_NUM_COLS; ?>"
                        cat_plugin_fluid_grid_breakpoint_body_size_classes="<?php echo IKIT_THREE_FLUID_GRID_BREAKPOINT_BODY_SIZE_CLASSES; ?>"
                        cat_plugin_fluid_grid_breakpoint_body_class="<?php echo IKIT_THREE_FLUID_GRID_BREAKPOINT_BODY_CLASS; ?>"
                    >
                        <?php echo $rendered; ?>
                    </div>

                 </div>

                <?php ikit_three_render_infinity_fetcher_fetch_button(); ?>

            <?php } ?>

        </td>
        </tr>
        </table>

    </td>

</tr>
</table>





<?php get_footer();?>