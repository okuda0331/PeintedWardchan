<?php
$connectionInfo = array("UID" => "i13008@oktm", "pwd" => "*パスワードなので秘匿*", "Database" => "i13008", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:oktm.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);
?>

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

<center><?php
if(empty($_POST['name']) || empty($_POST['pass'])){
	echo header("Location: ./login.php");
}else{
	$stmt = sqlsrv_prepare( $conn, 'insert into i13008_player(name, pass) values(? , ?)', array($_POST['name'] , $_POST['pass']));
if( !$stmt ) {
    echo "無効な値が入力されました";//die( print_r( sqlsrv_errors(), true));
}
    if( sqlsrv_execute( $stmt ) === false ) {
         echo "登録出来ませんでした";// die( print_r( sqlsrv_errors(), true));
    }else echo "登録しました<br><br><br><br>";
	
echo '<a href="login.php">ログインする</a>';
}
?></center></body>
</html>
