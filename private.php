<html>  
<head>  
<title>描かれしワードチェーン</title>  
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="https://rawgithub.com/dynamicguy/tagcloud/master/src/tagcloud.jquery.js"></script>
<script type="text/javascript">
var min=(innerHeight<innerWidth?innerHeight:innerWidth)-20;
var settings = {
    height: min,
    width: min,
    radius: min/4,
    speed: 0.5,
    slower: 0.9,
    timer: 5,
    fontMultiplier: 15,
    hoverStyle: {
        border: 'none',
        color: '#000000'
    },
    mouseOutStyle: {
        border: '',
        color: ''
    }
    };
</script>
<style type="text/css">  
body {
background-attachment: fixed;
background-repeat:repeat-y;
-moz-background-size:100% 100%;
background-size:100% 100%;

color:#ffffff;
}
div{  
    width: 800px;  
    margin: 0 auto;  
    text-align: left;  
    border: 1px solid #000000;  
}  
img{
    width:200px;
    position:relative;
    top:-25%;
    left:-25%;
}
</style>  
</head>  
<body background="BG.png" >
<script>
var ul=document.getElementById("ul");
$(document).ready(function(){
        $('#tagcloud').tagoSphere(settings);
    });
</script>
<div id="tagcloud" overflow: hidden; position: relative;">
        <ul id="ul">

<?php
 session_start();

try {
 
 $connectionInfo = array("UID" => "i13008@oktm", "pwd" => "*パスワードなので秘匿*", "Database" => "i13008", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:oktm.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);

 
  $tableName = "i13008_picture";
 
$stmt = sqlsrv_query( $conn, 'SELECT UP_TIME,NAME FROM i13008_picture where player_id=(SELECT id FROM  i13008_player WHERE NAME = \''.$_SESSION[id].'\')');
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC) ) {
echo "<li><img src=\"img/$_SESSION[id]_$row[0].png\" title=\"$row[1]\"/></li>";// $re は配列。echo では表示できない
    }
}catch( PDOException $error ){
    // 接続に失敗した場合、エラーメッセージを表示。
    echo "接続失敗:".$error->getMessage();
    die();
}
?>

</ul>
    </div>
