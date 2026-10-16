<?php
/**
 * Template Name: Events Past
 */
?>
<?php get_header();?>

<script type="text/javascript">

jQuery.events_past = function() {

};

jQuery.events_past.onStartDomReady = function() {

    jQuery.ikit_three.infinityFetcher.fetchingUrl = "<?php echo IKIT_AJAX_URL; ?>";
    jQuery.ikit_three.infinityFetcher.fetchButton = $('.infinity-fetcher-fetch-button');
    jQuery.ikit_three.infinityFetcher.fetchingUrlData['action'] = 'ikit_three_ajax_render_events_past';
    jQuery.ikit_three.infinityFetcher.fetchingUrlData['y'] = "<?php echo (isset($_GET['y']) ? $_GET['y'] : ''); ?>";
    jQuery.ikit_three.infinityFetcher.fetchingUrlData['category'] = "<?php echo (isset($_GET['category']) ? $_GET['category'] : '')?>";

    // Hide fetch button if no more pages
    if(parseInt($('.infinity-fetcher-content .data').attr('num_pages')) <= parseInt($('.infinity-fetcher-content .data').attr('page'))) {
        $('.infinity-fetcher-fetch-button').hide();
    }

};

jQuery.events_past.onEndDomReady = function() {

    <?php if(!empty($_GET['type'])) { ?>
        $('.type-selectbox-filter').selectbox("change", "<?php echo $_GET['type']; ?>");
    <?php } ?>

    <?php if(!empty($_GET['y'])) { ?>
        $('.year-selectbox-filter').selectbox("change", "<?php echo $_GET['y']?>");
    <?php } ?>

    <?php if(!empty($_GET['category'])) { ?>
        $('.category-selectbox-filter').selectbox("change", "<?php echo $_GET['category']?>");
    <?php } ?>
}

jQuery.events_past.onDomReady = function() {

    jQuery.selectbox_input.init('.year-selectbox-filter', {
        onChange: function(inst, value) {
            var urlParams = {};
            jQuery.events_past.updateUrlParams(urlParams);
            urlParams['y'] = value;
            window.location.href = '?' + jQuery.param(urlParams);
        },

        onOpen: function(inst) {
            $('.type-selectbox-filter').selectbox('close');
            $('.category-selectbox-filter').selectbox('close');
        }

    });

    jQuery.selectbox_input.init('.type-selectbox-filter', {
        onChange: function(inst, value) {
            var urlParams = {};
            jQuery.events_past.updateUrlParams(urlParams);
            urlParams['type'] = value;
            window.location.href = '?' + jQuery.param(urlParams);
        },

        onOpen: function(inst) {
            $('.category-selectbox-filter').selectbox('close');
            $('.year-selectbox-filter').selectbox('close');
        }
    });

    jQuery.selectbox_input.init('.category-selectbox-filter', {
        onChange: function(inst, value) {
            var urlParams = {};
            jQuery.events_past.updateUrlParams(urlParams);
            urlParams['category'] = value;
            window.location.href = '?' + jQuery.param(urlParams);
        },

        onOpen: function(inst) {
            $('.type-selectbox-filter').selectbox('close');
            $('.year-selectbox-filter').selectbox('close');
        }
    });

};

jQuery.events_past.updateUrlParams = function(urlParams) {

    <?php if(empty($_GET['y']) == false) { ?>
        urlParams['y'] = '<?php echo $_GET['y']; ?>';
    <?php } ?>

    <?php if(empty($_GET['type']) == false) { ?>
        urlParams['type'] = '<?php echo $_GET['type']; ?>';
    <?php } ?>

    <?php if(empty($_GET['category']) == false) { ?>
        urlParams['category'] = '<?php echo $_GET['category']; ?>';
    <?php } ?>

};

jQuery.events_past.afterFetch = function(response, page, numPages) {

    jQuery.ikit_three.infinityFetcher.afterFetchGrid('.infinity-fetcher-content', response, page, numPages, true);
    jQuery.cat.plugin.anystretchImage.layout();

};

