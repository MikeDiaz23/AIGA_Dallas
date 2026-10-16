<?php
/**
 * Template Name: Events
 */

define("IKIT_THREE_EVENTS_VIEW_CALENDAR", 'calendar');
define("IKIT_THREE_EVENTS_VIEW_LIST", 'list');

?>

<?php get_header();?>

<?php

// Theme option allows defaulting to the calendar view
$view = $g_theme_options[IKIT_THREE_THEME_OPTION_DEFAULT_CALENDAR_VIEW_EVENTS] == 1 ? IKIT_THREE_EVENTS_VIEW_CALENDAR : IKIT_THREE_EVENTS_VIEW_LIST;
if(empty($_GET['view']) == false) {
    $view = $_GET['view'];
}

// Get the type from the request
$type = null;
if(empty($_GET['type']) == false) {
    $type = $_GET['type'];
}

// Force to a single type if internal events option for separate page is enabled or if the events internal template,
// set the type based on the page template being used.
$force_type = false;
if($g_theme_options[IKIT_THREE_THEME_OPTION_IKIT_EVENTS_INTERNAL_SEPARATE_PAGE] == true || get_page_template_slug() == 'events_internal.php') {
    $force_type = true;
}

if($force_type) {
    $type = IKIT_THREE_EVENTS_TYPE_AIGA;
    if(get_page_template_slug() == 'events_internal.php') {
        $type = IKIT_THREE_EVENTS_TYPE_COMMUNITY;
    }
}

?>
<script type="text/javascript">

jQuery.events = function() {

};

jQuery.events.onDomReady = function() {


    $('.view-filter').click(function() {
        var urlParams = {};
        jQuery.events.updateUrlParams(urlParams);
        urlParams['view'] = $(this).attr('value');
        window.location.href = '?' + jQuery.param(urlParams);
    });

    jQuery.selectbox_input.init('.type-selectbox-filter', {
         onChange: function(inst, value) {
             var urlParams = {};
             jQuery.events.updateUrlParams(urlParams);
             urlParams['type'] = value;
             window.location.href = '?' + jQuery.param(urlParams);
         },

         onOpen: function(inst) {
             $('.category-selectbox-filter').selectbox('close');
         }
     });

    jQuery.selectbox_input.init('.category-selectbox-filter', {
        onChange: function(inst, value) {
            var urlParams = {};
            jQuery.events.updateUrlParams(urlParams);
            urlParams['category'] = value;
            window.location.href = '?' + jQuery.param(urlParams);
        },

        onOpen: function(inst) {
            $('.type-selectbox-filter').selectbox('close');
        }
    });

    jQuery.events.list.onWindowResize();
    jQuery.events.calendar.onWindowResize();

};

jQuery.events.updateUrlParams = function(urlParams) {

    <?php if(empty($view) == false) { ?>
        urlParams['view'] = '<?php echo $view; ?>';
    <?php } ?>

    <?php if(empty($_GET['type']) == false) { ?>
        urlParams['type'] = '<?php echo $_GET['type']; ?>';
    <?php } ?>

    <?php if(empty($_GET['category']) == false) { ?>
        urlParams['category'] = '<?php echo $_GET['category']; ?>';
    <?php } ?>

};

jQuery.events.onStartDomReady = function() {
    jQuery.events.calendar.onStartDomReady();
    jQuery.events.list.onStartDomReady();
};

jQuery.events.onEndDomReady = function() {

    // Sync selectbox to urlparams
    <?php if(!empty($_GET['type'])) { ?>
        $('.type-selectbox-filter').selectbox("change", "<?php echo $_GET['type']; ?>");
    <?php } ?>
    <?php if(!empty($_GET['category'])) { ?>
        $('.category-selectbox-filter').selectbox("change", "<?php echo $_GET['category']; ?>");
    <?php } ?>

    jQuery.events.list.onEndDomReady();
    jQuery.events.calendar.onEndDomReady();
};

jQuery.events.onWindowResize = function() {
    jQuery.events.calendar.onWindowResize();
    jQuery.events.list.onWindowResize();
};

jQuery.ikit_three.onStartDomReadyFunctions.push(jQuery.events.onStartDomReady);
jQuery.ikit_three.onEndDomReadyFunctions.push(jQuery.events.onEndDomReady);

