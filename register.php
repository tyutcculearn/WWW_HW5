<?php 
	session_start();
	extract($_POST);
	$error = "";
	if(isset($Name) && $Name && isset($Email) && $Email && isset($Password) && $Password && isset($Cpassword) && $Cpassword)
	{
		if(!get_magic_quotes_gpc())
		{
			$Name = addslashes($Name);
		    $Email = addslashes($Email);
		    $Password = addslashes($Password);
		}
		$query = "select * from user where Email='".$Email."'";
		$database = mysql_connect("localhost:3306","root","123456");
		mysql_select_db("hw3",$database);
		$result = mysql_query($query);
		if($row = mysql_fetch_array($result))
			$error = "Warning! 此帐号已被注册";
		else
		{
			if($Password != $Cpassword)
				$error = "Warning! 密码和确认密码不同";
			else
			{
				$insert = "insert into user (Name,Email,Password) values('".$Name."','".$Email."','".$Password."')";
				mysql_query($insert);
				$query = "select * from user where Email = '".$Email."'";
				$result = mysql_query($query);
				$row = mysql_fetch_array($result);
				$_SESSION['id'] = $row['id'];
				$_SESSION['Name'] = $row['Name'];
				$_SESSION['Email'] = $row['Email'];
				mysql_close($database);
				echo $error;
				return;
			}
		}
		mysql_close($database);
	}
	else
	{
		$error = "Warning! 请确保填写所有栏位";
	}
	echo $error;
?>