$(document).ready(function() {
    jQuery.events_past.onDomReady();
});

jQuery.ikit_three.infinityFetcher.afterFetchFunctions.push(jQuery.events_past.afterFetch);
jQuery.ikit_three.onStartDomReadyFunctions.push(jQuery.events_past.onStartDomReady);
jQuery.ikit_three.onEndDomReadyFunctions.push(jQuery.events_past.onEndDomReady);

</script>

<div class="page-header-3">
    <div class="page-header-3-title">

        <?php
        $title = 'Past Events';

        if(isset($_GET['type']) && $_GET['type'] == IKIT_THREE_EVENTS_TYPE_AIGA) {
            $title = 'Past AIGA Events';
        }
        if(isset($_GET['type']) && $_GET['type'] == IKIT_THREE_EVENTS_TYPE_COMMUNITY) {
            $title = 'Past Community Events';
        }
        ?>

        <a href="<?php echo ikit_get_request_url(false); ?>"><?php echo $title;?></a>
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

            <div class="page-layout-4-body-filters">

                <div class="page-layout-4-body-filter">
                    <div class="page-layout-4-body-filter-inner">
                        <select class="type-selectbox-filter">
                            <option value="">All Event Types</option>
                            <option value="<?php echo IKIT_THREE_EVENTS_TYPE_AIGA; ?>">AIGA</option>
                            <option value="<?php echo IKIT_THREE_EVENTS_TYPE_COMMUNITY; ?>">Community</option>
                        </select>
                    </div>
                </div>

                <div class="page-layout-4-body-filter">
                    <div class="page-layout-4-body-filter-inner">
                        <select class="category-selectbox-filter">
                            <option value="">All Categories</option>
                                <?php
                                $args = array();
                                $args['type'] = array(IKIT_POST_TYPE_IKIT_EVENT, IKIT_POST_TYPE_IKIT_EVENT_EXTERNAL, IKIT_POST_TYPE_IKIT_EVENT_INTERNAL);
                                $categories = ikit_get_categories_for_post_type(array(IKIT_POST_TYPE_IKIT_EVENT, IKIT_POST_TYPE_IKIT_EVENT_EXTERNAL, IKIT_POST_TYPE_IKIT_EVENT_INTERNAL), $args);
                                foreach($categories as $category) {
                                    ?>
                                    <option value="<?php echo $category->slug; ?>"><?php echo $category->name; ?></option>
                                    <?php
                                }
                                ?>
                        </select>
                    </div>
                </div>

                <div class="page-layout-4-body-filter">
                    <div class="page-layout-4-body-filter-inner">
                        <select class="year-selectbox-filter">
                            <option value="">All Years</option>
                            <?php
                            for($i=0;$i<5;$i++) {
                                $year = date("Y",strtotime("-" . $i . " year"));
                                ?>
                                <option value="<?php echo $year ?>"><?php echo $year ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

            </div>

            <div class="page-layout-4-body-grid">

                <div class="cat-plugin-fluid-grid grid infinity-fetcher-content"
                    cat_plugin_fluid_grid_layout_mode="fitRows"
                    cat_plugin_fluid_grid_breakpoint_body_size_num_cols="<?php echo ikit_three_get_page_layout_4_body_grid_num_cols($post, null); ?>"
                    cat_plugin_fluid_grid_breakpoint_body_size_classes="<?php echo IKIT_THREE_FLUID_GRID_BREAKPOINT_BODY_SIZE_CLASSES; ?>"
                    cat_plugin_fluid_grid_breakpoint_body_class="<?php echo IKIT_THREE_FLUID_GRID_BREAKPOINT_BODY_CLASS; ?>"
                >

                    <?php
                    $data = array();
                    $data['category'] = (isset($_GET['category']) ? $_GET['category'] : null);
                    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);
                    $data['y'] = (isset($_GET['y']) ? $_GET['y'] : null);
                    $rendered = ikit_three_ajax_render('ikit_three_ajax_render_events_past', $data);

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
        </tr>
        </table>

    </td>

</tr>
</table>

<?php get_footer();?>