<html>  
<head>  
<title>描かれしワードチェーン</title>  
<style type="text/css">  

body {
background-attachment: fixed;
background-repeat:repeat-y;
-moz-background-size:100% 100%;
background-size:100% 100%;

color:#000000;
}
div{  
    width: 400px;  
    margin: 0 auto;  
    text-align: left;  
}  
span{
    display: inline-block;
    width:300px;
background-color: #000000;
}
</style>  
</head>  
<body background="BG.png" >
<div>
<?php
 
try {
 
$connectionInfo = array("UID" => "i13008@oktm", "pwd" => "12345678a!", "Database" => "i13008", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:oktm.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);

  $tableName = "i13008_picture";
$stmt = sqlsrv_query( $conn, 'SELECT NAME,UP_TIME,(SELECT name FROM  i13008_player WHERE id = player_id)as \'name\',name FROM i13008_picture ' );
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC) ) {
echo "<img src=\"img/$row[2]_$row[1].png\"/><br>";
echo "製作者:$row[2]<br>";
echo "答え:<span>$row[3]</span><br>";
echo "↓<br>";
    }

}catch( PDOException $error ){
    // 接続に失敗した場合、エラーメッセージを表示。
    echo "接続失敗:".$error->getMessage();
    die();
}
?>
</div>