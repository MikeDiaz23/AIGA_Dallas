<?php
/**
 * Template Name: Jobs
 */
?>
<?php get_header();?>

<script type="text/javascript">

jQuery.jobs = function() {

};

jQuery.jobs.onStartDomReady = function() {

    jQuery.ikit_three.infinityFetcher.contentContainer = $('.infinity-fetcher-content');
    jQuery.ikit_three.infinityFetcher.fetchingUrl = "<?php echo IKIT_AJAX_URL; ?>";
    jQuery.ikit_three.infinityFetcher.fetchButton = $('.infinity-fetcher-fetch-button')
    jQuery.ikit_three.infinityFetcher.fetchingUrlData['action'] = 'ikit_three_ajax_render_jobs';

    // Hide fetch button if no more pages
    if(parseInt($('.infinity-fetcher-content .data').attr('num_pages')) <= parseInt($('.infinity-fetcher-content .data').attr('page'))) {
        $('.infinity-fetcher-fetch-button').hide();
    }

};

jQuery.jobs.onDomReady = function() {

};

jQuery.jobs.afterFetch = function(response, page, numPages) {
    jQuery.ikit_three.infinityFetcher.afterFetchGrid('.infinity-fetcher-content', response, page, numPages, false);
};

jQuery.jobs.afterAppendFunction = function(response) {
    // Do a simple fade in when new elements are appended
    response.hide();
    response.fadeIn();

};

$(document).ready(function() {
    jQuery.jobs.onDomReady();
});

jQuery.ikit_three.infinityFetcher.afterFetchFunctions.push(jQuery.jobs.afterFetch);
jQuery.ikit_three.infinityFetcher.afterAppendFunctions.push(jQuery.jobs.afterAppendFunction);
jQuery.ikit_three.onStartDomReadyFunctions.push(jQuery.jobs.onStartDomReady);

</script>

<div class="page-header-3">
    <div class="page-header-3-title">
        <a href="<?php echo ikit_get_request_url(false); ?>">Job Board</a>
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

            <div class="page-layout-4-body-description">
                <div class="page-layout-4-body-description-inner">
                    To post a job, visit the <a target="_blank" href="https://designcareers.aiga.org">Design Careers site</a>; one of the <a target="_blank" href="http://www.aiga.org/benefits/">benefits</a> of AIGA membership is discounted job posting rates.
                </div>
            </div>

            <div class="page-layout-4-body-grid">
                <div class="cat-plugin-fluid-grid grid infinity-fetcher-content"
                    cat_plugin_fluid_grid_layout_mode="fitRows"
                    cat_plugin_fluid_grid_breakpoint_body_size_num_cols="<?php echo ikit_three_get_page_layout_4_body_grid_num_cols($post, 'jobs-sidebar'); ?>"
                    cat_plugin_fluid_grid_breakpoint_body_size_classes="<?php echo IKIT_THREE_FLUID_GRID_BREAKPOINT_BODY_SIZE_CLASSES; ?>"
                    cat_plugin_fluid_grid_breakpoint_body_class="<?php echo IKIT_THREE_FLUID_GRID_BREAKPOINT_BODY_CLASS; ?>"
                >

                    <?php
                    $rendered = ikit_three_ajax_render('ikit_three_ajax_render_jobs');

                    $no_results = false;
                    preg_match_all('/num_pages="([0-9]+)"/i', $rendered, $matches);
                    if(intval($matches[1][0]) <= 0) {
                        $no_results = true;
                    }

                    ?>

                    <?php if(empty($rendered) == false && $no_results == false) { ?>

                    <?php echo $rendered; ?>

                    <?php } else { ?>

                        <div class="cat-plugin-fluid-grid-item grid-item">
                            <div class="grid-item-inner">
                                <div class="no-results">No results found.</div>
                            </div>
                        </div>

                    <?php } ?>

                </div>
            </div>

            <?php if(empty($rendered) == false && $no_results == false) { ?>
                <?php ikit_three_render_infinity_fetcher_fetch_button(); ?>
            <?php } ?>

        </td>
        <?php if(is_active_sidebar('jobs-sidebar')) { ?>
            <td class="page-layout-4-sidebar">
                <?php dynamic_sidebar('jobs-sidebar');?>
            </td>
        <?php } ?>
        </tr>
        </table>

    </td>

</tr>
</table>

<?php get_footer();?>
