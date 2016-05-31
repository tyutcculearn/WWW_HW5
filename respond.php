<?php 
	$query = "select respond.*,user.Name from respond left join user on respond.user_id = user.id where article_id = '".$_POST['article_id']."' order by respond.timestamp desc";
	$database = mysql_connect("localhost:3306","root","123456");
	mysql_select_db("hw3",$database);
	$result = mysql_query($query);
	mysql_close($database);
	$ans = "";
	$data;
	while ($row = mysql_fetch_array($result)) {
		$data[] = $row;
	}
	echo json_encode($data);
?>