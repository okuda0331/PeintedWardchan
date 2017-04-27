<html>  
<head>  
<title>描かれしワードチェーン</title> 
</head>

<body>
<?php
$connectionInfo = array("UID" => "i13008@oktm", "pwd" => "*パスワードなので秘匿*", "Database" => "i13008", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:oktm.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);
?>
<?php
$name = $_POST['name'];
$pass = $_POST['pass'];
?>
<center><br><br><br>
<?php
$sql = "SELECT * FROM i13008_player";
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

$login = false;
while( $row = sqlsrv_fetch_array( $stmt, PDO::FETCH_ASSOC) ) {
	if($row['name'] == $name && $row['pass'] == $pass){
		$login = true;	
	}
}

sqlsrv_free_stmt( $stmt);
if($login){
	session_start();
	$_SESSION['id'] = $name; 
//header('HTTP/1.1 307 Temporary Redirect');
	echo header("Location: ./index.php");

}else{
	echo "<p>ID,もしくはパスワードが違います</p>";
	echo '<br>';
	echo '<a href="login.php">戻る</a>';
}

?></center><br><br><br><br><br><br><br><br>
</body>
</html>
