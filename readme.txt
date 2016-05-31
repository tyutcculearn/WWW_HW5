WWW Technologies and Applications 2016
HOMEWORK#3
NAME : WuYongxing
CCU ID: 404410904	
Link : http://dmplus.cs.ccu.edu.tw:49252/login.php 
click on the hyperlink "Link to Homework#3"

Project files : login.php register.php index.php article.php

(Explain project files:)
	[login.php]: Is a login page for user,you can login or register an account.there will show the error message if fail to login.

	[register.php]: Is a register page,when you click register button in login page,you will see this page and you can register an account.there are some register rules,error will show if you don't follow the rules.

	[index.php]:Is a index page,if you don't login,you can't see this page,i use session to do it.you will see your latest 5 article on the top and all article follow.when you click one article,you will see the detail content about the article.if you click your article,you can edit it or delete it.you can do a comment on any article.you can click home button to come back or logout button to logout.

	[article.php]:Is an article page,is use to create an article.

About mysql
	There are 3 table:user,article,respond.

	Table user have 4 field:id(primary),Email(unique),Name,Password.

	Table article have 6 field:id(primary),author_id(foreign key to table user),title,content,create_time,last_update.

	Table respond have 5 field:id(primary),article_id(foreign key to table article),user_id(foreign key to table user),message,timestamp.

(Important note to run your code)
	I have use addslashes() function to protect from SQL injection but i can't ensure that it will be ok on all SQL injection case,you can have a try.
(Additional functions you implement)
	No additional functions.