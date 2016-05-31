<?php 
	if(!isset($_POST['article_id']) && isset($_POST['id']))
	{
		$query = "select user.Name,article.*,count(respond.id) as num from article inner join user on article.author_id = user.id left join respond on respond.article_id = article.id where user.id = '".$_POST['id']."'group by article.id order by article.last_update desc limit 5";
		$database = mysql_connect("localhost:3306","root","123456");
		mysql_select_db("hw3",$database);
		$result = mysql_query($query);
		$data;
		while($row = mysql_fetch_array($result))
			$data[] = $row;
		mysql_close($database);
		echo json_encode($data);
	}
	else if(!isset($_POST['article_id']) && !isset($_POST['id']))
	{
		$query = "select user.Name,article.*,count(respond.id) as num from article inner join user on article.author_id = user.id left join respond on respond.article_id = article.id group by article.id order by article.last_update desc";
		$database = mysql_connect("localhost:3306","root","123456");
		mysql_select_db("hw3",$database);
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result))
			$data[] = $row;
		mysql_close($database);
		echo json_encode($data);
	}
	else if(isset($_POST['article_id']))
	{
		$query = "select article.*,user.Name from article,user where user.id = article.author_id and article.id = '".$_POST['article_id']."'";
		$database = mysql_connect("localhost:3306","root","123456");
		mysql_select_db("hw3",$database);
		$result = mysql_query($query);
		mysql_close($database);
		$row = mysql_fetch_array($result);
		echo json_encode($row);
	}
?>