<?php
if(!isset($_POST))
{
	die("Aren't you supposed to come here via WP-Admin?");
}





global $wpdb; // this is how you get access to the database


update_option('igit_rpwt',$_POST);


print_r(get_option('igit_rpwt'));










/*echo $message_succ.'<div id="icon-options-general" class="icon32"><br/></div>
 	<form id="options_form" method="post" action="'.WP_PLUGIN_URL.'/igit-rpwt/inc/igit_ajax_save.php">
		<h2>IGIT Follow Me button after every post</h2> 
		<table class="form-table">
			<tbody>
				<tr valign="top">
				<th scope="row"><label for="blogname">How Many Related Posts Want to Show?</label></th>
					<td><input type="text" class="code" value="'.$igit_rpwt['related_post_num'].'" id="related_post_num" name="related_post_num" maxlength="2" size="4"/></td>
				</tr>';
				$chckd = ( $igit_rpwt['display_thumb'] == "1" ) ? "checked=checked" : "";
				//echo $text; 
				echo $message_succ.'<tr valign="top">
				<th scope="row"><label for="blogname">Display Thumb?</label></th>
					<td><input type="checkbox" id="display_thumb" name="display_thumb" value="1" '.$chckd.'/></td>
				</tr>
                <tr valign="top">
				<th scope="row"><label for="blogname">Thumb Width :</label></th>
					<td><input type="text" class="regular-text code" value="'.$igit_rpwt['thumb_width'].'" id="thumb_width" name="thumb_width" />&nbsp;(In Pixels(px))</td>
				</tr>
                <tr valign="top">
				<th scope="row"><label for="blogname">Thumb Height :</label></th>
					<td><input type="text" class="regular-text code" value="'.$igit_rpwt['thumb_height'].'" id="thumb_height" name="thumb_height"/>&nbsp;(In Pixels(px))</td>
				</tr>';
				
				$chk1 = igit_checked_post_style(1,$igit_rpwt['related_post_style']);
				
				
				echo $message_succ.'<tr valign="top">
				<th scope="row"><label for="blogname">Related Posts Style</label></th>
					<td><label>
	<input type="radio"  id="format_output_1" value="1" name="related_post_style" '.$chk1.'>
	Related Post in Horizontal Format</label>
	<br>
	<label>';
			$chk2 = igit_checked_post_style(2,$igit_rpwt['rel_post_style']);
	echo $message_succ.'<input type="radio" id="format_output_2" value="2" name="related_post_style" '.$chk2.'>
	Related Post in Verticle Format</label>
	<br>
	<label>';
			$chk3 = igit_checked_post_style(3,$igit_rpwt['rel_post_style']);
	echo $message_succ.'<input type="radio" id="format_output_3" value="3" name="related_post_style" '.$chk3.'>
		Related Post in Raw Format (<code>&lt;ul&gt; &lt;li&gt;</code>)</label>
		<br></td>
				</tr>
				<tr valign="top">
				<th scope="row" colspan="2"><input type="button" name="b_submit" id="b_submit" value="button" /><input type="submit" name="sb_submit" id="sb_submit" value="Update Options" /></td>
				</tr>
			</tbody>
		</table>
		
	</form>
';*/

?>