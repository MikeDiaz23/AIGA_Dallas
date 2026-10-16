<?php
/**
 * Index
 */
?>

<?php get_header();?>

<script type="text/javascript">

jQuery.index = function() {

};

jQuery.index.onStartDomReady = function() {

    $('.ikit-widget-quote').attr('cat_plugin_fluid_grid_item_size', 4);
    $('.ikit-widget-featured-video').attr('cat_plugin_fluid_grid_item_size', 4);
    $('.ikit-widget-youtube').attr('cat_plugin_fluid_grid_item_size', 2);
    $('.ikit-widget-vimeo').attr('cat_plugin_fluid_grid_item_size', 2);

};

jQuery.index.layout = function() {

    // Get info column and swap with the image column for the featured events news billboard widget
    $('.ikit-three-widget-featured-events-news-billboard .items .item-slide').each(function() {
        var infoColEl = $(this).find('.item-info-col');
        var imageColEl = $(this).find('.item-image-col');

        if($('.breakpoint-body').hasClass('breakpoint-body-size-s-m')) {
            if(imageColEl.next().length <= 0) {
                infoColEl.detach();
                infoColEl.insertAfter(imageColEl);
            }
        }
        else {
            if(imageColEl.next().length > 0) {
                infoColEl.detach();
                infoColEl.insertBefore(imageColEl);
            }
        }
    });

    // Handle fullscreen support for the featured billboard widget
    var featuredWidgetEl = $('.ikit-three-widget-featured-events-news-billboard');
    if(featuredWidgetEl.length > 0) {

        var headerEl = $('.header');
        var layoutEl = $('.layout');
        var featuredWidgetContentEl = featuredWidgetEl.find('.widget-content');
        var featuredWidgetSlidesEl = featuredWidgetEl.find('.item-slides');

        if(featuredWidgetSlidesEl.length > 0) {

            var featuredWidgetSlidesPagerEl = featuredWidgetEl.find('.item-slides-pager');
            var windowAspectRatio = $(window).width() / $(window).height();
            var disableFullscreen = parseInt(featuredWidgetSlidesEl.attr('data-disable-fullscreen')) == 1 ? true : false;

            // Set the featured widget fullscreen if not mobile, not disabled, and between specific aspect ratios
            if(windowAspectRatio > 1.25 && windowAspectRatio < 2 && $('.breakpoint-body').hasClass('breakpoint-body-size-s-m') == false && disableFullscreen == false) {
                featuredWidgetEl.addClass('fullscreen');
                featuredWidgetContentEl.height($(window).height() - headerEl.height());

                // Account for pager so appears event between header and pager
                featuredWidgetSlidesEl.css('top', -featuredWidgetSlidesPagerEl.outerHeight(true)/2);

                // Remove padding so appear vertically centered on page
                layoutEl.css('paddingTop', 0);

                // If the header collapsed is locked meaning it always appears, we offset in a different way to vertically center...
                <?php if($g_theme_options[IKIT_THREE_THEME_OPTION_HEADER_LOCK_COLLAPSED_ENABLED] == true) { ?>
                    var headerLayoutContainerCollapsedEl = headerEl.find('.header-layout-container-collapsed');
                    featuredWidgetContentEl.height($(window).height() - headerLayoutContainerCollapsedEl.height());
                    layoutEl.css('paddingTop', headerLayoutContainerCollapsedEl.height());
                <?php } ?>



            }
            else {

                // Undo all our customizations
                featuredWidgetEl.removeClass('fullscreen');
                featuredWidgetContentEl.css('height', ''); 	// However in mobile it just stacks so not needed
                featuredWidgetSlidesEl.css('top', '');
                layoutEl.css('paddingTop', '');

            }

        }

    }

}

jQuery.index.onDomReady = function() {
    jQuery.index.layout();
}

jQuery.index.onWindowResize = function() {
    jQuery.index.layout();
}

$(window).resize(function() {
    jQuery.index.onWindowResize();
});

$(document).ready(function() {
    jQuery.index.onDomReady();
});

jQuery.ikit_three.onStartDomReadyFunctions.push(jQuery.index.onStartDomReady);

</script>

<div class="index-billboard-sidebar">
    <?php dynamic_sidebar('index-billboard-sidebar');?>
</div>

<div class="cat-plugin-fluid-grid grid widget-grid page-layout-3 index-sidebar"
    cat_plugin_fluid_grid_breakpoint_body_size_num_cols="4,3,2,2,1"
    cat_plugin_fluid_grid_breakpoint_body_size_classes="<?php echo IKIT_THREE_FLUID_GRID_BREAKPOINT_BODY_SIZE_CLASSES; ?>"
    cat_plugin_fluid_grid_breakpoint_body_class="<?php echo IKIT_THREE_FLUID_GRID_BREAKPOINT_BODY_CLASS; ?>"
>
    <?php dynamic_sidebar('index-sidebar');?>


</div>

<?php get_footer();?>