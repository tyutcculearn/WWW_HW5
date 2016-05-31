$(document).ready(function(){
	$("#register").click(function(){
		var d = $("#registerform").serializeArray();
		$.post("./register.php",d,function(data){
			if(data == "")
			{
				alert("注册成功");
				window.location.href="./index.php";
			}
			else
			{
				$("#warning h4").html(data);
				$("#warning").css("display","block");
			}
		});
	});
	$("#Register").click(function(){
		$("#warning h4").html("");
		$("#warning").css("display","none");
	});
});