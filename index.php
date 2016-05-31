<?php
	session_start();
	if(!isset($_SESSION['id']))
		echo "<script>location.href=\"./login.php\"</script>";

?>
<!DOCTYPE html>
<html>
<head>
	<title>Index</title>
	<!-- 新 Bootstrap 核心 CSS 文件 -->
	<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
	<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>

	<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
	<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="./index.js"></script>
</head>
<body>
	<div class="container">
		<div class="row" style="background-color: #272727;">
			<div class="col-md-2 col-md-offset-0">
				<h4 style="color:#00e3e3;">Geek Forum</h4>
			</div>
			<div class="col-md-2 col-md-offset-8">
				<ul class="nav nav-pills">
				  <li class="navli" role="presentation"><a href="./index.php" style="color: #00e3e3;">Home</a></li>
				  <li class="navli" role="presentation"><a href="./login.php?clear=1" style="color: #00e3e3;">Logout</a></li>
				</ul>
			</div>
		</div>
		<?php echo "<input type=\"hidden\" id=\"uid\" value=\"".$_SESSION['id']."\">"; ?>
		<div class="row" style="margin-top: 1%">
			<div class="col-md-12"><h4>Welcome back,<?php echo $_SESSION['Name'] ?></h4></div>
		</div>
		<?php 
			if(!isset($_GET['article_id']))
			{
				echo "<input type=\"hidden\" id = \"article_id\">
					  <div class=\"row\" style=\"margin-top: 1%\">
						<div class=\"col-md-offset-11\">
							<button type=\"button\" id=\"new\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\".bs-example-modal-lg\">
								创建新主题
							</button>
					  	</div>
					  </div>";
				$query = "select user.Name,article.*,count(respond.id) as num from article inner join user on article.author_id = user.id left join respond on respond.article_id = article.id where user.id = '".$_SESSION['id']."'group by article.id order by article.last_update desc limit 5";
				$database = mysql_connect("localhost:3306","root","123456");
				mysql_select_db("hw3",$database);
				$result = mysql_query($query);
				echo "<div class=\"row\">
						 <div class=\" col-md-12\"><h3 style=\"color:#009393;\">您近期更新/被留言的文章</h3></div>
						 <div class=\"col-md-12\">
						 	<table id=\"userarticle\" class=\"table table-striped\">
						 		<tr>
						 			<td>发表日期</td>
						 			<td>Author</td>
						 			<td>Title</td>
						 			<td>回复</td>
						 			<td>最后更新时间/回复</td>
						 		</tr>";
						while($row = mysql_fetch_array($result))
						{
						echo "<tr>
								<td>".$row['created_time']."</td>
								<td>".$row['Name']."</td>
								<td><a href=\"./index.php?article_id=".$row['id']."\">".$row['title']."</a></td>
								<td>".$row['num']."</td>
								<td>".$row['last_update']."</td>
							  </tr>";
						}
				echo        "</table>
						 </div>
					  </div>";
			    mysql_close($database);

				$query = "select user.Name,article.*,count(respond.id) as num from article inner join user on article.author_id = user.id left join respond on respond.article_id = article.id group by article.id order by article.last_update desc";
				$database = mysql_connect("localhost:3306","root","123456");
				mysql_select_db("hw3",$database);
				$result = mysql_query($query);
				echo "<div class=\"row\">
						 <div class=\" col-md-12\"><h3 style=\"color:#009393;\">所有文章列表</h3></div>
						 <div class=\"col-md-12\">
						 	<table id=\"otherarticle\" class=\"table table-striped\">
						 		<tr>
						 			<td>发表日期</td>
						 			<td>Author</td>
						 			<td>Title</td>
						 			<td>回复</td>
						 			<td>最后更新时间/回复</td>
						 		</tr>";
						while($row = mysql_fetch_array($result))
						{
						echo "<tr>
								<td>".$row['created_time']."</td>
								<td>".$row['Name']."</td>
								<td><a href=\"./index.php?article_id=".$row['id']."\">".$row['title']."</a></td>
								<td>".$row['num']."</td>
								<td>".$row['last_update']."</td>
							  </tr>";
						}
				echo        "</table>
						 </div>
					  </div>";
				mysql_close($database);
			}
			else
			{
				$_GET['article_id'] = (int)$_GET['article_id'];
				if($_GET['article_id'] < 0)
					echo "<script>window.location.href=\"./index.php\"</script>";
				else
				{
					if(!isset($_GET['delete']))
					{
						$query = "select article.*,user.Name from article,user where user.id = article.author_id and article.id = '".$_GET['article_id']."'";
						$database = mysql_connect("localhost:3306","root","123456");
						mysql_select_db("hw3",$database);
						$result = mysql_query($query);
						mysql_close($database);
						$row = mysql_fetch_array($result);
						echo "<div class=\"row\">
								<div class=\"col-md-12\"><h1 id = \"article_title\" style=\"color:#009393;\">".$row['title'].
								"</h1></div>
								<div class=\"col-md-4\"><p id = \"article_update\">".$row['Name']." Updated On ".$row['last_update'].
								"</p></div>";
						if($_SESSION['id'] == $row['author_id'])
						{	
							echo"<div class=\"col-md-offset-10\">
								  <input type=\"hidden\" id=\"article_id\" value =".$row['id'].">
								  <button type=\"button\" id=\"edit\" class=\"btn btn-success\" data-toggle=\"modal\" data-target=\".bs-example-modal-lg\">Edit</button>
								  <button type=\"button\" class=\"btn btn-danger\"><a href=\"./index.php?article_id=".$row['id']."&delete=1\" style=\"color:white;text-decoration: none;\">Delete</a></button>
								</div>";
						}
						echo "</div>";
						$row['content'] = str_replace("<R>","<span style=\"color:red;\">",$row['content']);
				    	$row['content'] = str_replace("</R>","</span>",$row['content']);
				    	$row['content'] = str_replace("<B>","<span style=\"color:blue;\">",$row['content']);
				    	$row['content'] = str_replace("</B>","</span>",$row['content']);
				    	$row['content'] = str_replace("<G>","<span style=\"color:green;\">",$row['content']);
				    	$row['content'] = str_replace("</G>","</span>",$row['content']);
				    	$row['content'] = str_replace("<YOUTUBE>","<iframe src=\"",$row['content']);
				    	$row['content'] = str_replace("watch?v=","v/",$row['content']);
				    	$row['content'] = str_replace("</YOUTUBE>","\" width=\"550\" height=\"550\" frameborder=\"0\" allowfullscreen></iframe>",$row['content']);
				    	$row['content'] = str_replace("\n","<br>",$row['content']);
						echo "<div class=\"row\">
								<div class=\"col-md-12\" id = \"article_content\">".$row['content']."</div>
							  </div>";
						$query = "select respond.*,user.Name from respond left join user on respond.user_id = user.id where article_id = '".$_GET['article_id']."' order by respond.timestamp desc";
						$database = mysql_connect("localhost:3306","root","123456");
						mysql_select_db("hw3",$database);
						$result = mysql_query($query);
						mysql_close($database);
						echo "<div class=\"row\">
								<div class=\"col-md-12\"><h4>Respond</h4></div>
								<div class=\"col-md-12\">
									<form class=\"form-inline\" id=\"respondform\">
									  <div class=\"form-group\">
									    <label for=\"exampleInputName2\">".$_SESSION['Name']."</label>
									    <input type=\"text\" class=\"form-control\" id=\"message\" name=\"message\" placeholder=\"Give a comment to this article.\"\>
									    <input type=\"hidden\" name=\"article_id\" value=\"".$row['id']."\">
									    <input type=\"hidden\" name=\"respond\" value=\"1\">
									    <input type=\"hidden\" name=\"id\" value=\"".$_SESSION['id']."\">
									  </div>
									  <button type=\"button\" id=\"respond\" class=\"btn btn-primary\">Submit</button>
									</form>
								</div>";
						echo "</div>
							  <div class=\"row\" style=\"margin-top:1%;\"><div class=\"col-md-12\"><table id=\"respondlist\" class=\"table table-striped\">";
						while ($row = mysql_fetch_array($result)) {
						echo "<tr>
								<td>".$row['Name']."</td>
								<td>".$row['message']."</td>
								<td>".$row['timestamp']."</td></tr>";
						}
						echo "</table></div></div>";

					}
					else if(isset($_GET['delete']))
					{
						$query = "select * from article where id = '".$_GET['article_id']."'";
						$database = mysql_connect("localhost:3306","root","123456");
						mysql_select_db("hw3",$database);
						$result = mysql_query($query);
						$row = mysql_fetch_array($result);
						if($row['author_id'] != $_SESSION['id'])
						{
							mysql_close($database);
							echo "<script>window.location.href=\"./index.php\"</script>";
						}
						$dele = "delete from respond where article_id = '".$_GET['article_id']."'";
						mysql_query($dele);
						$dele = "delete from article where id = '".$_GET['article_id']."'";
						mysql_query($dele);
						mysql_close($database);
						echo "<script>alert('删除成功');window.location.href=\"./index.php\"</script>";
					}
				}
			}

		?>
		<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
			  <div class="modal-dialog modal-lg" style="background-color: white;">
			    <div class="row">
					<div class="col-md-offset-0 col-md-12">
						<H1><p id="biaoti" class="text-center"></p></H1>
					</div>
					<div class="col-md-offset-1 col-md-10" style="margin-bottom: 2%;">
						<form id="newform">
						  <div class="form-group">
						    <label for="exampleInputPassword1">标题</label>
						    <input id="title" type="input" class="form-control" name="title" placeholder="title">
						  </div>
						  <div class="form-group">
						  	<label for="exampleInputEmail1">内容</label>
						  	<button type="button" id="code" class="btn btn-default">Code</button>
						  	<button type="button" id="html" class="btn btn-default">HTML</button>
						  	<button type="button" id="youtube" class="btn btn-default"><span class="glyphicon glyphicon-facetime-video" aria-hidden="true"></span></button>
						  	<button type="button" id="bold" class="btn btn-default"><span class="glyphicon glyphicon-bold" aria-hidden="true"></span></button>
						  	<button type="button" id="italic" class="btn btn-default"><span class="glyphicon glyphicon-italic" aria-hidden="true"></span></button>
						  	<button type="button" id="red" class="btn btn-danger"><span class="glyphicon glyphicon-font" aria-hidden="true"></span></button>
						  	<button type="button" id="blue" class="btn btn-primary"><span class="glyphicon glyphicon-font" aria-hidden="true"></span></button>
						  	<button type="button" id="green" class="btn btn-success"><span class="glyphicon glyphicon-font" aria-hidden="true"></span></button>
						    <div id="video" class="col-md-offset-0 col-md-12" style="margin-top: 2%; display: none;">
						    	<div class="col-md-offset-0 col-md-3">
						    		<h4>嵌入<R>youtube影片</R></h4>
						    	</div>
						    	<div class="col-md-offset-0 col-md-8">
						    		<input id="URL" type="input" class="form-control" name="URL" placeholder="https://www.youtube.com/watch?v=" style="margin-bottom: 2%;">
						    	</div>
						    	<div class="col-md-offset-0 col-md-1">
						    		<button type="button" id="insert" class="btn btn-default">Insert</button>
						    	</div>
						    </div>
						    <textarea class="form-control" id="content1" name="content1" placeholder="Content" rows="10" style="margin-top: 2%; margin-bottom: 2%"></textarea>
						    <div id="content2" name="content2" style="margin-top: 2%; margin-bottom: 2%"></div>
						  <?php echo "<input type=\"hidden\" name=\"id\" value=\"".$_SESSION['id']."\"\>";?>
						  <button type="reset" class="btn btn-default">Cancel</button>
						  <button type="button" id="newarticle" class="btn btn-success">Submit</button>
						</form>
					</div>
				</div>
			  </div>
		</div>
	</div>
</body>
</html>