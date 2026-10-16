<?php
/**
 * Template Name: Single Event
 */
// If returning from SSO, display the event, otherwise forward to SSO for login
if ( have_posts() ) while ( have_posts() ) : the_post();

global $id;

$sso_key = ikit_sso_get_redirect_token();
if(empty($sso_key)) {

    // If a locked event and trying to view without sso key, redirect to sso
    if(ikit_sso_has_lock($id)) {
        wp_redirect(ikit_sso_get_login_url(get_permalink(), IKIT_SSO_REDIRECT_SOURCE_LOCK));
        exit;
    }
}
// Otherwise if not lock and returning from SSO, go to Eventbrite
else if(ikit_sso_get_redirect_source() == IKIT_SSO_REDIRECT_SOURCE_EVENTBRITE_REGISTER) {
    ikit_event_eventbrite_sso_redirect($id, $sso_key);
}

endwhile;

?>
<?php get_header();?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post();

    global $id;

    $ikit_event_meta = ikit_event_get_meta($id);
    $event = ikit_event_get_meta_normalized($id, $ikit_event_meta, null);

    $event_attendees_error_no_attendees = null;
    $event_link_title = null;

    // Determine whether to show the register link or not
    $display_register_link = true;
    $registration_type = get_post_meta($id, IKIT_CUSTOM_FIELD_IKIT_EVENT_REGISTRATION_TYPE, true);
    if($registration_type == IKIT_CUSTOM_FIELD_IKIT_EVENT_REGISTRATION_TYPE_DISABLED) {
        $display_register_link = false;
    }

    // Set various titles based on event types and services
    if($ikit_event_meta->service == IKIT_EVENT_SERVICE_EVENTBRITE) {

        $event_link_title = 'Register Now';
        $event_attendees_error_no_attendees = 'No attendees at this time.';

    }
    else if($ikit_event_meta->service == IKIT_EVENT_SERVICE_FONTEVA) {

        $event_link_title = 'Register Now';
        $event_attendees_error_no_attendees = 'No attendees at this time.';

    }
    else if($ikit_event_meta->service == IKIT_EVENT_SERVICE_IMPEXIUM) {

        $event_link_title = 'Register Now';
        $event_attendees_error_no_attendees = 'No attendees at this time.';

    }
    else if($ikit_event_meta->service == IKIT_EVENT_SERVICE_ETOUCHES) {

        $event_link_title = 'Register Now';

        if($ikit_event_meta->status == 'Sold Out') {
            $event_link_title = 'Join the Waitlist';
        }

        // Archived events do not show the register link
        if($ikit_event_meta->status == 'Archived') {
            $display_register_link = false;
        }

        $event_attendees_error_no_attendees = 'No registered members at this time.';

    }

    $registration_title = get_post_meta($id, IKIT_CUSTOM_FIELD_IKIT_EVENT_REGISTRATION_TITLE, true);
    if(empty($registration_title) == false) {
        $event_link_title = $registration_title;
    }

    // Determine whether is an upcoming or past event based on the event's end date
    $is_upcoming_event = false;
    $post_date = strtotime( mysql2date('Y-m-d', $event['end_date_raw']) );
    $current_date = strtotime( date( 'Y-m-d' ) );
    if($post_date >= $current_date) {
        $is_upcoming_event = true;
    }

    $start_date_abbr = mysql2date('D, M j, Y', get_gmt_from_date($event['start_date_raw']), false);
    $end_date_abbr = mysql2date('D, M j, Y', get_gmt_from_date($event['end_date_raw']), false);

    $additional_information = get_post_meta($id, IKIT_CUSTOM_FIELD_IKIT_EVENT_ADDITIONAL_INFORMATION, true);
    $description_override = get_post_meta($id, IKIT_CUSTOM_FIELD_IKIT_EVENT_DESCRIPTION_OVERRIDE, true);

    $attendee_list_enabled = $g_theme_options[IKIT_THREE_THEME_OPTION_EVENT_ATTENDEE_LIST_ENABLED];
    if($attendee_list_enabled != true) {
      $attendee_list_enabled = get_post_meta($id, IKIT_CUSTOM_FIELD_IKIT_EVENT_ATTENDEE_LIST_ENABLED, true);
    }

    // Disabled due to privacy concerns
    $attendee_list_enabled = false;

    ?>

    <div class="page-header-4">

        <?php if(empty($event['image']) == false && $g_theme_options[IKIT_THREE_THEME_OPTION_EVENTS_SINGLE_SMALL_HERO_IMAGE_ENABLED] == false) { ?>
            <div class="page-header-4-title-container">
                <div class="page-header-4-title">
                    <?php the_title(); ?>
                </div>
            </div>
            <div class="page-header-4-image-container">
                <div class="page-header-4-image cat-plugin-anystretch-image" cat_plugin_anystretch_image_alt="Event image" cat_plugin_anystretch_image_url="<?php echo ikit_three_image_resize($event['image'], IKIT_THREE_IMAGE_RESIZE_LARGE); ?>"></div>
            </div>
        <?php } else { ?>
            <div class="page-header-5-title-container">
                <div class="page-header-5-title">
                    <?php the_title(); ?>
                </div>
            </div>
        <?php } ?>

    </div>

    <table class="page-layout-4">
    <tr>

        <td class="page-layout-4-tools">
            <div class="page-layout-4-tool">
                <?php ikit_three_render_social_share([array('name' => 'addtocal', 'render' => function($render_context) { ikit_three_render_event_add_to_calendar($render_context); }, 'render_context' => ikit_three_render_event_add_to_calendar_context($event))]); ?>
            </div>
        </td>

        <td class="page-layout-4-content">

            <table>
            <tr>
            <td class="page-layout-4-body">
                <?php if(empty($event['image']) == false && $g_theme_options[IKIT_THREE_THEME_OPTION_EVENTS_SINGLE_SMALL_HERO_IMAGE_ENABLED] == true) { ?>
                <div class="page-layout-4-body-image cat-plugin-anystretch-image" cat_plugin_anystretch_image_alt="Event image" cat_plugin_anystretch_image_url="<?php echo $event['image']; ?>"></div>
                <?php } ?>
                <div class="page-layout-4-body-paragraph-text wp-editor">

                    <div class="event-description">
                        <?php if(empty($description_override)) { ?>
                            <?php echo $event['description']; ?>
                        <?php } else { ?>
                            <?php echo $description_override; ?>
                        <?php } ?>
                    </div>

                    <?php if(empty($additional_information) == false) { ?>
                        <div class="additional-information"><?php echo wpautop(do_shortcode($additional_information)); ?></div>
                    <?php } ?>
                </div>
            </td>

            <td class="page-layout-4-attributes">

                <div class="page-layout-4-attributes-inner">

                    <div class="page-layout-4-attribute">
                        <div class="page-layout-4-attribute-header">When & Where</div>
                        <div class="page-layout-4-attribute-text">

                            <span class="event-date"><?php echo $start_date_abbr;?> <?php if($event['end_date'] != $event['start_date']) { echo ' - ' . $end_date_abbr; } ?></span>
                            <?php if(ikit_event_has_time($event['start_time_raw'])) { ?>
                                <span class="event-time"><?php echo date('g:i A', $event['start_time']); ?> - <?php echo date('g:i A', $event['end_time']); ?></span>
                                <?php if($event['timezone_abbreviation'] != null) { ?>
                                  <span><?php echo $event['timezone_abbreviation']; ?></span>
                                <?php } ?>
                            <?php } ?>

                            <?php if(empty($event['location_name']) == false || empty($event['location_city']) == false || empty($event['location_address1']) == false || empty($event['location_address2']) == false) { ?>
                            <div class="event-location">
                                <div class="event-location-inner">
                                    <?php if($event['location_name'] != $event['location_city']) { ?>
                                        <div class="event-location-name"><?php echo $event['location_name']; ?></div>
                                    <?php } ?>
                                    <div class="event-location-address1"><?php echo $event['location_address1']; ?></div>
                                    <div class="event-location-address2"><?php echo $event['location_address2']; ?></div>
                                    <div class="event-location-city-state-zip"><?php echo $event['location_city']; ?><?php if(empty($event['location_city']) == false && empty($event['location_state']) == false) { echo ', '; } ?> <?php echo $event['location_state']; ?> <?php if($event['location_postal_code'] != '0') { echo $event['location_postal_code']; } ?></div>
                                </div>
                            </div>
                            <?php } ?>

                        </div>
                    </div>

                    <?php if(!empty($event['location_address1']) && !empty($event['location_city'])) { ?>
                    <div class="page-layout-4-attribute">
                        <iframe
                            class="event-location-map"
                            frameborder="0" style="border:0"
                            src="https://www.google.com/maps/embed/v1/place?key=<?php echo IKIT_API_KEY_GOOGLE_MAPS; ?>&q=<?php echo $event['location_address1'] . ' ' . $event['location_address2'] . ' ' . $event['location_city'] . ' ' . $event['location_state']. ' ' . $event['location_postal_code']; ?>">
                        </iframe>
                    </div>
                    <?php } ?>

                    <?php if($is_upcoming_event && $display_register_link) { ?>

                    <div class="page-layout-4-attribute">
                        <?php if($event['service'] == IKIT_EVENT_SERVICE_EVENTBRITE && $event['eventbrite_sync_data']) { ?>
                            <div class="page-layout-4-attribute-actions">
                                <div class="page-layout-4-attribute-header eventbrite-registration-link-header">Register as</div>
                                <a class="box-button eventbrite-member-registration-link" target="<?php echo $event['url_target'];?>" href="<?php echo $event['url'];?>">Member</a>
                                <a class="box-button eventbrite-non-member-registration-link" target="<?php echo $event['url_target'];?>" href="<?php echo $ikit_event_meta->url; ?>">Non-member</a>
                            </div>
                        <?php } else { ?>
                            <div class="page-layout-4-attribute-actions">
                                <a class="box-button event-registration-link" target="<?php echo $event['url_target'];?>" href="<?php echo $event['url'];?>"><?php echo $event_link_title; ?></a>
                            </div>
                        <?php } ?>
                    </div>

                    <?php } ?>

                </div>

            </td>
            </tr>
            </table>

        </td>

    </tr>
    </table>

    <?php ikit_three_render_related_items($post->ID); ?>

    <?php if($attendee_list_enabled) { ?>

    <div class="page-layout-5 attendees">
    <div class="page-layout-5-inner">
        <table>
        <tr>
        <td class="page-layout-5-spacer"/>
        <td class="page-layout-5-body">

            <div class="page-layout-5-body-title">Currently Registered</div>

            <div class="page-layout-5-body-grid">

                <div id="ajax-hook-event-attendees" class="cat-plugin-fluid-grid grid"
                    cat_plugin_fluid_grid_layout_mode="fitRows"
                    cat_plugin_fluid_grid_breakpoint_body_size_num_cols="<?php echo IKIT_THREE_PAGE_LAYOUT_5_FLUID_GRID_BREAKPOINT_BODY_SIZE_NUM_COLS; ?>"
                    cat_plugin_fluid_grid_breakpoint_body_size_classes="<?php echo IKIT_THREE_FLUID_GRID_BREAKPOINT_BODY_SIZE_CLASSES; ?>"
                    cat_plugin_fluid_grid_breakpoint_body_class="<?php echo IKIT_THREE_FLUID_GRID_BREAKPOINT_BODY_CLASS; ?>"
                >

                    <div class="cat-plugin-fluid-grid-item grid-item attendees-loading">
                        <div class="grid-item-inner">
                            Loading...
                       </div>
                    </div>

                </div>

            </div>

        </td>

        </tr>
        </table>

    </div>
    </div>

    <?php } ?>

    <?php if($g_theme_options[IKIT_THREE_THEME_OPTION_COMMENTS_ENABLED_IKIT_EVENT]) { ?>
        <?php if(comments_open($post->ID)) { ?>
            <?php ikit_three_render_comments(); ?>
        <?php } ?>
    <?php } ?>

    <?php
