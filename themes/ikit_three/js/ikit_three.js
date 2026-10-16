/* ********************************************
 * Markup plugins
 *
 * These plugins are initialized using HTML
 * attributes on the elements themselves.
 *
 * ********************************************/

jQuery.ikit_three = function() {

};

jQuery.ikit_three.onStartDomReadyFunctions = []; // Do setup and initialization here
jQuery.ikit_three.onEndDomReadyFunctions = [];

jQuery.ikit_three.onWindowLoad = function() {

    jQuery.cat.plugin.fluidGrid.grid.onStartWindowLoad();

    jQuery.ikit_three.header.toggleCollapsed();
    jQuery.cat.plugin.breakpointBody.layout();
    jQuery.cat.plugin.anystretchImage.layout();

    jQuery.cat.plugin.fluidGrid.grid.onEndWindowLoad();

};

jQuery.ikit_three.onDomReady = function() {

    jQuery.ikit_three.pageLoader.onStartDomReady();

    for (var i = 0; i < jQuery.ikit_three.onStartDomReadyFunctions.length; i++) {
        var onStartDomReadyFunction = jQuery.ikit_three.onStartDomReadyFunctions[i];
        onStartDomReadyFunction();
    }

    jQuery.cat.plugin.breakpointBody.layout();
    jQuery.ikit_three.widgets.onDomReady();
    jQuery.ikit_three.grid.onDomReady();
    jQuery.cat.plugin.clickRedirect.layout();
    jQuery.ikit_three.infinityFetcher.onDomReady();
    jQuery.cat.plugin.videoSwap.layout();
    jQuery.ikit_three.header.onDomReady();
    jQuery.ikit_three.pageLayout4.onDomReady();
    jQuery.ikit_three.pageLayout5.onDomReady();
    jQuery.ikit_three.pageHeader3.onDomReady();
    jQuery.ikit_three.customSelect.onDomReady();
    jQuery.ikit_three.lightSlider.onDomReady();
    jQuery.selectbox_input.onDomReady();

    // Initialize hover states
    $('.rollover-image').cat().ui().rolloverImage('rollover_src', '_hl', 'rollover');

    for( var i = 0; i < jQuery.ikit_three.onEndDomReadyFunctions.length; i++) {
        var onEndDomReadyFunction = jQuery.ikit_three.onEndDomReadyFunctions[i];
        onEndDomReadyFunction();
    }

    jQuery.cat.plugin.anystretchImage.layout();

    // Add some fading in of stretched images to give impression of loading
    $('.cat-plugin-anystretch-image').each(function() {
        var imageEl = $(this);
        imageEl.css('opacity', 0);
        jQuery.ikit_three.imagesLoaded(imageEl.find('img'), function(instance) {

            // Fade in the image
            imageEl.fadeTo("slow", 1, function() {
                imageEl.css('opacity', '');
            });
        });
    });

    // Initially hide all the isotope images, show them once they are loaded, and relayout the grid
    $('.cat-plugin-fluid-grid img').css('opacity', 0);
    $('.cat-plugin-fluid-grid img').each(function() {

        jQuery.ikit_three.imagesLoaded($(this), function(instance) {

            // Fade in the image
            instance.fadeTo("slow", 1, function() {
                instance.css('opacity', '');
            });

            jQuery.cat.plugin.fluidGrid.isotope.relayout(jQuery.cat.plugin.className('fluid-grid', true));
        });

    });

    // Active cycle slideshows
    $('.cycle2-slideshow').cycle();

    // We run once more as layouts may have changed
    jQuery.ikit_three.grid.layout();

    jQuery.ikit_three.pageLoader.onEndDomReady();

};

jQuery.ikit_three.windowResizeWidth = 0;
jQuery.ikit_three.windowResizeHeight = 0;
jQuery.ikit_three.onWindowResize = function() {

    $('.cat-plugin-fluid-grid').removeClass('animated'); // Animations are always disabled when resizing the window

    if($(window).width() != jQuery.ikit_three.windowResizeWidth || $(window).height() != jQuery.ikit_three.windowResizeHeight) {

        jQuery.cat.plugin.breakpointBody.layout();
        jQuery.ikit_three.grid.layout();
        jQuery.cat.plugin.videoSwap.onWindowResize();
        jQuery.ikit_three.pageLayout4.onWindowResize();
        jQuery.ikit_three.pageLayout5.onWindowResize();
        jQuery.ikit_three.pageHeader3.onWindowResize();

        // We run once more as layouts may have changed
        jQuery.ikit_three.grid.layout();

    }


    jQuery.ikit_three.windowResizeWidth = $(window).width();
    jQuery.ikit_three.windowResizeHeight = $(window).height();

};

