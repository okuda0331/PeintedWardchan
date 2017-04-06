<html>
	<head>
		<title>ユーザ登録</title>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<style type="text/css">  

body {
-moz-background-size:100% 100%;
background-size:100% 100%;
}
</style>
	</head>
<body background="BG.png" >
		<form action="./createAccount.php" method="POST">
			<center>
			<p>ログインに使用するIDとパスワードを入力してください</p><br><br>
			<table border="1">
				<tr><th>ID</th><td>
					<input type="text" name="name" style="width: 273px"></td></tr>
				<tr><th>PASSWORD</th><td>
					<input type="password" name="pass" required style="width: 273px"></td></tr>
			</table>
			<br><br><br>
			<input class="button1" type="submit" value="ENTER"  style="cursor:pointer;">
			</center>
		</form>
	</body>
</html>