$(window).resize(function() {
    jQuery.events.onWindowResize();
});

$(document).ready(function() {
    jQuery.events.onDomReady();
});

/* Calendar */

jQuery.events.calendar = function() {

};

jQuery.events.calendar.onStartDomReady = function() {

};

jQuery.events.calendar.onWindowResize = function() {

    jQuery.events.calendar.layout();

};

jQuery.events.calendar.onEndDomReady = function() {

    jQuery.events.calendar.updateTitle();

    $('.events-calendar-next').click(function() {

        var calendarMonth = parseInt($('.page-layout-4-content .data').attr('month'));
        var calendarYear = parseInt($('.page-layout-4-content .data').attr('year'));

        if(calendarMonth == 12) {
            calendarYear++;
            calendarMonth = 1;
        }
        else {
            calendarMonth++;
        }

        var data = {month: calendarMonth, year: calendarYear};
        jQuery.events.calendar.fetch(data);

    });

    $('.events-calendar-prev').click(function() {

        var calendarMonth = parseInt($('.page-layout-4-content .data').attr('month'));
        var calendarYear = parseInt($('.page-layout-4-content .data').attr('year'));

        if(calendarMonth == 1) {
            calendarMonth = 12;
            calendarYear--;
        }
        else {
            calendarMonth--;
        }


        var data = {month: calendarMonth, year: calendarYear};
        jQuery.events.calendar.fetch(data);

    });

    jQuery.events.calendar.layout();
    jQuery.cat.plugin.anystretchImage.layout();

};

jQuery.events.calendar.updateTitle = function() {

    $('.events-calendar-title').text($('.page-layout-4-content .data').attr('name'));

};

jQuery.events.calendar.fetch = function(data) {

    jQuery.events.updateUrlParams(data);
    data['action'] = 'ikit_three_ajax_render_events_calendar';

    $.ajax({
        type : "POST",
        url : "<?php echo IKIT_AJAX_URL; ?>",
        data: data,
        success : function(response) {

            $('.events-calendar-content').html(response);
            jQuery.events.calendar.updateTitle();
            jQuery.events.calendar.layout();
            jQuery.cat.plugin.anystretchImage.layout();

        }
    });

    data['action'] = 'ikit_three_ajax_render_events_calendar_compact';

    $.ajax({
        type : "POST",
        url : "<?php echo IKIT_AJAX_URL; ?>",
        data: data,
        success : function(response) {

            $('.events-calendar-content-compact').html(response);
            jQuery.events.calendar.updateTitle();
            jQuery.events.calendar.layout();
            jQuery.cat.plugin.anystretchImage.layout();

        }
    });

};

jQuery.events.calendar.layout = function() {

    // Widths may not be identical across days, so we need to get the maximum width and use that
    var columnWidth = 0;
    $('.events-calendar-day-event').each(function() {
        columnWidth = Math.max(columnWidth, $(this).width());
    });

    $('.events-calendar-content > table > tbody > tr').each(function() {

        // If not the header row
        if($(this).find('th').length == 0) {

            // Find the max height of a single row
            var rowHeight = columnWidth;
            $(this).find('.events-calendar-day-events').each(function() {
                var eventEls = $(this).find('.events-calendar-day-event');
                rowHeight = Math.max(rowHeight, eventEls.length * (columnWidth/2));
            });

            // Set the heights of the events within the calendar with only 1 item
            $(this).find('.events-calendar-day-events').each(function() {
                var eventEls = $(this).find('.events-calendar-day-event');
                eventEls.height(rowHeight/eventEls.length);
            });

        }

    });

    // Assign tooltip
    $('.events-calendar-day-event-image-link').each(function() {
        var infoEl = $(this).parent().find('.events-calendar-day-event-info');
        $(this).tooltipster({
            content: infoEl.html(),
            contentAsHTML: true,
            autoClose: true
        });
    });

};

/* List */

jQuery.events.list = function() {

};

jQuery.events.list.layout = function() {
    // Update the image column to match the widget item size so lines up with the grid
    $('.event-item-image-col').outerWidth(jQuery.ikit_three.grid.getItemWidth());
};

