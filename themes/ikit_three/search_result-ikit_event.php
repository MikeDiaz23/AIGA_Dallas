<?php
    $ikit_event_meta = ikit_event_get_meta($post->ID);
    $event = ikit_event_get_meta_normalized($post->ID, $ikit_event_meta, null);
    $event_image = $event['image'];
    $event_start_date = $event['start_date'];
    $event_end_date = $event['end_date'];
    $event_location_city = $event['location_city'];
    $internal = false;

    if($ikit_event_meta->service == IKIT_EVENT_SERVICE_INTERNAL) {
        $internal = true;
    }

?>

<div class="cat-plugin-fluid-grid-item grid-item search-result">
    <div class="grid-item-inner">

        <a class="link-block" href="<?php the_permalink(); ?>">

            <?php if($event_image != null) { ?>
                <div class="link-block-image search-result-image cat-plugin-anystretch-image" cat_plugin_anystretch_image_alt="Event image" cat_plugin_anystretch_image_url="<?php echo ikit_three_image_resize($event_image, IKIT_THREE_IMAGE_RESIZE_SMALL); ?>"></div>
            <?php } ?>

            <div class="search-result-title"><?php echo $post->post_title; ?></div>
            <div class="search-result-date"><?php echo $event_start_date;?> <?php if($event_end_date != $event_start_date) { echo  ' - ' . $event_end_date; } ?></div>

            <?php if(!empty($event_location_city)) { ?>
                <div class="search-result-event-location"><?php echo $event_location_city; ?></div>
            <?php } ?>

            <div class="search-result-type">Event</div>

            <?php ikit_three_render_sso_lock(array("post_id" => $post->ID)); ?>

        </a>

    </div>
</div>