jQuery.ikit_three.onWindowScroll = function() {

    jQuery.ikit_three.header.toggleCollapsed();
    jQuery.ikit_three.infinityFetcher.onWindowScroll();
    jQuery.ikit_three.header.onWindowScroll();

};


/**
 * Util
 */
jQuery.ikit_three.util = function() {

};

jQuery.ikit_three.imagesLoaded = function(el, callback) {

    // Handle old style imagesLoaded
    if(el.imagesLoaded.length == 1) {
        el.imagesLoaded(function(instance) {
          callback(instance);
        });
    }
    // Handle new version of imagesLoaded that uses promises in case plugin
    // has required it, e.g. Photoswipe Masonry
    else {
        el.imagesLoaded().always(function(instance) {
            callback($(instance.elements));
        });
    }

};

jQuery.ikit_three.util.lpad = function(str, padStr, length) {
    while (str.length < length)
        str = padStr + str;
    return str;
};

jQuery.ikit_three.util.hasAttr = function(el, name) {
    return $(el).cat().dom().hasAttr(name);
};

/**
 * Fonts
 */

jQuery.ikit_three.fonts = function() {

};

jQuery.ikit_three.fonts.onLoaded = function() {

    // The font may have loaded after all the dom ready and loaded calls have been made
    // so we may need to do another grid layout
    $(document).ready(function() {
       jQuery.ikit_three.grid.layout();
    });

};

/**
 * Light slider
 */
jQuery.ikit_three.lightSlider = function() {

};

jQuery.ikit_three.lightSlider.onDomReady = function() {

    $(".light-slider").lightSlider({
        loop: false,
        pager: false,
        slideMargin: 0,
        galleryMargin: 0,
        thumbMargin: 0,
        item: 2
    });

};

/**
 * Custom select
 */
jQuery.ikit_three.customSelect = function() {

};

jQuery.ikit_three.customSelect.onDomReady = function() {

    jQuery.ikit_three.customSelect.layout();
};

jQuery.ikit_three.customSelect.layout = function() {

    $('.custom-select-input, .gform_wrapper select').selectbox({

        onOpen : function(inst) {
            var sbSelector = $("#sbSelector_" + inst.uid);
            var sbHolder = sbSelector.closest('.sbHolder');
            var sb = sbHolder.siblings('select');

            sbSelector.addClass('open');
            sbHolder.addClass('open');

        },

        onClose : function(inst) {
            var sbSelector = $("#sbSelector_" + inst.uid);
            var sbHolder = sbSelector.closest('.sbHolder');
            var sb = sbHolder.siblings('select');

            sbSelector.removeClass('open');
            sbHolder.removeClass('open');

        },

        onChange : function(value, inst, sbSelector) {

            sbSelector.removeClass('unselected');
            if (value == "") {
                sbSelector.addClass('unselected');
            }

            // XXX for whatever reason, the value isn't ready on the change
            // callback in Android, so we set this attribute instead to key off of
            $(inst.input).attr('selected_value', value);

        },
        onLoad : function(inst, input, sbSelector) {
            if ($(input).val() == "") {
                sbSelector.addClass('unselected');
            }

        }
    });

};

/**
 * Grid
 */
jQuery.ikit_three.grid = function() {

};

jQuery.ikit_three.grid.layout = function() {

    jQuery.cat.plugin.fluidGrid.grid.layout();

};

jQuery.ikit_three.grid.onDomReady = function() {

    jQuery.cat.plugin.fluidGrid.grid.overrideItemWidthFunction = jQuery.ikit_three.grid.overrideItemWidthFunction;
    jQuery.ikit_three.grid.layout();

};

jQuery.ikit_three.grid.getItemWidth = function() {

    var firstLayoutGridItemEl = $('.sizing-grid .grid-item').first();
    return firstLayoutGridItemEl.width();

};