jQuery.events.list.onStartDomReady = function() {

    jQuery.ikit_three.infinityFetcher.contentContainer = $('.infinity-fetcher-content');
    jQuery.ikit_three.infinityFetcher.fetchButton = $('.infinity-fetcher-fetch-button');
    jQuery.ikit_three.infinityFetcher.fetchingUrl = "<?php echo IKIT_AJAX_URL; ?>";
    jQuery.ikit_three.infinityFetcher.fetchingUrlData['action'] = 'ikit_three_ajax_render_events';
    jQuery.ikit_three.infinityFetcher.fetchingUrlData['type'] = "<?php echo $type; ?>";
    jQuery.ikit_three.infinityFetcher.fetchingUrlData['category'] = "<?php echo (isset($_GET['category']) ? $_GET['category'] : '') ?>";

    // Hide fetch button if no more pages
    if(parseInt($('.infinity-fetcher-content .data').attr('num_pages')) <= parseInt($('.infinity-fetcher-content .data').attr('page'))) {
        $('.infinity-fetcher-fetch-button').hide();
    }

};

jQuery.events.list.onWindowResize = function() {
    jQuery.events.list.layout();

    // The image should appear before the title when in small
    $('.event-item').each(function() {

        var infoColEl = $(this).find('.event-item-info-col');
        var imageColEl = $(this).find('.event-item-image-col');

        if($('.breakpoint-body').hasClass('breakpoint-body-size-s')) {
            if(imageColEl.next().length <= 0) {
                imageColEl.detach();
                imageColEl.insertBefore(infoColEl);
            }
        }
        else {
            if(imageColEl.next().length > 0) {
                imageColEl.detach();
                imageColEl.insertAfter(infoColEl);
            }
        }

    });

};

jQuery.events.list.onEndDomReady = function() {
    jQuery.events.list.layout();
};

jQuery.events.list.afterFetchFinished = function(response, page, numPages) {
    jQuery.cat.plugin.anystretchImage.layout();
    jQuery.events.list.layout();
};

jQuery.events.list.afterAppendFunction = function(response) {

    // Do a simple fade in when new elements are appended
    response.hide();
    response.fadeIn();

};

jQuery.ikit_three.infinityFetcher.afterAppendFunctions.push(jQuery.events.list.afterAppendFunction);
jQuery.ikit_three.infinityFetcher.afterFetchFinishedFunctions.push(jQuery.events.list.afterFetchFinished);

</script>

