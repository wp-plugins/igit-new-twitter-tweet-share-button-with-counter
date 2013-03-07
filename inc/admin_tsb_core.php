<?php
function igit_tsb_plugin_menu()
{
    add_options_page('IGIT Tweet Share Button', 'IGIT Tweet Share Button', 'administrator', 'igit-tweet-share-button', 'igit_tsb_admin_options');
}

function igit_tsb_action_javascript()
{
?>
<script type="text/javascript" >
jQuery(document).ready(function ($) {
    jQuery('#options_form_tsb').submit(function () {
	
		var i = parseInt(0);
	
		aut_tsb_show = jQuery('#auto_tsb_show:checked').val();
		coun_tsb = jQuery('#count_tsb').attr('value');
        vi_tsb = jQuery('#via_tsb').attr('value');
        ts_width = jQuery('#tsb_width').attr('value');
        ts_height = jQuery('#tsb_height').attr('value');
		igit_tsb_plac = jQuery('#igit_tsb_placing').attr('value');
		igit_tsb_cont_sty = jQuery('#igit_tsb_cont_style').attr('value');
        igit_ts_cre = jQuery('#igit_tsb_credit:checked').val();
        jQuery('#loading_img').show();
		
        var data = {
            action: 'igit_tsb_save_ajax',
			auto_tsb_show: aut_tsb_show,
			count_tsb: coun_tsb,
            via_tsb: vi_tsb,
            tsb_width: ts_width,
            tsb_height: ts_height,
            igit_tsb_placing: igit_tsb_plac,
            igit_tsb_credit: igit_ts_cre,
            igit_tsb_cont_style: igit_tsb_cont_sty
        };
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php igit_tsb_cont_style
        jQuery.post(ajaxurl, data, function (response) {
		
			
            jQuery('#loading_img').fadeOut(300,function(){
				 jQuery('#igit_div_success').fadeIn(1000,function(){  jQuery('#igit_div_success').fadeOut(2000); });
			 });
			
            $("#tsb_frm_fields").html(response);
			
        });
        return false;
    });
});
</script>
<?php

}
function igit_tsb_head() {
	echo '<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>';
}
function igit_tsb_action_callback()
{
    global $wpdb; // this is how you get access to the database
    global $igit_tsb;


	$auto_tsb_show   = ($_POST['auto_tsb_show'] == "") ? 2 : $_POST['auto_tsb_show'];
	$count_tsb   = ($_POST['count_tsb'] == "") ? $igit_tsb['count_tsb'] : $_POST['count_tsb'];
	
    $via_tsb   = ($_POST['via_tsb'] == "") ? $igit_tsb['via_tsb'] : $_POST['via_tsb'];
    $tsb_width        = ($_POST['tsb_width'] == "") ? $igit_tsb['tsb_width'] : $_POST['tsb_width'];
    $tsb_height       = ($_POST['tsb_height'] == "") ? $igit_tsb['tsb_height'] : $_POST['tsb_height'];
    $igit_tsb_credit        = ($_POST['igit_tsb_credit'] == "") ? 2 : $_POST['igit_tsb_credit'];
	$igit_tsb_placing        = ($_POST['igit_tsb_placing'] == "") ? 'before' : $_POST['igit_tsb_placing'];
	$igit_tsb_cont_style        = ($_POST['igit_tsb_cont_style'] == "") ? '' : $_POST['igit_tsb_cont_style'];

    $igit_tsb          = array(
		"auto_tsb_show" => $auto_tsb_show,
		"count_tsb" => $count_tsb,
        "via_tsb" => $via_tsb,
        "tsb_width" => $tsb_width,
        "tsb_height" => $tsb_height,
        "igit_tsb_credit" => $igit_tsb_credit,
        "igit_tsb_placing" => $igit_tsb_placing,
        "igit_tsb_cont_style" => $igit_tsb_cont_style
        );
	
    update_option('igit_tsb', $igit_tsb);
    $igit_tsb    = get_option('igit_tsb');
	
    $result       = $result . '<div class="updated fade below-h2" id="message"><p>Options updated.</p></div><table class="form-table">
			<tbody>';
			$auto_chckd_ajax = ($igit_tsb['auto_tsb_show'] == "1") ? "checked=checked" : "";
	 $result       = $result . '<tr valign="top">
				<th scope="row"><label for="blogname">Show Twitter Share Button :<strong>(Tick If Yes)</strong></label></th>
					<td style="vertical-align:middle;"><input type="checkbox" id="auto_tsb_show" name="auto_tsb_show" value="1" ' . $auto_chckd_ajax . '/>&nbsp;&nbsp;<strong>(Untick it If you want to disable tweet button.)</strong></td>
					
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Place Tweet Button:</label></th>
					<td>';
					$chk1         = igit_checked_tsb_position('before', $igit_tsb['igit_tsb_placing']);
					$chk2         = igit_checked_tsb_position('after', $igit_tsb['igit_tsb_placing']);
					$chk3         = igit_checked_tsb_position('beforeandafter', $igit_tsb['igit_tsb_placing']);
					$chk4         = igit_checked_tsb_position('manual', $igit_tsb['igit_tsb_placing']);
					$result       = $result . '<select name="igit_tsb_placing" style="padding:4px 5px;font-size: 13px;" id="igit_tsb_placing">
						<option value="before" ' . $chk1 . '>Before</option>
						<option  value="after" ' . $chk2 . '>After</option>
						<option value="beforeandafter" ' . $chk3 . '>Before and After</option>
						<option  value="manual" ' . $chk4 . '>Manual</option>
					</select></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Manually Placing of Related Posts :</label></th>
					<td><code>&lt;?php if(function_exists(&#39;igit_tsb_button&#39;)) igit_tsb_button(); ?&gt;</code></td>
				</tr>
				<th scope="row"><label for="blogname">Type :</label></th>
					<td><input type="text" class="code" value="' . $igit_tsb['count_tsb'] . '" id="count_tsb" name="count_tsb" maxlength="100" size="30"/>&nbsp;
					<code>none, horizontal, vertical</code></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Tweet Btn Container Style :</label></th>
					<td><input type="text" class="code" value="' . $igit_tsb['igit_tsb_cont_style'] . '" id="igit_tsb_cont_style" name="igit_tsb_cont_style" maxlength="100" size="30"/>&nbsp;
					<code>float: left; margin-right: 10px;</code></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Via :</label></th>
					<td><input type="text" class="code" value="' . $igit_tsb['via_tsb'] . '" id="via_tsb" name="via_tsb" maxlength="100" size="30"/></td>
				</tr>
				<tr valign="top">
				
				';
  
  
  
  
    $chckd_credit = ($igit_tsb['igit_tsb_credit'] == "1") ? "checked=checked" : "";
    $result       = $result . '
				
				<tr valign="top">
				<th scope="row"><label for="blogname">Donate Us :</label></th>
					<td>To donate send me donation on Paypal - kinjugandhi@yahoo.com. Thanks.</td>
				</tr>
				<tr valign="top">
				<th scope="row" colspan="2"></td>
				</tr>
			</tbody>
		</table>
		';
    echo $result;
	
//	echo $result1;
    die();
}
function igit_checked_tsb_position($value, $rel_style)
{
    $res_val = ($value == $rel_style) ? "selected='selected'" : "";
    return $res_val;
}
function igit_tsb_admin_options()
{
    global $igit_tsb, $plgin_dir;
    if ($_POST['sb_submit']) {
	
	
	
        $igit_tsb = array(
			
			"auto_tsb_show" => $_POST['auto_tsb_show'],
			"count_tsb" => $_POST['count_tsb'],
            "via_tsb" => $_POST['via_tsb'],
            "tsb_width" => $_POST['tsb_width'],
            "tsb_height" => $_POST['tsb_height'],
            "igit_tsb_credit" => $_POST['igit_tsb_credit'],
            "igit_tsb_placing" => $_POST['igit_tsb_placing'],
            "igit_tsb_cont_style" => $_POST['igit_tsb_cont_style']
           
        );
        update_option('igit_tsb', $igit_tsb);
        $message_succ = '<div id="message" class="updated fade"><p>Option Saved!</p></div>';
    } else {
        $message_succ       = "";
        $igit_tsb_new      = get_option('igit_tsb');
		
		$auto_tsb_show   = ($igit_tsb_new['auto_tsb_show'] == "") ? $igit_tsb['auto_tsb_show'] : $igit_tsb_new['auto_tsb_show'];
		$count_tsb   = ($igit_tsb_new['count_tsb'] == "") ? $igit_tsb['count_tsb'] : $igit_tsb_new['count_tsb'];
        $via_tsb   = ($igit_tsb_new['via_tsb'] == "") ? $igit_tsb['via_tsb'] : $igit_tsb_new['via_tsb'];
        $tsb_width      = ($igit_tsb_new['tsb_width'] == "") ? $igit_tsb['tsb_width'] : $igit_tsb_new['tsb_width'];
        $tsb_height        = ($igit_tsb_new['tsb_height'] == "") ? $igit_tsb['tsb_height'] : $igit_tsb_new['tsb_height'];
        $igit_tsb_credit       = ($igit_tsb_new['igit_tsb_credit'] == "") ? $igit_tsb['igit_tsb_credit'] : $igit_tsb_new['igit_tsb_credit'];
		$igit_tsb_placing       = ($igit_tsb_new['igit_tsb_placing'] == "") ? $igit_tsb['igit_tsb_placing'] : $igit_tsb_new['igit_tsb_placing'];

$igit_tsb_cont_style       = ($igit_tsb_new['igit_tsb_cont_style'] == "") ? $igit_tsb['igit_tsb_cont_style'] : $igit_tsb_new['igit_tsb_cont_style'];     
		
		
		
		
        $igit_tsb          = array(
		"auto_tsb_show" => $auto_tsb_show,
		"count_tsb" => $count_tsb,
			"via_tsb" => $via_tsb,
            "tsb_width" => $tsb_width,
            "tsb_height" => $tsb_height,
            "igit_tsb_credit" => $igit_tsb_credit,
            "igit_tsb_placing" => $igit_tsb_placing,
            "igit_tsb_cont_style" => $igit_tsb_cont_style
        );
    }
	
    echo $message_succ . '<div class="wrap"><div id="icon-options-general" class="icon32"><br/></div>
	<div style="width: 70%; float: left;">
 	<form id="options_form_tsb" name="options_form_tsb" method="post" action="">
	<input type="hidden" id="hid_exl_cat" name="hid_exl_cat" value="">
		<h2>IGIT Tweet Share Button With Counter</h2> 
		<div style="padding-left: 10px;height: 22px;"><iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2FHackingEthics&amp;send=false&amp;layout=standard&amp;width=450&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;height=35&amp;appId=422733157774758" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:35px;" allowTransparency="true"></iframe></div>
		<div id="tsb_frm_fields">
		<table class="form-table">
			<tbody>';
			$auto_chckd = ($igit_tsb['auto_tsb_show'] == "1") ? "checked=checked" : "";
				 echo $message_succ . '<tr valign="top">
				<th scope="row"><label for="blogname">Show Twitter Share Button :<strong>(Tick If Yes)</strong></label></th>
					<td style="vertical-align:middle;"><input type="checkbox" id="auto_tsb_show" name="auto_tsb_show" value="1" ' . $auto_chckd . '/>&nbsp;&nbsp;<strong>(Untick it If you want to disable tweet button.)</strong> </td>
					
				</tr>
				
				
				<tr valign="top">
				<th scope="row"><label for="blogname">Place Tweet Button:</label></th>
					<td>';
					$chk1         = igit_checked_tsb_position('before', $igit_tsb['igit_tsb_placing']);
					$chk2         = igit_checked_tsb_position('after', $igit_tsb['igit_tsb_placing']);
					$chk3         = igit_checked_tsb_position('beforeandafter', $igit_tsb['igit_tsb_placing']);
					$chk4         = igit_checked_tsb_position('manual', $igit_tsb['igit_tsb_placing']);
					echo $message_succ . '<select name="igit_tsb_placing" style="padding:4px 5px;font-size: 13px;" id="igit_tsb_placing">
						<option value="before" ' . $chk1 . '>Before</option>
						<option  value="after" ' . $chk2 . '>After</option>
						<option value="beforeandafter" ' . $chk3 . '>Before and After</option>
						<option  value="manual" ' . $chk4 . '>Manual</option>
					</select></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Manually Placing code for Tweet Button :</label></th>
					<td><code>&lt;?php if(function_exists(&#39;igit_tsb_button&#39;)) igit_tsb_button(); ?&gt;</code></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Type :</label></th>
					<td><input type="text" class="code" value="' . $igit_tsb['count_tsb'] . '" id="count_tsb" name="count_tsb" maxlength="100" size="30"/>&nbsp;
					<code>none, horizontal, vertical</code></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Tweet Btn Container Style :</label></th>
					<td><input type="text" class="code" value="' . $igit_tsb['igit_tsb_cont_style'] . '" id="igit_tsb_cont_style" name="igit_tsb_cont_style" maxlength="100" size="30"/>&nbsp;
					<code>float: left; margin-right: 10px;</code></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Via :</label></th>
					<td><input type="text" class="code" value="' . $igit_tsb['via_tsb'] . '" id="via_tsb" name="via_tsb" maxlength="100" size="30"/></td>
				</tr>
                <tr valign="top">
				
				';
   $chckd_credit = ($igit_tsb['igit_tsb_credit'] == "1") ? "checked=checked" : "";
   
    echo $message_succ . '
				
				<tr valign="top">
				<th scope="row"><label for="blogname">Donate Us :</label></th>
					<td>To donate send me donation on Paypal - kinjugandhi@yahoo.com. Thanks.</td>
				</tr>
				<tr valign="top">
				<th scope="row" colspan="2"></td>
				</tr>
			</tbody>
		</table>
		</div>
		<div style="float:left;width:250px;" align="center"><input type="submit" name="sb_submit" id="sb_submit" value="Update Options" /></div>&nbsp;&nbsp;&nbsp;&nbsp;<div id="loading_img" style="float:left;width:60px;padding-top:9px;display:none;" align="center"><img src="' . WP_PLUGIN_URL . '/igit-new-twitter-tweet-share-button-with-counter/images/loader.gif"></div>&nbsp;&nbsp;&nbsp;&nbsp;<div class="flash igit_success" style="float:left;display:none;" id="igit_div_success">
   Options Saved.</div>
   <br>
   <br>
      <br>   <br>
	</form>
	</div>
	<div id="poststuff" class="metabox-holder has-right-sidebar" style="float: right; width: 24%;"> 
   <div id="side-info-column" class="inner-sidebar"> 
			<div class="postbox"> 
			  <h3 class="hndle"><span>Donate To Support Plugin:</span></h3> 
			  <div class="inside" align="center">
               To donate send me donation on Paypal - kinjugandhi@yahoo.com. Thanks.
              </div> 
			</div> 
  </div>
<div id="side-info-column" class="inner-sidebar"> 
			<div class="postbox"> 
			  <h3 class="hndle"><span>About Plugin:</span></h3> 
			  <div class="inside">
                <ul>
                <li><a href="http://www.hackingethics.com/blog/wordpress-plugins/igit-new-twitter-tweet-share-button-with-counter-wordpress-plugin/" title="IGIT Related Posts With Thumb Homepage">Plugin Homepage</a></li>
                <li><a href="http://www.hackingethics.com" title="Visit Hacking Ethics">Plugin Main Site</a></li>
                <li><a href="http://www.hackingethics.com/blog/wordpress-plugins/igit-new-twitter-tweet-share-button-with-counter-wordpress-plugin/" title="Post Comment to get support">Support For Plugin</a></li>
                <li><a href="http://www.hackingethics.com/blog/hire-php-developer-india-php-developer-india-php-freelancer-india-php-developer-ahmedabad/" title="Plugin Author Page">About the Author</a></li>
               
                </ul> 
              </div> 
			</div> 
  </div>
  <div class="inner-sidebar" id="side-info-column"> 
			<div class="postbox"> 
			  <h3 class="hndle"><span>Support &amp; Donations</span></h3> 
			  <div class="inside">
                <div id="smooth_sldr_donations">
                 <ul>
                    <li><a href="#">Jack Pablo - $20</a></li>
                   
                 </ul>
					
                   
                </div>
              </div> 
			</div> 
     </div>
 </div>
</div>';
}

function igit_tsb_button_placing($content)
{
	global $post,$igit_tsb;
	
	$igit_tsb_res = get_option('igit_tsb');
	if(!$igit_tsb_res)
	{
		$igit_tsb_res = $igit_tsb;
	}
	
	if (get_post_status($post->ID) == 'publish') {
		$url = get_permalink();
	}
	if($type)
	{
		$typebtn = $type;
	}
	else
	{
		$typebtn = $igit_tsb_res["count_tsb"];
	}
	
	$button = '<div class="igit_tsb_button" style="'.$igit_tsb_res['igit_tsb_cont_style'].'">';
	$button .= '<a href="http://twitter.com/share?url='.urlencode($url).'&amp;text='.urlencode($post->post_title).'&amp;count='.$typebtn.'&amp;via='.$igit_tsb_res["via_tsb"].'" style="" class="twitter-share-button">Tweet</a>';
	$button .= '</div>';
	
	
	if ($igit_tsb_res['igit_tsb_placing'] == 'beforeandafter') {
		return $button . $content . $button;
	} else if ($igit_tsb_res['igit_tsb_placing'] == 'before') {
		return $button . $content;
	} else if ($igit_tsb_res['igit_tsb_placing'] == 'after') {
		return $content . $button;
	} else {
		return $content;
	}
	
}
function igit_tsb_button($type='horizontal')
{
	global $post;
	if (get_post_status($post->ID) == 'publish') {
		$url = get_permalink();
	}
	if($type)
	{
		$typebtn = $type;
	}
	else
	{
		$typebtn = $igit_tsb_res["count_tsb"];
	}
	$igit_tsb_res = get_option('igit_tsb');
	if($igit_tsb_res['auto_tsb_show'] == "1")
	{
	$button = '<div class="igit_tsb_button" style="'.$igit_tsb_res['igit_tsb_cont_style'].'">';
	$button .= '<a href="http://twitter.com/share?url='.urlencode($url).'&amp;text='.urlencode($post->post_title).'&amp;count='.$typebtn.'&amp;via='.$igit_tsb_res["via_tsb"].'" style="" class="twitter-share-button">Tweet</a>';
	$button .= '</div>';
	echo $button;
	}
	
	
	
	
}
?>
