<?php
if(!isset($_POST))
{
	die("Aren't you supposed to come here via WP-Admin?");
}
global $wpdb; // this is how you get access to the database
update_option('igit_rpwt',$_POST);
print_r(get_option('igit_rpwt'));
?>