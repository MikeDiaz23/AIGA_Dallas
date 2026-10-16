<?php
/**
 * Template Name: Single Job
 */

// If returning from SSO, display the job, otherwise forward to SSO for login
if ( have_posts() ) while ( have_posts() ) : the_post();

global $id;

$sso_key = ikit_sso_get_redirect_token();
if(empty($sso_key)) {
  wp_redirect(ikit_sso_get_login_url(get_permalink(), IKIT_SSO_REDIRECT_SOURCE_LOCK));
  exit;
}

endwhile;

?>
<?php get_header();?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post();
    global $id;

    $ikit_job_meta = ikit_job_get_meta($id);
    ?>

    <div class="page-header-4">
        <div class="page-header-4-title-container">
            <div class="page-header-4-title">
                <?php the_title(); ?>
            </div>
        </div>
    </div>

    <table class="page-layout-4">
    <tr>

        <td class="page-layout-4-tools">

        </td>

        <td class="page-layout-4-content">

            <table>
            <tr>
            <td class="page-layout-4-body">
                <div class="page-layout-4-body-paragraph-text wp-editor">

                    <?php if(empty($ikit_job_meta->description) == false) { ?>
                        <div><?php echo wpautop($ikit_job_meta->description); ?></div>
                    <?php } ?>

                    <?php if(empty($ikit_job_meta->other_skills) == false) { ?>
                        <div class="editor-header21">Other Skills</div>
                        <div><?php echo wpautop($ikit_job_meta->other_skills); ?></div>
                    <?php } ?>

                    <?php if(empty($ikit_job_meta->submission_details) == false) { ?>
                        <div class="editor-header21">Submission Details</div>
                        <div><?php echo wpautop($ikit_job_meta->submission_details); ?></div>
                    <?php } ?>

                </div>
            </td>
            <td class="page-layout-4-attributes">

                <div class="page-layout-4-attributes-inner">

                    <?php if(empty($ikit_job_meta->company_name) == false) { ?>
                            <div class="page-layout-4-attribute">
                                <div class="page-layout-4-attribute-header">Company</div>
                                <div class="page-layout-4-attribute-text"><?php echo $ikit_job_meta->company_name; ?></div>
                            </div>
                    <?php } ?>

                    <?php if(empty($ikit_job_meta->city) == false) { ?>
                            <div class="page-layout-4-attribute">
                                <div class="page-layout-4-attribute-header">Location</div>
                                <div class="page-layout-4-attribute-text"><?php echo $ikit_job_meta->city . ', ' . $ikit_job_meta->state . ', ' .  $ikit_job_meta->country; ?></div>
                            </div>
                    <?php } ?>

                    <?php if(empty($ikit_job_meta->job_level) == false) { ?>
                            <div class="page-layout-4-attribute">
                                <div class="page-layout-4-attribute-header">Job level</div>
                                <div class="page-layout-4-attribute-text"><?php echo $ikit_job_meta->job_level; ?></div>
                            </div>
                    <?php } ?>

                    <?php if(empty($ikit_job_meta->expertise_area) == false) { ?>
                            <div class="page-layout-4-attribute">
                                <div class="page-layout-4-attribute-header">Field</div>
                                <div class="page-layout-4-attribute-text"><?php echo $ikit_job_meta->expertise_area; ?></div>
                            </div>
                    <?php } ?>

                    <?php if(empty($ikit_job_meta->job_functions) == false) { ?>
                            <div class="page-layout-4-attribute">
                                <div class="page-layout-4-attribute-header">Job functions</div>
                                <div class="page-layout-4-attribute-text"><?php echo $ikit_job_meta->job_functions; ?></div>
                            </div>
                    <?php } ?>

                    <?php if(empty($ikit_job_meta->date_approved) == false) { ?>
                            <div class="page-layout-4-attribute">
                                <div class="page-layout-4-attribute-header">Published</div>
                                <div class="page-layout-4-attribute-text"><?php echo mysql2date('F j, Y', get_gmt_from_date($ikit_job_meta->date_approved), false);?></div>
                            </div>
                    <?php } ?>

                    <?php if(empty($ikit_job_meta->application_url) == false) { ?>

                        <div class="page-layout-4-attribute">
                            <div class="page-layout-4-attribute-actions">
                                <a target="_blank" class="box-button apply-button" href="<?php echo $ikit_job_meta->application_url; ?>">Apply</a>
                            </div>
                        </div>

                    <?php } else { ?>

                        <div class="page-layout-4-attribute">
                            <div class="page-layout-4-attribute-actions">
                                <a class="box-button apply-button" href="mailto:<?php echo $ikit_job_meta->apply_online_email; ?>">Apply</a>
                            </div>
                        </div>

                    <?php } ?>

                </div>

            </td>
            </tr>
            </table>

        </td>

    </tr>
    </table>

    <?php
endwhile;?>

<?php get_footer();?>