jQuery.ikit_three.grid.overrideItemWidthFunction = function(gridItemEl, columnWidth, numCols) {

    // Mobile everything collapses to single column regardless of grid item size
    if($('.breakpoint-body').hasClass('breakpoint-body-size-s')) {

        gridItemEl.width(columnWidth);
        return true;
    }

    // Anything that goes beyond the window width should just be set at the window width
    if(jQuery.ikit_three.util.hasAttr(gridItemEl, 'cat_plugin_fluid_grid_item_size')) {
        var gridItemWidth = columnWidth * parseInt(gridItemEl.attr('cat_plugin_fluid_grid_item_size'));
        if(gridItemWidth > columnWidth * numCols) {
            gridItemEl.width(columnWidth * numCols);
            return true;
        }
    }

    return false;

};

// Set the grid empty, useful for no results found etc.
jQuery.ikit_three.grid.empty = function(selector, html) {

    jQuery.cat.plugin.fluidGrid.isotope.destroy(selector);
    $(selector).empty();
    $(selector).append('<div class="cat-plugin-fluid-grid-item grid-item"><div class="grid-item-inner"><div class="no-results">' + html + '</div></div></div>');
    jQuery.cat.plugin.fluidGrid.isotope.create(selector);

    // Isotope sizes based on the previous grid elements, so we need to force a layout here, as our dummy
    // grid item has no width yet
    jQuery.ikit_three.grid.layout();

};

// Prepare the ajax response for insertion into the grid
jQuery.ikit_three.grid.prepareAjaxResponseInsert = function(ajaxResponse, gridEl) {

    var gridItemWidth = gridEl.find('.grid-item:first').width();
    for(var i=0;i<ajaxResponse.length;i++) {
        var responseItem = $(ajaxResponse[i]);
        if(responseItem.hasClass('grid-item')) {
            responseItem.width(gridItemWidth);
            responseItem.addClass('appending');
        }
    }

};

/**
 * Widgets
 */
jQuery.ikit_three.widgets = function() {

};

jQuery.ikit_three.widgets.onDomReady = function() {

    $('.widget').addClass('cat-plugin-fluid-grid-item grid-item');

};

/**
 * Page loader
 */
jQuery.ikit_three.pageLoader = function() {

};

jQuery.ikit_three.pageLoader.onStartDomReady = function() {

    // Attach loading indicator to page
    $('.page-loader-dialog').cat().ui().popupDialog(true, null,
      function(dialogEl, modalEl) {
        dialogEl.show();
        modalEl.addClass('page-loader-dialog-modal');
      }
    );

};

jQuery.ikit_three.pageLoader.onEndDomReady = function() {

    $('.page-loader-dialog, .page-loader-dialog-modal').fadeOut(function() {

        $('body').addClass('loaded');
        $('.layout, .header').css('visibility', 'visible');
        $('.cycle2-slideshow').css('opacity', 1);

    });

};

/**
 * Page header 3
 */
jQuery.ikit_three.pageHeader3 = function() {
};

jQuery.ikit_three.pageHeader3.onDomReady = function() {
    jQuery.ikit_three.pageHeader3.onWindowResize();
};

jQuery.ikit_three.pageHeader3.onWindowResize = function() {

    $('.page-header-3').each(function() {
        $(this).find('.page-header-3-section-title').width(jQuery.ikit_three.grid.getItemWidth());
    });
};

/**
 * Page layout 4
 */
jQuery.ikit_three.pageLayout4 = function() {
};

jQuery.ikit_three.pageLayout4.onDomReady = function() {

    jQuery.ikit_three.pageLayout4.onWindowResize();
};

jQuery.ikit_three.pageLayout4.onWindowResize = function() {

    var gridItemWidth = jQuery.ikit_three.grid.getItemWidth();
    $('.page-layout-4').each(function() {
        $(this).find('.page-layout-4-tools, .page-layout-4-filters, .page-layout-4-sidebar, .page-layout-4-body-filter, .page-layout-4-attributes').outerWidth(gridItemWidth);
        $(this).find('.page-layout-4-body-description').outerWidth(gridItemWidth*2);

        // If compact move attributes to be the first column so stacks,
        // otherwise leave as the far right column
        var attributesEl = $(this).find('.page-layout-4-attributes');
        var bodyEl = $(this).find('.page-layout-4-body');
        if($('.breakpoint-body').hasClass('breakpoint-body-size-s-m')) {
            if(attributesEl.next().length <= 0) {
                attributesEl.detach();
                attributesEl.insertBefore(bodyEl);
            }
        }
        else {
            if(attributesEl.next().length > 0) {
                attributesEl.detach();
                attributesEl.insertAfter(bodyEl);
            }
        }

    });

};

