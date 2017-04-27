<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>描かれしワードチェーン</title>  
<style type="text/css">  
body {
    background-attachment: fixed;
background-repeat:repeat-y;
-moz-background-size:100% 100%;
background-size:100% 100%;
}
</style>  
</head>  
<body background="BG.png" >
<p align="center">
</head>
<body>
    <?
        try {
 
$connectionInfo = array("UID" => "i13008@oktm", "pwd" => "*パスワードなので秘匿*", "Database" => "i13008", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:oktm.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);

  $tableName = "i13008_picture";
$stmt = sqlsrv_query( $conn, 'SELECT TOP 1 UP_TIME,(SELECT name FROM  i13008_player WHERE id = player_id) FROM i13008_picture  order by id desc' );
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC) ) {
echo "<img src=\"img/$row[1]_$row[0].png\"  />
製作者:$row[1]<br>";
    }

}catch( PDOException $error ){
    echo "接続失敗:".$error->getMessage();
    die();
}
        ?>
        	<a href="index.php">戻る</a>
</body>
</html>
