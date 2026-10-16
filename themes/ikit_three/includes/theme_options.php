<?php

function ikit_three_theme_options_page_render() {

  // Include for success and error messages
  include_once 'options-head.php';

  ?>

  <div class='wrap'>

    <div id="icon-options-general" class="icon32"></div><h2>Theme Options</h2>

    <form method="post" enctype="multipart/form-data" action="options.php">

    <div class="wp-box">

      <?php settings_fields('ikit_three_theme_options'); ?>
      <?php $theme_options = get_option(IKIT_THREE_THEME_OPTION_GROUP_GENERAL); ?>
      <table class="form-table">

        <tr valign="top">
          <th scope="row">AIGA chapter logo for header</th>
          <td>
          <input name="<?php echo IKIT_THREE_THEME_OPTION_AIGA_HEADER_LOGO_IMAGE; ?>" type="file"></input>
          </td>
        </tr>
        <tr>
          <th scope="row"></th>
          <td>

          <img src="<?php echo $theme_options[IKIT_THREE_THEME_OPTION_AIGA_HEADER_LOGO_IMAGE]['url']; ?>"/>
          </td>
        </tr>

        <tr valign="top">
          <th scope="row">AIGA chapter logo for collapsed header</th>
          <td>
            <input name="<?php echo IKIT_THREE_THEME_OPTION_AIGA_HEADER_LOGO_ALT_IMAGE; ?>" type="file"></input>
          </td>
        </tr>
        <tr>
          <th scope="row"></th>
          <td>
            <img src="<?php echo $theme_options[IKIT_THREE_THEME_OPTION_AIGA_HEADER_LOGO_ALT_IMAGE]['url']; ?>"/>
          </td>
        </tr>

        <tr valign="top">
          <th scope="row">Favicon</th>
          <td>
          <input name="<?php echo IKIT_THREE_THEME_OPTION_FAV_ICON; ?>" type="file"></input>
          </td>
        </tr>
        <tr>
          <th scope="row"></th>
          <td>

          <img src="<?php echo $theme_options[IKIT_THREE_THEME_OPTION_FAV_ICON]['url']; ?>"/>
          </td>
        </tr>

        <tr valign="top">
            <th scope="row">Custom font embed code
            <div class="note">
            You can replace the default custom font embed with your own. For example, if you have your own TypeKit account, you would enter the font embed code here.
            <BR/>
            <BR/>
            If you are using a font loader such as TypeKit, you must call the function "jQuery.ikit_three.fonts.onLoaded" once your fonts have loaded, otherwise some of the grid layouts may not load properly:<BR/>
            <BR/>
            For TypeKit:

<pre>
Typekit.load({
    active: jQuery.ikit_three.fonts.onLoaded,
    inactive: jQuery.ikit_three.fonts.onLoaded
});
</pre>

            </div>
            </th>
            <td>

            <textarea rows="5" cols="50" name="<?php echo IKIT_THREE_THEME_OPTION_GROUP_GENERAL . '[' . IKIT_THREE_THEME_OPTION_CUSTOM_FONT_EMBED_CODE . ']'; ?>"><?php if(isset($theme_options[IKIT_THREE_THEME_OPTION_CUSTOM_FONT_EMBED_CODE])) { echo $theme_options[IKIT_THREE_THEME_OPTION_CUSTOM_FONT_EMBED_CODE]; } ?></textarea>
            </td>
        </tr>

        <tr valign="top">
          <th scope="row">Enable commenting on events
          <div class="note">If enabled you may still disable commenting on a particular event by unchecking allow comments in the discussion section. If disabled disregards any individual event discussion setting and disables commenting on all events.</div>
          </th>
          <td>
          <input <?php checked('1', $theme_options[IKIT_THREE_THEME_OPTION_COMMENTS_ENABLED_IKIT_EVENT]); ?> name="<?php echo IKIT_THREE_THEME_OPTION_COMMENTS_ENABLED_IKIT_EVENT; ?>" type="checkbox"/>
          </td>
        </tr>

        <tr valign="top">
          <th scope="row">Enable commenting on news
          <div class="note">If enabled you may still disable commenting on a particular post by unchecking allow comments in the discussion section. If disabled disregards any individual post discussion setting and disables commenting on all events.</div>
          </th>
          <td>
          <input <?php checked('1', $theme_options[IKIT_THREE_THEME_OPTION_COMMENTS_ENABLED_POST]); ?> name="<?php echo IKIT_THREE_THEME_OPTION_COMMENTS_ENABLED_POST; ?>" type="checkbox"/>
          </td>
        </tr>

        <tr valign="top">
          <th scope="row">Enable calendar view as default for events page</th>
          <td>
          <input <?php checked('1', $theme_options[IKIT_THREE_THEME_OPTION_DEFAULT_CALENDAR_VIEW_EVENTS]); ?> name="<?php echo IKIT_THREE_THEME_OPTION_DEFAULT_CALENDAR_VIEW_EVENTS; ?>" type="checkbox"/>
          </td>
        </tr>

        <tr valign="top">
          <th scope="row">Enable person detail pages</th>
          <td>
          <input <?php checked('1', $theme_options[IKIT_THREE_THEME_OPTION_SINGLE_ENABLED_IKIT_PERSON]); ?> name="<?php echo IKIT_THREE_THEME_OPTION_SINGLE_ENABLED_IKIT_PERSON; ?>" type="checkbox"/>
          </td>
        </tr>

        <tr valign="top">
          <th scope="row">Enable separate community events page
          <div class="note">If enabled the events page will no longer display community events. You will then need to create a new page with the page template set to "Events Community". That newly created page will display only community events.</div>
          </th>
          <td>
          <input <?php checked('1', $theme_options[IKIT_THREE_THEME_OPTION_IKIT_EVENTS_INTERNAL_SEPARATE_PAGE]); ?> name="<?php echo IKIT_THREE_THEME_OPTION_IKIT_EVENTS_INTERNAL_SEPARATE_PAGE; ?>" type="checkbox"/>
          </td>
        </tr>

        <tr valign="top">
          <th scope="row">Hide events feed link
          <div class="note">Optionally hide the feed link that appears on the events page.</div>
          </th>
          <td>
          <input <?php checked('1', $theme_options[IKIT_THREE_THEME_OPTION_EVENTS_HIDE_FEED]); ?> name="<?php echo IKIT_THREE_THEME_OPTION_EVENTS_HIDE_FEED; ?>" type="checkbox"/>
          </td>
        </tr>

        <tr valign="top">
          <th scope="row">Enable small hero images on persons detail pages
          <div class="note">If enabled the hero images on persons posts will conform to the content width. Persons detail pages must be enabled.</div>
          </th>
          <td>
          <input <?php checked('1', $theme_options[IKIT_THREE_THEME_OPTION_PERSONS_SINGLE_SMALL_HERO_IMAGE_ENABLED]); ?> name="<?php echo IKIT_THREE_THEME_OPTION_PERSONS_SINGLE_SMALL_HERO_IMAGE_ENABLED; ?>" type="checkbox"/>
          </td>
        </tr>

        <tr valign="top">
          <th scope="row">Enable sponsor detail pages</th>
          <td>
          <input <?php checked('1', $theme_options[IKIT_THREE_THEME_OPTION_SINGLE_ENABLED_IKIT_SPONSOR]); ?> name="<?php echo IKIT_THREE_THEME_OPTION_SINGLE_ENABLED_IKIT_SPONSOR; ?>" type="checkbox"/>
          </td>
        </tr>

        <tr valign="top">
          <th scope="row">Hide chapter sponsors in footer</th>
          <td>
          <input <?php checked('1', $theme_options[IKIT_THREE_THEME_OPTION_FOOTER_HIDE_LOCAL_SPONSORS]); ?> name="<?php echo IKIT_THREE_THEME_OPTION_FOOTER_HIDE_LOCAL_SPONSORS; ?>" type="checkbox"/>
          </td>
        </tr>

        <tr valign="top">
          <th scope="row">Enable small hero images on news detail pages
          <div class="note">If enabled the hero images on news posts will conform to the content width.</div>
          </th>
          <td>
          <input <?php checked('1', $theme_options[IKIT_THREE_THEME_OPTION_NEWS_SINGLE_SMALL_HERO_IMAGE_ENABLED]); ?> name="<?php echo IKIT_THREE_THEME_OPTION_NEWS_SINGLE_SMALL_HERO_IMAGE_ENABLED; ?>" type="checkbox"/>
          </td>
        </tr>

        <tr valign="top">
          <th scope="row">Enable small hero images on events detail pages
          <div class="note">If enabled the hero images on events posts will conform to the content width.</div>
          </th>
          <td>
          <input <?php checked('1', $theme_options[IKIT_THREE_THEME_OPTION_EVENTS_SINGLE_SMALL_HERO_IMAGE_ENABLED]); ?> name="<?php echo IKIT_THREE_THEME_OPTION_EVENTS_SINGLE_SMALL_HERO_IMAGE_ENABLED; ?>" type="checkbox"/>
          </td>
        </tr>

        <tr valign="top">
          <th scope="row">Enable small header
          <div class="note">If enabled the header will be permanently locked to the collapsed version.</div>
          </th>
          <td>
          <input <?php checked('1', $theme_options[IKIT_THREE_THEME_OPTION_HEADER_LOCK_COLLAPSED_ENABLED]); ?> name="<?php echo IKIT_THREE_THEME_OPTION_HEADER_LOCK_COLLAPSED_ENABLED; ?>" type="checkbox"/>
          </td>
        </tr>

      </table>

    </div>

    <p class="submit">
    <input type="submit" class="button-primary" value='Save Changes' />
    </p>

    </form>

  </div>

  <?php

}

