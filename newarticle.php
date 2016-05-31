<?php 
	extract($_POST);
	date_default_timezone_set("Asia/Shanghai");
	$date = date("Y-m-d H:i:s",time());
	if(!isset($article_id))
	{
		$insert = "insert into article (author_id,title,content,created_time,last_update) values('".$id."','".$title."','".$content1."','".$date."','".$date."')";
		$database = mysql_connect("localhost:3306","root","123456");
		mysql_select_db("hw3",$database);
		mysql_query($insert);
		mysql_close($database);
	}
	else
	{
		$update = "update article set title='".$title."', content='".$content."',last_update='".$date."' where id='".$article_id."'";
		$database = mysql_connect("localhost:3306","root","123456");
		mysql_select_db("hw3",$database);
		mysql_query($update);
		mysql_close($database);
	}
	echo "OK";
?>