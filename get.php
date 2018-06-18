<?php
/* get.php 
 * Code by HTTZIP
 * Share on httzip.com
*/
$token = "PAGE Token";
$post_id = "POST ID";
require 'class.check.php';
$check = new Check();
if(!empty($_GET['action']=="get"))
{
	$check->_token = $token;
	$check->_post_id  = $post_id;
	$check->_link = "https://graph.facebook.com/".$post_id."/comments?fields=from&filter=stream&order=reverse_chronological&access_token=".$token."&limit=50&pretty=1";

	$check->check();
}
else
{
	echo "WTF?";
}