<html>  
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>描かれしワードチェーン</title>  
<style type="text/css">  

body {
background-attachment: fixed;
background-repeat:repeat-y;
-moz-background-size:100% 100%;
background-size:100% 100%;
}
.parent{
  position: absolute;
  top: 50%;
  left: 50%;
  margin-right: -50%;
  -webkit-transform: translate(-50%, -50%); /* Safari用 */
  transform: translate(-50%, -50%);

  
}.btn03 {
    color: #fff;
    text-decoration: none;
    background: #9EB8F3;
    width: 280px;
    padding: 30px 20px;
    position: relative;
    overflow: hidden;
    text-align: center;
    display: block;
    -webkit-transition: all 0.3s ease;
    transition: all 0.3s ease;
}
.btn03:hover {
    background-size: 100px 100px;
    background-position: right 50%;
    background-color: #799CEE;
}
.btn03::before {
    content: "";
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 30px;
    background: url("icon.png") no-repeat 0 50%;
    background-size: 38px 38px;
    -webkit-transition: all 0.3s ease;
    transition: all 0.3s ease;
}
.btn03:hover::before {
    left: 240px;
    background-size: 80px 80px;
 
}
.btn03 span {
    -webkit-transition: all 0.3s ease;
    transition: all 0.3s ease;
 
}
.btn03:hover span {
    margin-left: -180px;
}

</style>  
</head>  
<body background="BG.png" >
	
<div class="parent">
<img src="logo.png" />

<form action="./loginerror.php" method="POST">
			<table border="1">
				<tr><th>NAME</th><td style="width: 20px">
					<input type="text" name="name" id="name" style="width: 273px" value/></td></tr>
				<tr><th>PASSWORD<td style="width: 20px">
					<input type="password" name="pass" id="pass"style="width: 273px" value/></td></tr>
			</table>
			<br>
			<input type="submit" value="LOGIN" style="cursor:pointer;">

		</form>
			<a class="btn03" href="createAccount1.php"><span>ユーザ登録ページに行く</span></a>
			
			<a class="btn03" target="_blank" href="bonus/basic.html"><span>おまけ</span></a>(MySQLを使用してないネットの真似事)
</div>
</body>
</html>