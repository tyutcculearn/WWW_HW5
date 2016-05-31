<?php 
	if(!get_magic_quotes_gpc())
	{
		$_POST['message'] = addslashes($_POST['message']);
	}
	date_default_timezone_set("Asia/Shanghai");
	$date = date("Y-m-d H:i:s",time());
	$insert = "insert into respond (article_id,user_id,message,timestamp) values('".$_POST['article_id']."','".$_POST['id']."','".$_POST['message']."','".$date."')";
	$database = mysql_connect("localhost:3306","root","123456");
	mysql_select_db("hw3",$database);
	mysql_query($insert);
	$update = "update article set last_update='".$date."' where id='".$_POST['article_id']."'";
	mysql_query($update);
	mysql_close($database);
	echo "OK";
?>