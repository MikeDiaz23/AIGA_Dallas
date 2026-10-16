<?php
/**
 * The template for displaying search forms in Twenty Eleven
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>
<form method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
    <table>
    <tr>
    <td>
        <input type="text" name="s" id="s" class="s" placeholder="Search" />
        <!-- For 508 compliance -->
        <label style="display:none" for="s">Search</label>
    </td>
    </tr>
    </table>
</form>
