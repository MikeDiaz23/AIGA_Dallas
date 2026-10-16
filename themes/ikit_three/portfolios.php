<?php
/**
 * Template Name: Portfolios
 */
?>
<?php get_header();?>

<script type="text/javascript">

jQuery.portfolios = function() {

};

jQuery.portfolios.onStartDomReady = function() {

    jQuery.ikit_three.infinityFetcher.fetchingUrl = "<?php echo IKIT_AJAX_URL; ?>";
    jQuery.ikit_three.infinityFetcher.fetchButton = $('.infinity-fetcher-fetch-button');
    jQuery.ikit_three.infinityFetcher.fetchingUrlData['action'] = 'ikit_three_ajax_render_portfolios';

    // Hide fetch button if no more pages
    if(parseInt($('.infinity-fetcher-content .data').attr('num_pages')) <= parseInt($('.infinity-fetcher-content .data').attr('page'))) {
        $('.infinity-fetcher-fetch-button').hide();
    }

};

jQuery.portfolios.afterFetch = function(response, page, numPages) {

    jQuery.ikit_three.infinityFetcher.afterFetchGrid('.infinity-fetcher-content', response, page, numPages, true);
    jQuery.cat.plugin.anystretchImage.layout();

};

jQuery.ikit_three.infinityFetcher.afterFetchFunctions.push(jQuery.portfolios.afterFetch)
jQuery.ikit_three.onStartDomReadyFunctions.push(jQuery.portfolios.onStartDomReady);

</script>

<div class="page-header-3">
    <div class="page-header-3-title">
        <a href="<?php echo ikit_get_request_url(false); ?>">Portfolios</a>
    </div>
</div>


<table class="page-layout-4">
<tr>

    <!-- Hide so grid can fill remaining space -->
    <?php if(ikit_three_has_toc($post)) { ?>
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

            <div class="page-layout-4-body-description">
                <div class="page-layout-4-body-description-inner">
                    Check out the work of other chapter members! These projects are from the <a target="_blank" href="http://portfolios.aiga.org/">AIGA Member Portfolios Gallery</a>.
                </div>
            </div>

            <div class="page-layout-4-body-grid">

                <div class="cat-plugin-fluid-grid grid infinity-fetcher-content"
                    cat_plugin_fluid_grid_layout_mode="fitRows"
                    cat_plugin_fluid_grid_breakpoint_body_size_num_cols="<?php echo ikit_three_get_page_layout_4_body_grid_num_cols($post, 'portfolios-sidebar'); ?>"
                    cat_plugin_fluid_grid_breakpoint_body_size_classes="<?php echo IKIT_THREE_FLUID_GRID_BREAKPOINT_BODY_SIZE_CLASSES; ?>"
                    cat_plugin_fluid_grid_breakpoint_body_class="<?php echo IKIT_THREE_FLUID_GRID_BREAKPOINT_BODY_CLASS; ?>"

                >

                    <?php
                    $rendered = ikit_three_ajax_render('ikit_three_ajax_render_portfolios');
                    ?>

                    <?php if(empty($rendered) == false) { ?>

                        <?php echo $rendered; ?>

                    <?php } ?>

                </div>

            </div>

            <?php ikit_three_render_infinity_fetcher_fetch_button(); ?>

        </td>

        <!-- Expands content to take up extra sidebar space if no widgets -->
        <?php if(is_active_sidebar('portfolios-sidebar')) { ?>
            <td class="page-layout-4-sidebar">
                <?php dynamic_sidebar('portfolios-sidebar');?>
            </td>
        <?php } ?>

        </tr>
        </table>

    </td>

</tr>
</table>

<?php get_footer();?>