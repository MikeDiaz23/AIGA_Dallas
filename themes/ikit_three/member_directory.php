<?php
/**
 * Template Name: Member Directory
 */
?>
<?php get_header();?>

<script type="text/javascript">

jQuery.member_directory = function() {

};

jQuery.member_directory.onStartDomReady = function() {

    jQuery.ikit_three.infinityFetcher.contentContainer = $('.infinity-fetcher-content');
    jQuery.ikit_three.infinityFetcher.fetchButton = $('.infinity-fetcher-fetch-button');
    jQuery.ikit_three.infinityFetcher.fetchingUrl = "<?php echo IKIT_AJAX_URL; ?>";
    jQuery.ikit_three.infinityFetcher.fetchingUrlData['action'] = 'ikit_three_ajax_render_member_directory';

    // Hide fetch button if no more pages
    if(parseInt($('.infinity-fetcher-content .data').attr('num_pages')) <= parseInt($('.infinity-fetcher-content .data').attr('page'))) {
        $('.infinity-fetcher-fetch-button').hide();
    }

};

jQuery.member_directory.onDomReady = function() {

    jQuery.selectbox_input.init('.member-type-selectbox-filter', {
        onChange: function(inst, value) {
            jQuery.ikit_three.infinityFetcher.filter('member_type', value);
        }
    });

    jQuery.selectbox_input.init('.availability-selectbox-filter', {
        onChange: function(inst, value) {
            jQuery.ikit_three.infinityFetcher.filter('available_for_projects', value);
        }
    });

};

jQuery.member_directory.afterFetchFinished = function(response, page, numPages) {

    jQuery.ikit_three.infinityFetcher.afterFetchGrid('.infinity-fetcher-content', response, page, numPages, true);
    jQuery.cat.plugin.anystretchImage.layout();

};

jQuery.member_directory.onWindowResize = function() {

};

jQuery.ikit_three.infinityFetcher.afterFetchFinishedFunctions.push(jQuery.member_directory.afterFetchFinished);
jQuery.ikit_three.onStartDomReadyFunctions.push(jQuery.member_directory.onStartDomReady);

$(document).ready(function() {
    jQuery.member_directory.onDomReady();
});

$(window).resize(function() {
    jQuery.member_directory.onWindowResize();
});

</script>

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

            <div class="page-layout-4-body-description">
                <div class="page-layout-4-body-description-inner">
                    The membership directory is available for individual and personal uses only. Accessing address information acknowledges the user's acceptance of the <a target="_blank" href="http://www.aiga.org/designer-directory/">conditions of use</a> prohibiting commercial use.
                </div>
            </div>

            <div class="page-layout-4-body-filters">
                <div class="page-layout-4-body-filter">
                    <div class="page-layout-4-body-filter-inner">
                        <select class="member-type-selectbox-filter">
                            <option value="">All Member Types</option>
                            <?php
                            $member_types = ikit_member_types();
                            foreach($member_types as $member_type) {
                            ?>
                                <option value="<?php echo $member_type ?>"><?php echo ikit_member_type_display_name($member_type); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="page-layout-4-body-filter">
                    <div class="page-layout-4-body-filter-inner">
                        <select class="availability-selectbox-filter">
                            <option value="">Availability</option>
                            <option value="1">Available for Independent Projects</option>
                        </select>
                    </div>
                </div>
            </div>

            <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

                <?php
                $rendered = ikit_three_ajax_render('ikit_three_ajax_render_member_directory');
                ?>

                <?php if(empty($rendered) == false) { ?>

                    <div class="page-layout-4-body-grid">

                        <div class="cat-plugin-fluid-grid grid infinity-fetcher-content"
                            cat_plugin_fluid_grid_layout_mode="fitRows"
                            cat_plugin_fluid_grid_breakpoint_body_size_num_cols="<?php echo ikit_three_get_page_layout_4_body_grid_num_cols($post, 'member-directory-sidebar'); ?>"
                            cat_plugin_fluid_grid_breakpoint_body_size_classes="<?php echo IKIT_THREE_FLUID_GRID_BREAKPOINT_BODY_SIZE_CLASSES; ?>"
                            cat_plugin_fluid_grid_breakpoint_body_class="<?php echo IKIT_THREE_FLUID_GRID_BREAKPOINT_BODY_CLASS; ?>"
                        >
                            <?php echo $rendered; ?>
                        </div>

                    </div>

                <?php } ?>

            <?php endwhile; ?>

            <?php ikit_three_render_infinity_fetcher_fetch_button(); ?>

        </td>

        <!-- Expands content to take up extra sidebar space if no widgets -->
        <?php if(is_active_sidebar('member-directory-sidebar')) { ?>
            <td class="page-layout-4-sidebar">
                <?php dynamic_sidebar('member-directory-sidebar');?>
            </td>
        <?php } ?>

        </tr>
        </table>

    </td>

</tr>
</table>

<?php get_footer();?>