/**
 * Page layout 5
 */
jQuery.ikit_three.pageLayout5 = function() {
};

jQuery.ikit_three.pageLayout5.onDomReady = function() {

    jQuery.ikit_three.pageLayout5.onWindowResize();
};

jQuery.ikit_three.pageLayout5.onWindowResize = function() {

    var gridItemWidth = jQuery.ikit_three.grid.getItemWidth();

    $('.page-layout-5').each(function() {
        $(this).find('.page-layout-5-spacer, .page-layout-5-sidebar').width(gridItemWidth);
    });

};

/**
 * Infinity fetcher
 */
jQuery.ikit_three.infinityFetcher = function() {

};

jQuery.ikit_three.infinityFetcher.beforeFilterFunctions = [];
jQuery.ikit_three.infinityFetcher.afterFetchFunctions = [];
jQuery.ikit_three.infinityFetcher.afterFetchFinishedFunctions = [];
jQuery.ikit_three.infinityFetcher.afterAppendFunctions = [];

jQuery.ikit_three.infinityFetcher.page = -1;
jQuery.ikit_three.infinityFetcher.maxPagesReached = false;
jQuery.ikit_three.infinityFetcher.contentContainer = null;
jQuery.ikit_three.infinityFetcher.fetchingIndicator = null;
jQuery.ikit_three.infinityFetcher.fetchButton = null;
jQuery.ikit_three.infinityFetcher.fetching = false;
jQuery.ikit_three.infinityFetcher.fetchingUrl = null;
jQuery.ikit_three.infinityFetcher.fetchingUrlData = {};

jQuery.ikit_three.infinityFetcher.infinityRunnerBottomOffsetThreshold = 200;

jQuery.ikit_three.infinityFetcher.infinityRunner = function() {

    if(jQuery.ikit_three.infinityFetcher.fetchButton == null) {
        if (jQuery.ikit_three.infinityFetcher.fetchingUrl != null && jQuery.ikit_three.infinityFetcher.maxPagesReached == false && jQuery.ikit_three.infinityFetcher.fetching == false && jQuery.ikit_three.infinityFetcher.infinityRunnerBottomOffsetThreshold >= ($(document).height() - ($(window).scrollTop() + $(window).height()))) {
            jQuery.ikit_three.infinityFetcher.fetch();
        }
    }

};

jQuery.ikit_three.infinityFetcher.filter = function(fetchingDataKey, fetchingDataValue) {

    if(jQuery.cat.string.isBlank(fetchingDataValue) == false) {

        // Reset to the first page and set different filter criteria
        jQuery.ikit_three.infinityFetcher.page = 1;
        jQuery.ikit_three.infinityFetcher.maxPagesReached = false;

        jQuery.ikit_three.infinityFetcher.fetchingUrlData[fetchingDataKey] = fetchingDataValue;
        jQuery.ikit_three.infinityFetcher.fetch();

    }
    else {

        jQuery.ikit_three.infinityFetcher.page = 1;
        jQuery.ikit_three.infinityFetcher.maxPagesReached = false;

        jQuery.ikit_three.infinityFetcher.fetchingUrlData[fetchingDataKey] = null;
        jQuery.ikit_three.infinityFetcher.fetch();
    }


};

