<?php
$connectionInfo = array("UID" => "i13008@oktm", "pwd" => "*パスワードなので秘匿*", "Database" => "i13008", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:oktm.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);
?>
<html>
	<head>
		<title>ユーザ登録</title>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

	</head>
<body>
<?php
  //$name = $_POST["name"];
session_start();
$time= time();
 	$stmt = sqlsrv_prepare( $conn, 'INSERT INTO i13008_picture(player_id,name,up_time) VALUES ((SELECT id FROM  i13008_player WHERE name = \''.$_SESSION['id'].'\'),?,?)',array($_POST['name'],$time));


if( !$stmt ) {
    die( print_r( sqlsrv_errors(), true));
}
    if( sqlsrv_execute( $stmt ) === false ) {
          die( print_r( sqlsrv_errors(), true));
    }

if (is_uploaded_file($_FILES["picture"]["tmp_name"])) {
  if (move_uploaded_file($_FILES["picture"]["tmp_name"], "img/$_SESSION[id]_$time.png")) {
  }
} 
?>
</body>
</html>
