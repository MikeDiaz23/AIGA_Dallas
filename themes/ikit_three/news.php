<?php
/**
 * Template Name: News
 */
?>
<?php get_header();?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post();
global $post;
?>

<script type="text/javascript">

jQuery.news = function() {

};

jQuery.news.onDomReady = function() {

    jQuery.selectbox_input.init('.category-selectbox-filter', {
        onChange: function(inst, value) {
            var urlParams = {};
            urlParams['category'] = value;
            window.location.href = '?' + jQuery.param(urlParams);
        }
    });

};

jQuery.news.onStartDomReady = function() {

    jQuery.ikit_three.infinityFetcher.contentContainer = $('.infinity-fetcher-content');
    jQuery.ikit_three.infinityFetcher.fetchButton = $('.infinity-fetcher-fetch-button');
    jQuery.ikit_three.infinityFetcher.fetchingUrl = "<?php echo IKIT_AJAX_URL; ?>";
    jQuery.ikit_three.infinityFetcher.fetchingUrlData['action'] = 'ikit_three_ajax_render_news';
    jQuery.ikit_three.infinityFetcher.fetchingUrlData['category'] = "<?php echo (isset($_GET['category']) ? $_GET['category'] : ''); ?>";

    // Hide fetch button if no more pages
    if(parseInt($('.infinity-fetcher-content .data').attr('num_pages')) <= parseInt($('.infinity-fetcher-content .data').attr('page'))) {
        $('.infinity-fetcher-fetch-button').hide();
    }

};

jQuery.news.onEndDomReady = function() {

    <?php if(!empty($_GET['category'])) { ?>
        $('.category-selectbox-filter').selectbox('change', '<?php echo $_GET['category']; ?>');
    <?php }	?>

}

jQuery.news.afterFetchFinished = function(response, page, numPages) {
    jQuery.cat.plugin.anystretchImage.layout();
};

jQuery.news.afterAppendFunction = function(response) {

    // Do a simple fade in when new elements are appended
    response.hide();
    response.fadeIn();

};

$(document).ready(function() {
    jQuery.news.onDomReady();
});

jQuery.ikit_three.infinityFetcher.afterAppendFunctions.push(jQuery.news.afterAppendFunction);
jQuery.ikit_three.infinityFetcher.afterFetchFinishedFunctions.push(jQuery.news.afterFetchFinished);
jQuery.ikit_three.onStartDomReadyFunctions.push(jQuery.news.onStartDomReady);
jQuery.ikit_three.onEndDomReadyFunctions.push(jQuery.news.onEndDomReady);

</script>

<div class="page-header-3">
    <div class="page-header-3-title">
        <a href="<?php echo ikit_get_request_url(false); ?>">News</a>
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

            <div class="page-layout-4-body-filters">
                <div class="page-layout-4-body-filter">
                    <div class="page-layout-4-body-filter-inner">
                        <select class="category-selectbox-filter">
                            <option value="">All Categories</option>
                            <?php
                            $args = array();
                            $args['type'] = 'post';
                            $categories = ikit_get_categories_for_post_type('post', $args);
                            foreach($categories as $category) {
                                ?>
                                <option value="<?php echo $category->slug; ?>"><?php echo $category->name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <?php

            $data = array();
            $data['category'] = (isset($_GET['category']) ? $_GET['category'] : null);
            $rendered = ikit_three_ajax_render('ikit_three_ajax_render_news', $data);
            ?>

            <?php if(empty($rendered) == false) { ?>

                <div class="infinity-fetcher-content">
                    <?php echo $rendered; ?>
                </div>

            <?php } ?>

            <?php ikit_three_render_infinity_fetcher_fetch_button(); ?>

        </td>
        <td class="page-layout-4-sidebar">
            <?php dynamic_sidebar('news-sidebar');?>
        </td>
        </tr>
        </table>

    </td>

</tr>
</table>

<?php endwhile; ?>

<?php get_footer();?>