jQuery.ikit_three.infinityFetcher.fetch = function() {

    if(jQuery.ikit_three.infinityFetcher.fetching != true) {

        jQuery.ikit_three.infinityFetcher.fetching = true;


        if(jQuery.ikit_three.infinityFetcher.fetchingIndicator != null) {
            jQuery.ikit_three.infinityFetcher.fetchingIndicator.show();
        }

        if(jQuery.ikit_three.infinityFetcher.fetchButton != null) {
            jQuery.ikit_three.infinityFetcher.fetchButton.addClass('loading');
        }

        jQuery.ikit_three.infinityFetcher.fetchingUrlData['page'] = jQuery.ikit_three.infinityFetcher.page;

        $.ajax({
            type : "POST",
            url : jQuery.ikit_three.infinityFetcher.fetchingUrl,
            data: jQuery.ikit_three.infinityFetcher.fetchingUrlData,
            success : function(response) {

                if (jQuery.cat.string.isBlank(response) == false) {

                    response = $(response);
                    var data = $(response[response.length-1]);

                    var page = parseInt(data.attr('page'));
                    var numPages = parseInt(data.attr('num_pages'));

                    if(numPages <= page) {

                        jQuery.ikit_three.infinityFetcher.maxPagesReached = true;

                        if(jQuery.ikit_three.infinityFetcher.fetchButton != null) {
                            if(page != 1) {
                                jQuery.ikit_three.infinityFetcher.fetchButton.fadeOut();
                            }
                            else {
                                jQuery.ikit_three.infinityFetcher.fetchButton.hide();
                            }
                        }
                    }

                    for(var i=0; i<jQuery.ikit_three.infinityFetcher.afterFetchFunctions.length; i++) {
                        var afterFetchFunction = jQuery.ikit_three.infinityFetcher.afterFetchFunctions[i];
                        afterFetchFunction(response, page, numPages);
                    }

                    if(jQuery.ikit_three.infinityFetcher.contentContainer != null) {
                        responseEl = $(response);
                        jQuery.ikit_three.infinityFetcher.contentContainer.append(responseEl);

                        for(var i=0; i<jQuery.ikit_three.infinityFetcher.afterAppendFunctions.length; i++) {
                            var afterAppendFunction = jQuery.ikit_three.infinityFetcher.afterAppendFunctions[i];
                            afterAppendFunction(responseEl);
                        }
                    }

                    jQuery.ikit_three.ajaxHelper.reload(); // Do any reloads neccessary on ajax appends

                    jQuery.ikit_three.infinityFetcher.page++;

                }

                jQuery.ikit_three.infinityFetcher.fetching = false;

                // If after fetch function are defined, allow the after fetch to define
                // when the loading has finished
                if(jQuery.ikit_three.infinityFetcher.afterFetchFunctions.length <= 0) {
                    if(jQuery.ikit_three.infinityFetcher.fetchingIndicator != null) {
                        jQuery.ikit_three.infinityFetcher.fetchingIndicator.hide();
                    }
                }

                // Update fetch button to appear not loading anymore
                if(jQuery.ikit_three.infinityFetcher.fetchButton != null) {
                    jQuery.ikit_three.infinityFetcher.fetchButton.removeClass('loading');
                }

                for(var i=0; i<jQuery.ikit_three.infinityFetcher.afterFetchFinishedFunctions.length; i++) {
                    var afterFetchFinishedFunction = jQuery.ikit_three.infinityFetcher.afterFetchFinishedFunctions[i];
                    afterFetchFinishedFunction(response, page, numPages);
                }

            }

        });

    }

};

jQuery.ikit_three.infinityFetcher.onDomReady = function() {

    if(jQuery.ikit_three.infinityFetcher.fetchButton != null) {
        jQuery.ikit_three.infinityFetcher.fetchButton.click(function() {
            jQuery.ikit_three.infinityFetcher.fetch();
        });
    }

    jQuery.ikit_three.infinityFetcher.page = 2;
};

jQuery.ikit_three.infinityFetcher.onWindowScroll = function() {
    jQuery.ikit_three.infinityFetcher.infinityRunner();
};

