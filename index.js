$(document).ready(function(){
	$("#respond").click(function(){
		var d = $("#respondform").serializeArray();
		$.post("./addrespond.php",d,function(data){
			if(data == "OK")
			{
				$.post("./respond.php",d,function(data){
					var myjson = eval('(' + data + ')');
					var ans = ""; 
					for(var i = 0; i < myjson.length; i++)
					{
						 ans = ans +"<tr><td>"+myjson[i].Name+"</td><td>"+myjson[i].message+"</td><td>"+myjson[i].timestamp+"</td></tr>";
					}
					$("#respondlist").html(ans);
				});
				$("#message").val("");
			}
		});
	});
	$("#code").click(function(){
		$("#content1").css("display","block");
		$("#content2").css("display","none");
	});
	$("#html").click(function(){
		$("#content1").css("display","none");
		$("#content2").css("display","block");
		var text = $.tran1($("#content1").val());
		$("#content2").html(text);
	});
	$("#youtube").click(function(){
		var flag = $("#video").css("display");
		if(flag == "none")
			$("#video").css("display","block");
		else
			$("#video").css("display","none");
	});
	$("#insert").click(function(){
		var text = $("#URL").val();
		if(text == "") return false;
		var newtext = $("#content1").val();
		newtext = newtext + "\n<YOUTUBE>" + text + "</YOUTUBE>";
		$("#content1").val(newtext);
		$("#content2").html($.tran1($("#content1").val()));
		$("#URL").val("");
	});
	$("#bold").click(function(){
		var flag = $("#content1").css("display");
		if(flag == "none") return false;
		var textarea = document.getElementById("content1");
		var start = textarea.selectionStart;
		var end = textarea.selectionEnd;
		var text = $("#content1").val();
		var newtext = text.substr(0,start) + "<Strong>" + text.substr(start,end - start) + "</Strong>" + text.substr(end);
		$("#content1").val(newtext);
	});
	$("#italic").click(function(){
		var flag = $("#content1").css("display");
		if(flag == "none") return false;
		var textarea = document.getElementById("content1");
		var start = textarea.selectionStart;
		var end = textarea.selectionEnd;
		var text = $("#content1").val();
		var newtext = text.substr(0,start) + "<em>" + text.substr(start,end - start) + "</em>" + text.substr(end);
		$("#content1").val(newtext);
	});
	$("#red").click(function(){
		var flag = $("#content1").css("display");
		if(flag == "none") return false;
		var textarea = document.getElementById("content1");
		var start = textarea.selectionStart;
		var end = textarea.selectionEnd;
		var text = $("#content1").val();
		var newtext = text.substr(0,start) + "<R>" + text.substr(start,end - start) + "</R>" + text.substr(end);
		$("#content1").val(newtext);
	});
	$("#blue").click(function(){
		var flag = $("#content1").css("display");
		if(flag == "none") return false;
		var textarea = document.getElementById("content1");
		var start = textarea.selectionStart;
		var end = textarea.selectionEnd;
		var text = $("#content1").val();
		var newtext = text.substr(0,start) + "<B>" + text.substr(start,end - start) + "</B>" + text.substr(end);
		$("#content1").val(newtext);
	});
	$("#green").click(function(){
		var flag = $("#content1").css("display");
		if(flag == "none") return false;
		var textarea = document.getElementById("content1");
		var start = textarea.selectionStart;
		var end = textarea.selectionEnd;
		var text = $("#content1").val();
		var newtext = text.substr(0,start) + "<G>" + text.substr(start,end - start) + "</G>" + text.substr(end);
		$("#content1").val(newtext);
	});
	$("#new").click(function(){
		$("#biaoti").html("Create new article");
		$("#content1").css("display","block");
		$("#content2").css("display","none");
		$("#content1").val("");
		$("#content2").val("");
		$("#video").css("display","none");
		$("#URL").html("");
	});
	$("#newarticle").click(function(){
		if($("#article_id").val() == "")
		{
			var d = $("#newform").serializeArray();
			$.post("./newarticle.php",d,function(data){
				if(data == "OK") 
				{
					alert("新增成功");
					$("#content1").val("");
					$("#content2").val("");
					$("#URL").html("");
					$("#title").val("");
					$.post("./articlelist.php",{id:$("#uid").val()},function(data){
						var myjson = eval('(' + data + ')');
						var text = "<tr><td>发表日期</td><td>Author</td><td>Title</td><td>回复</td><td>最后更新时间/回复</td></tr>";
						for(var i = 0; i < myjson.length; i++)
						{
							 text = text + "<tr>\
									<td>"+myjson[i]['created_time']+"</td>\
									<td>"+myjson[i]['Name']+"</td>\
									<td><a href=\"./index.php?article_id="+myjson[i]['id']+"\">"+myjson[i]['title']+"</a></td>\
									<td>"+myjson[i]['num']+"</td>\
									<td>"+myjson[i]['last_update']+"</td>\
								  </tr>" 
						}
						$("#userarticle").html(text);
					});
					$.post("./articlelist.php",function(data){
						var myjson = eval('(' + data + ')');
						var text = "<tr><td>发表日期</td><td>Author</td><td>Title</td><td>回复</td><td>最后更新时间/回复</td></tr>";
						for(var i = 0; i < myjson.length; i++)
						{
							 text = text + "<tr>\
									<td>"+myjson[i]['created_time']+"</td>\
									<td>"+myjson[i]['Name']+"</td>\
									<td><a href=\"./index.php?article_id="+myjson[i]['id']+"\">"+myjson[i]['title']+"</a></td>\
									<td>"+myjson[i]['num']+"</td>\
									<td>"+myjson[i]['last_update']+"</td>\
								  </tr>" 
						}
						$("#otherarticle").html(text);
					});
				}
			});
		}
		else
		{
			dat = new Object();
			dat.article_id = $("#article_id").val();
			dat.title = $("#title").val();
			dat.content = $("#content1").val();
			$.post("./newarticle.php",dat,function(data){
				if(data == "OK")
				{
					alert("修改成功");
					$.post("./articlelist.php",{article_id:$("#article_id").val()},function(data){
						var myjson = eval('(' + data + ')');
						$("#article_title").html(myjson.title);
						$("#article_update").html(myjson.Name + " Updated On " + myjson.last_update);
						$("#article_content").html($.tran2(myjson.content));
					});
				}
			});
		}
	});
	$("#edit").click(function(){
		$("#biaoti").html("Edit article");
		$("#content1").css("display","block");
		$("#content2").css("display","none");
		$.post("./articlelist.php",{article_id:$("#article_id").val()},function(data){
			var myjson = eval('(' + data + ')');
			$("#title").val(myjson.title);
			$("#content1").val(myjson.content);
			$("#content2").html($.tran1(myjson.content));
		});
		$("#video").css("display","none");
		$("#URL").html("");
	});
});
$.extend({
    tran1:function(text)
    {
    	text = text.replace(/<R>/g,"<span style=\"color:red;\">");
    	text = text.replace(/<\/R>/g,"</span>");
    	text = text.replace(/<B>/g,"<span style=\"color:blue;\">");
    	text = text.replace(/<\/B>/g,"</span>");
    	text = text.replace(/<G>/g,"<span style=\"color:green;\">");
    	text = text.replace(/<\/G>/g,"</span>");
    	text = text.replace(/<YOUTUBE>/g,"影片不提供预览<br>(");
    	text = text.replace(/<\/YOUTUBE>/g,")");
    	text = text.replace(/\n/g,"<br>");
    	return text;
    }
});
$.extend({
    tran2:function(text)
    {
    	text = text.replace(/<R>/g,"<span style=\"color:red;\">");
    	text = text.replace(/<\/R>/g,"</span>");
    	text = text.replace(/<B>/g,"<span style=\"color:blue;\">");
    	text = text.replace(/<\/B>/g,"</span>");
    	text = text.replace(/<G>/g,"<span style=\"color:green;\">");
    	text = text.replace(/<\/G>/g,"</span>");
    	text = text.replace(/<YOUTUBE>/g,"<iframe src=\"");
    	text = text.replace(/watch\?v=/g,"v/");
    	text = text.replace(/<\/YOUTUBE>/g,"\" width=\"550\" height=\"550\" frameborder=\"0\" allowfullscreen></iframe>");
    	text = text.replace(/\n/g,"<br>");
    	return text;
    }
});