<div class="page-header-3">
    <div class="page-header-3-title">

        <?php
        $title = 'Events';

        if($type == IKIT_THREE_EVENTS_TYPE_AIGA) {
            $title = 'AIGA Events';
        }
        if($type == IKIT_THREE_EVENTS_TYPE_COMMUNITY) {
            $title = 'Community Events';
        }
        ?>

        <a href="<?php echo ikit_get_request_url(false); ?>"><?php echo $title; ?></a>
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

        <!-- Type filter -->
        <?php

        $show_type_filter = false;

        $args = array();
        $args['post_type'] = array(IKIT_POST_TYPE_IKIT_EVENT_INTERNAL);
        $args['post_status'] = 'publish';
        $args['posts_per_page'] = 1;
        $args['page'] = 1;
        $args['meta_query'] = array(

            array(
            'key' => IKIT_CUSTOM_FIELD_IKIT_EVENT_END_DATE,
            'value' => date_i18n("Y-m-d"), 'compare' => '>=',
            'type' => 'DATE'),

        );

        if(count(get_posts($args)) > 0) {
            $show_type_filter = true;
        }

        ?>

        <?php if($show_type_filter) { ?>

        <?php } ?>

        <div class="page-layout-4-tool">
            <div class="box-button view-filter <?php if($view == IKIT_THREE_EVENTS_VIEW_LIST) { ?>active<?php } ?>" value="list">List</div>
            <div class="box-button view-filter <?php if($view == IKIT_THREE_EVENTS_VIEW_CALENDAR) { ?>active<?php } ?>" value="calendar">Calendar</div>
            <?php if($g_theme_options[IKIT_THREE_THEME_OPTION_EVENTS_HIDE_FEED] == false) { ?>
                <a class="box-button events-feed-link" target="_blank" href="<?php echo ikit_get_page_permalink_by_slug(IKIT_SLUG_PAGE_IKIT_FEED) . '?type=events&post_types=ikit_event,ikit_event_internal'; ?>">+RSS</a>
            <?php } ?>
        </div>

    </td>

    <td class="page-layout-4-content">

        <table>
        <tr>
        <td class="page-layout-4-body">
            <div class="page-layout-4-body-filters">

                <?php if($force_type != true) { ?>

                <div class="page-layout-4-body-filter">
                    <div class="page-layout-4-body-filter-inner">

                        <select class="type-selectbox-filter">
                            <option value="">All Event Types</option>
                            <option value="<?php echo IKIT_THREE_EVENTS_TYPE_AIGA; ?>">AIGA</option>
                            <option value="<?php echo IKIT_THREE_EVENTS_TYPE_COMMUNITY; ?>">Community</option>
                        </select>

                    </div>
                </div>

                <?php } ?>

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
            </div>

            <!-- View filters appear below the selects in mobile -->
            <div class="view-filters-compact">
                <div class="box-button view-filter <?php if($view == IKIT_THREE_EVENTS_VIEW_LIST) { ?>active<?php } ?>" value="list">List</div>
                <div class="box-button view-filter <?php if($view == IKIT_THREE_EVENTS_VIEW_CALENDAR) { ?>active<?php } ?>" value="calendar">Calendar</div>
                <?php if($g_theme_options[IKIT_THREE_THEME_OPTION_EVENTS_HIDE_FEED] == false) { ?>
                    <a class="box-button events-feed-link" target="_blank" href="<?php echo ikit_get_page_permalink_by_slug(IKIT_SLUG_PAGE_IKIT_FEED) . '?type=events&post_types=ikit_event,ikit_event_internal'; ?>">+RSS</a>
                <?php } ?>
            </div>

            <?php if($view == IKIT_THREE_EVENTS_VIEW_LIST) { ?>

                <?php

                $data = array();
                $data['category'] = (isset($_GET['category']) ? $_GET['category'] : null);
                $data['type'] = $type;
                $rendered = ikit_three_ajax_render('ikit_three_ajax_render_events', $data);

                $no_results = false;
                preg_match_all('/num_pages="([0-9]+)"/i', $rendered, $matches);
                if(intval($matches[1][0]) <= 0) {
                    $no_results = true;
                }
                ?>

                <?php if(empty($rendered) == false && $no_results == false) { ?>

                    <div class="infinity-fetcher-content">
                        <?php echo $rendered; ?>
                    </div>

                    <?php ikit_three_render_infinity_fetcher_fetch_button(); ?>

                <?php } else { ?>
                    <div class="no-results">No results found.</div>
                <?php } ?>



            <?php } else { ?>

                <?php

                $data = array();
                $data['category'] = (isset($_GET['category']) ? $_GET['category'] : null);
                $data['type'] = $type;
                $rendered = ikit_three_ajax_render('ikit_three_ajax_render_events_calendar', $data);
                $rendered_compact = ikit_three_ajax_render('ikit_three_ajax_render_events_calendar_compact', $data);
                ?>

                <div class="events-calendar-header">
                    <div class="events-calendar-title"></div>
                    <div class="events-calendar-pager">
                        <div class="events-calendar-prev box-button">Prev</div>
                        <div class="events-calendar-next box-button">Next</div>
                    </div>
                </div>
                <div class="events-calendar-content">
                    <?php echo $rendered; ?>
                </div>
                <div class="events-calendar-content-compact">
                    <?php echo $rendered_compact; ?>
                </div>

            <?php } ?>

        </td>

        <?php if($view == IKIT_THREE_EVENTS_VIEW_LIST) { ?>

            <!-- Expands content to take up extra sidebar space if no widgets -->
            <?php if(is_active_sidebar('events-sidebar')) { ?>
            <td class="page-layout-4-sidebar">
                <?php dynamic_sidebar('events-sidebar');?>
            </td>
            <?php } ?>

        <?php } ?>

        </tr>
        </table>

    </td>

</tr>
</table>

<?php get_footer();?>