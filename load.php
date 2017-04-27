<?php
 
if (isset($_GET['name'])) {
  $name = $_GET['name'];
}
 
// 拡張子によってMIMEタイプを切り替えるための配列
$MIMETypes = array(
   'png'  => 'image/png',
   'jpg'  => 'image/jpeg',
   'jpeg' => 'image/jpeg',
   'gif'  => 'image/gif',
   'bmp'  => 'image/bmp',
);
 
try {
 $connectionInfo = array("UID" => "i13008@oktm", "pwd" => "*パスワードなので秘匿*", "Database" => "i13008", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:oktm.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);

 
  $tableName = "i13008_picture";
 
  // データベースから条件に一致する行を取り出す
  $data =  sqlsrv_query( $conn, 'SELECT * FROM ' . $tableName . ' WHERE id = 2' )->sqlsrv_fetch(PDO::FETCH_ASSOC);
  // 画像として扱うための設定
  //header('Content-type: ' . $MIMETypes[$data['extension']]);
//header('Content-type: ' . $MIMETypes['png']);
//  echo $data['picture'];
echo '<img src="data:image/png;base64,'.base64_encode($data['picture']).'"  />';
 
} catch (Exception $e) {
  echo "load failed: " . $e;
}
