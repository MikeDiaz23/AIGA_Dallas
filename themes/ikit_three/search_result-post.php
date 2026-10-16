<?php

    $news_image = ikit_post_get_image_url($post->ID, 'full', null);

?>

<div class="cat-plugin-fluid-grid-item grid-item search-result">
    <div class="grid-item-inner">

        <a class="link-block" href="<?php the_permalink(); ?>">

            <?php if($news_image != null) { ?>
                <div class="link-block-image search-result-image cat-plugin-anystretch-image" cat_plugin_anystretch_image_alt="News image" cat_plugin_anystretch_image_url="<?php echo ikit_three_image_resize($news_image, IKIT_THREE_IMAGE_RESIZE_SMALL); ?>"></div>
            <?php } ?>

            <div class="search-result-title"><?php echo $post->post_title; ?></div>

            <?php if(ikit_three_get_post_date($post) != null) { ?>
                <div class="search-result-date"><?php echo mysql2date('F j, Y', get_gmt_from_date($post->post_date), false);?></div>
            <?php } ?>

            <div class="search-result-type">News</div>

        </a>

    </div>
</div>