// Provided generic implementation of after fetch for grid layouts, to handle paging and filtering
jQuery.ikit_three.infinityFetcher.afterFetchGrid = function(selector, response, page, numPages, hasImages) {

    if(numPages > 0) {

        jQuery.ikit_three.grid.prepareAjaxResponseInsert(response, $(selector));

        if(page == 1) {

            if(page < numPages) {
                jQuery.ikit_three.infinityFetcher.fetchButton.show();
            }

            jQuery.cat.plugin.fluidGrid.isotope.destroy(selector);
            $(selector).empty();
            $(selector).append(response);

            if(hasImages) {

                jQuery.ikit_three.imagesLoaded(response, function() {
                    jQuery.cat.plugin.fluidGrid.isotope.create(selector);
                    if(jQuery.ikit_three.infinityFetcher.fetchButton != null) {
                        jQuery.ikit_three.infinityFetcher.fetchButton.removeClass('loading');
                    }
                    jQuery.ikit_three.grid.layout();
                });
            }
            else {
                jQuery.cat.plugin.fluidGrid.isotope.create(selector);
                if(jQuery.ikit_three.infinityFetcher.fetchButton != null) {
                    jQuery.ikit_three.infinityFetcher.fetchButton.removeClass('loading');
                }
                jQuery.ikit_three.grid.layout();
            }


        }
        else {

            // Animate the adding of new elements
            $(selector).addClass('animated');
            $(selector).append(response);

            if(hasImages) {

                $(selector).find('.grid-item.appending').hide();

                jQuery.ikit_three.imagesLoaded(response, function() {
                    $(selector).isotope('appended', response);
                    $(selector).find('.grid-item.appending').show().removeClass('appending');
                    jQuery.ikit_three.infinityFetcher.fetchButton.removeClass('loading');
                    jQuery.ikit_three.grid.layout();
                });
            }
            else {
                $(selector).isotope('appended', response);
                if(jQuery.ikit_three.infinityFetcher.fetchButton != null) {
                    jQuery.ikit_three.infinityFetcher.fetchButton.removeClass('loading');
                }
                jQuery.ikit_three.grid.layout();
            }

        }

    }
    else {

        jQuery.ikit_three.grid.empty(selector, 'No results found.');

    }

};

// Similar to afterFetchGrid but for a non grid layout list version, much simpler.
jQuery.ikit_three.infinityFetcher.afterFetchList = function(selector, response, page, numPages, hasImages) {

    if(numPages > 0) {

        if(page == 1) {

            $(selector).empty();

        }

    }

}

/**
 * Header (nav menu)
 */

jQuery.ikit_three.header = function() {

}

jQuery.ikit_three.header.toggleCollapsed = function() {
    // If the page is scrolled beyond the threshold, the header will switch to the collapsed version (only in wide viewports)
    var headerLayoutContainerCollapsedEl = $('.header-layout-container-collapsed');
    var collapseThreshold = 500;
    if($('body').scrollTop() > collapseThreshold || $('html').scrollTop() > collapseThreshold) {
        $(headerLayoutContainerCollapsedEl).attr('data-show', true);
    }
    else {
        $(headerLayoutContainerCollapsedEl).attr('data-show', false);
    }

}

jQuery.ikit_three.header.onWindowScroll = function() {

    // If compact menu is open and the there is any space bewteen
    // the top of the window and the menu, lock it to the top,
    // not they can still move downwards, disable in mobile
    // as iOS is screwed up with the fixed positioning and browser bar...
    var compactMenuEl = $('.header-compact-menu');
    if(bowser.mobile != true) {

        if(compactMenuEl.attr('data-expanded') == 'true') {
            if($(window).scrollTop() - compactMenuEl.offset().top <= 0) {
                compactMenuEl.css('top', $(window).scrollTop());
            }
        }

    }

}

jQuery.ikit_three.header.onCompactMenuOpen = function() {
    var compactMenuEl = $('.header-compact-menu');
    compactMenuEl.attr('data-expanded', true);

    // Freeze so they can scoll down the menu
    compactMenuEl.css('position', 'absolute');
    compactMenuEl.css('top', $(window).scrollTop());

}

jQuery.ikit_three.header.onCompactMenuClose = function() {
    var compactMenuEl = $('.header-compact-menu');
    compactMenuEl.attr('data-expanded', false);

    // Unfreeze
    setTimeout(function()  {
        compactMenuEl.css('position', '');
        compactMenuEl.css('top', '');
    }, 300)

}