endwhile;?>

<script type="text/javascript">

jQuery.single_ikit_event = function() {

};

jQuery.single_ikit_event.onDomReady = function() {

    $.ajax({
        type: 'POST',
        url: '<?php echo IKIT_AJAX_URL; ?>',
        data: { 'action': 'ikit_three_ajax_get_event_attendees', event_id: '<?php echo $event['id']; ?>', event_service: '<?php echo $event['service']; ?>' },
        context: document.body,
        success: function(data) {

            $('.attendees-loading').addClass('grid-item-hidden');

            var attendees = $.parseJSON(data);

            // Destroy grid
            $('#ajax-hook-event-attendees').find('.grid-item').remove(); // Do no remove the title
            jQuery.cat.plugin.fluidGrid.isotope.destroy('#ajax-hook-event-attendees');

            if(attendees.length > 0) {

                var buf = [];
                for(var i=0;i<attendees.length;i++) {

                    if(i % 10 == 0) {
                        if(i != 0) {
                            buf.push('</div></div>');
                        }
                        buf.push('<div class="cat-plugin-fluid-grid-item grid-item"><div class="grid-item-inner">');
                    }

                    buf.push('<div>' + attendees[i] + '</div>');
                }

                $('#ajax-hook-event-attendees').append(buf.join(""));

            }
            else {
                $('#ajax-hook-event-attendees').append('<div class="cat-plugin-fluid-grid-item grid-item"><div class="grid-item-inner"><?php echo $event_attendees_error_no_attendees; ?></div></div>');
            }

            // Create grid
            jQuery.ikit_three.grid.layout();
            jQuery.cat.plugin.fluidGrid.isotope.create('#ajax-hook-event-attendees');

        },
        error: function() {

            // Hide the attendees as an error occurred
            $('.attendees').hide();

        }

      });

};

$(document).ready(function() {
    jQuery.single_ikit_event.onDomReady();
});

</script>

<?php get_footer();?>