function ikit_three_theme_options_init(){
  register_setting( 'ikit_three_theme_options', IKIT_THREE_THEME_OPTION_GROUP_GENERAL, 'ikit_three_theme_options_validate');
}

add_action('admin_init', 'ikit_three_theme_options_init' );

function ikit_three_theme_options_validate($input) {

  $theme_options = get_option(IKIT_THREE_THEME_OPTION_GROUP_GENERAL);

  if(!$_FILES[IKIT_THREE_THEME_OPTION_AIGA_HEADER_LOGO_IMAGE]['error']) {

    $file = wp_handle_upload($_FILES[IKIT_THREE_THEME_OPTION_AIGA_HEADER_LOGO_IMAGE], array('test_form' => false));
    $input[IKIT_THREE_THEME_OPTION_AIGA_HEADER_LOGO_IMAGE] = $file;

  }
  else {

    $input[IKIT_THREE_THEME_OPTION_AIGA_HEADER_LOGO_IMAGE] = $theme_options[IKIT_THREE_THEME_OPTION_AIGA_HEADER_LOGO_IMAGE];

  }

  if(!$_FILES[IKIT_THREE_THEME_OPTION_AIGA_HEADER_LOGO_ALT_IMAGE]['error']) {

      $file = wp_handle_upload($_FILES[IKIT_THREE_THEME_OPTION_AIGA_HEADER_LOGO_ALT_IMAGE], array('test_form' => false));
      $input[IKIT_THREE_THEME_OPTION_AIGA_HEADER_LOGO_ALT_IMAGE] = $file;

  }
  else {

      $input[IKIT_THREE_THEME_OPTION_AIGA_HEADER_LOGO_ALT_IMAGE] = $theme_options[IKIT_THREE_THEME_OPTION_AIGA_HEADER_LOGO_ALT_IMAGE];

  }


  if(!$_FILES[IKIT_THREE_THEME_OPTION_FAV_ICON]['error']) {

    $file = wp_handle_upload($_FILES[IKIT_THREE_THEME_OPTION_FAV_ICON], array('test_form' => false));
    $input[IKIT_THREE_THEME_OPTION_FAV_ICON] = $file;

  }
  else {

    $input[IKIT_THREE_THEME_OPTION_FAV_ICON] = $theme_options[IKIT_THREE_THEME_OPTION_FAV_ICON];

  }

  $input[IKIT_THREE_THEME_OPTION_COMMENTS_ENABLED_POST] = (isset($_POST[IKIT_THREE_THEME_OPTION_COMMENTS_ENABLED_POST]) and $_POST[IKIT_THREE_THEME_OPTION_COMMENTS_ENABLED_POST] == 'on' ? 1 : 0);
  $input[IKIT_THREE_THEME_OPTION_COMMENTS_ENABLED_IKIT_EVENT] = (isset($_POST[IKIT_THREE_THEME_OPTION_COMMENTS_ENABLED_IKIT_EVENT]) and $_POST[IKIT_THREE_THEME_OPTION_COMMENTS_ENABLED_IKIT_EVENT] == 'on' ? 1 : 0);
  $input[IKIT_THREE_THEME_OPTION_DEFAULT_CALENDAR_VIEW_EVENTS] = (isset($_POST[IKIT_THREE_THEME_OPTION_DEFAULT_CALENDAR_VIEW_EVENTS]) and $_POST[IKIT_THREE_THEME_OPTION_DEFAULT_CALENDAR_VIEW_EVENTS] == 'on' ? 1 : 0);
  $input[IKIT_THREE_THEME_OPTION_SINGLE_ENABLED_IKIT_PERSON] = (isset($_POST[IKIT_THREE_THEME_OPTION_SINGLE_ENABLED_IKIT_PERSON]) and $_POST[IKIT_THREE_THEME_OPTION_SINGLE_ENABLED_IKIT_PERSON] == 'on' ? 1 : 0);
  $input[IKIT_THREE_THEME_OPTION_IKIT_EVENTS_INTERNAL_SEPARATE_PAGE] = (isset($_POST[IKIT_THREE_THEME_OPTION_IKIT_EVENTS_INTERNAL_SEPARATE_PAGE]) and $_POST[IKIT_THREE_THEME_OPTION_IKIT_EVENTS_INTERNAL_SEPARATE_PAGE] == 'on' ? 1 : 0);
  $input[IKIT_THREE_THEME_OPTION_PERSONS_SINGLE_SMALL_HERO_IMAGE_ENABLED] = (isset($_POST[IKIT_THREE_THEME_OPTION_PERSONS_SINGLE_SMALL_HERO_IMAGE_ENABLED]) and $_POST[IKIT_THREE_THEME_OPTION_PERSONS_SINGLE_SMALL_HERO_IMAGE_ENABLED] == 'on' ? 1 : 0);
  $input[IKIT_THREE_THEME_OPTION_SINGLE_ENABLED_IKIT_SPONSOR] = (isset($_POST[IKIT_THREE_THEME_OPTION_SINGLE_ENABLED_IKIT_SPONSOR]) and $_POST[IKIT_THREE_THEME_OPTION_SINGLE_ENABLED_IKIT_SPONSOR] == 'on' ? 1 : 0);
  $input[IKIT_THREE_THEME_OPTION_FOOTER_HIDE_LOCAL_SPONSORS] = (isset($_POST[IKIT_THREE_THEME_OPTION_FOOTER_HIDE_LOCAL_SPONSORS]) and $_POST[IKIT_THREE_THEME_OPTION_FOOTER_HIDE_LOCAL_SPONSORS] == 'on' ? 1 : 0);
  $input[IKIT_THREE_THEME_OPTION_EVENTS_HIDE_FEED] = (isset($_POST[IKIT_THREE_THEME_OPTION_EVENTS_HIDE_FEED]) and $_POST[IKIT_THREE_THEME_OPTION_EVENTS_HIDE_FEED] == 'on' ? 1 : 0);
  $input[IKIT_THREE_THEME_OPTION_NEWS_SINGLE_SMALL_HERO_IMAGE_ENABLED] = (isset($_POST[IKIT_THREE_THEME_OPTION_NEWS_SINGLE_SMALL_HERO_IMAGE_ENABLED]) and $_POST[IKIT_THREE_THEME_OPTION_NEWS_SINGLE_SMALL_HERO_IMAGE_ENABLED] == 'on' ? 1 : 0);
  $input[IKIT_THREE_THEME_OPTION_EVENTS_SINGLE_SMALL_HERO_IMAGE_ENABLED] = (isset($_POST[IKIT_THREE_THEME_OPTION_EVENTS_SINGLE_SMALL_HERO_IMAGE_ENABLED]) and $_POST[IKIT_THREE_THEME_OPTION_EVENTS_SINGLE_SMALL_HERO_IMAGE_ENABLED] == 'on' ? 1 : 0);
  $input[IKIT_THREE_THEME_OPTION_HEADER_LOCK_COLLAPSED_ENABLED] = (isset($_POST[IKIT_THREE_THEME_OPTION_HEADER_LOCK_COLLAPSED_ENABLED]) and $_POST[IKIT_THREE_THEME_OPTION_HEADER_LOCK_COLLAPSED_ENABLED] == 'on' ? 1 : 0);

  return $input;

}

?>