jQuery.ikit_three.header.onDomReady = function() {

    // Compact nav menu close
    var closeButtonEl = $('.header-compact-menu-button-close');
    var compactMenuButtonEl = $('.header-compact-menu-button-open');

    $(closeButtonEl).on('click', function() {
        var compactMenuEl = $('.header-compact-menu');
        var compactMenuExpanded = $(compactMenuEl).attr('data-expanded');

        if(compactMenuExpanded == 'true') {
            jQuery.ikit_three.header.onCompactMenuClose();
        }
        else {
            jQuery.ikit_three.header.onCompactMenuOpen();

        }
    });

    // Compact nav menu open
    $(compactMenuButtonEl).on('click', function() {
        var compactMenuEl = $('.header-compact-menu');
        var compactMenuExpanded = $(compactMenuEl).attr('data-expanded');
        if(compactMenuExpanded == 'true') {
            jQuery.ikit_three.header.onCompactMenuClose();
        }
        else {
            jQuery.ikit_three.header.onCompactMenuOpen();
        }
    });

    // Compact nav menu item (categories) expand
    var menuCategoryEls = $('.header-compact-menu-item');
    for(var i=0; i<menuCategoryEls.length; i++) {
        if($(menuCategoryEls[i]).find('.header-compact-menu-item-children-item').length > 0) {

            $(menuCategoryEls[i]).on('click', menuCategoryEls[i], function(event) {

                var menuCategoryListEl = $(event.data).find('.header-compact-menu-item-children');

                // Set the expanded attribute on this element so we don't have to check elsewhere
                // Otherwise the expand icons would have to look at their cousins
                var categoryEl = this;

                // If expanded, the link will go to the toc page instead of collapsing
                if($(categoryEl).attr('data-expanded') == 'true') {
                    var categoryTitleEl = $(categoryEl).find('.header-compact-menu-item-link-expand');
                    $(categoryTitleEl).attr('href', categoryTitleEl.attr('data-url'));
                }
                else {
                    $(menuCategoryListEl).slideDown();
                    $(categoryEl).attr('data-expanded', true);
                }
            });

        }
    }

    // Search bar toggle
    var searchEl = $('.header-search-button');

    $(searchEl).on('click', function() {

        var searchEl = $(this).closest('.header-search');
        var searchBarEl = searchEl.find('.header-search-bar');
        if(searchBarEl.length == 1) {

            // Toggle search
            var expanded = $(searchEl).attr('data-expanded');

            if(expanded == 'true') {
                $(searchBarEl).stop(true, true).animate(
                    {'width': '0%'},
                    250,
                    'swing',
                    function() {
                        $(searchEl).attr('data-expanded', false);
                    }
                );
            }
            else {
                $(searchBarEl).stop(true, true).animate(
                    {'width': '100%'},
                    250,
                    'swing',
                    function() {
                        $(searchEl).attr('data-expanded', true);

                        // Focus the input
                        searchBarEl.find('input').focus();

                    }
                );
            }
        }
    });

    // Clicking anywhere else on the header (outside the search bar) also triggers the search bar collapse
    $('.header-search-collapse-panel').on('click', function() {
        $('.header-search-bar').stop(true, true).animate(
                {'width': '0%'},
                250,
                'swing',
                function() {
                    $('.header-search').attr('data-expanded', false);
                }
            );
    });

    // Compact search bar toggle
    var searchCompactEl = $('.header-compact-button-search');

    $(searchCompactEl).on('click', function() {
        var compactSearchBarEl = $('.header-compact-search');

        if(compactSearchBarEl.length == 1) {
            var expanded = $(compactSearchBarEl).attr('data-expanded');
            if(expanded == 'true') {
                $(compactSearchBarEl).slideUp(function() {
                    $(compactSearchBarEl).attr('data-expanded', false);
                    $('.header-compact-button-search-open-image').show();
                    $('.header-compact-button-search-close-image').hide();
                });
            }
            else {
                $(compactSearchBarEl).slideDown(function() {
                    $(compactSearchBarEl).attr('data-expanded', true);
                    $('.header-compact-button-search-open-image').hide();
                    $('.header-compact-button-search-close-image').show();

                    // Focus the input
                    compactSearchBarEl.find('input').focus();
                });
            }
        }
    });
}

/**
 * Ajax helper
 */

jQuery.ikit_three.ajaxHelper = function() {

};

jQuery.ikit_three.ajaxHelper.reload = function() {
    jQuery.cat.plugin.clickRedirect.layout();
};

/* ********************************************
 * Core events
 *
 * These are built in browser events.
 *
 * ********************************************/

$(window).resize(function() {
    jQuery.ikit_three.onWindowResize();
});

$(window).load(function() {
    jQuery.ikit_three.onWindowLoad();
});

$(document).ready(function() {
    jQuery.ikit_three.onDomReady();
});

$(window).scroll(function() {
    jQuery.ikit_three.onWindowScroll();
});
