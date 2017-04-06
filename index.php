<html>  
<head>  
<title>描かれしワードチェーン</title>  
<style type="text/css">  

body {
background-attachment: fixed;
background-repeat:repeat-y;
-moz-background-size:100% 100%;
background-size:100% 100%;
color:#ffffff;
}
.parent{
  position: absolute;
  top: 50%;
  left: 50%;
  margin-right: -50%;
  -webkit-transform: translate(-50%, -50%); /* Safari用 */
  transform: translate(-50%, -50%);

  
}
        .btn05 {
            color: #fff;
            display: block;
            text-decoration: none;
            width: 200px;
            position: relative;
            perspective: 300px;
            -webkit-perspective: 300px;
        }

        .btn05 span {
            text-align: center;
            display: block;
            width: 200px;
            padding: 5px 0;
            background-color: #a7dd7d;
            position:absolute;
            top: 0;
            margin-top: -30px;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            transition: 0.8s;
        }
        .btn05 .back {
            background-color: #61a84d;
            transform:rotateY(180deg);
            -webkit-transform:rotateY(180deg);
        }

        .btn05:hover .front {
            transform:rotateY(180deg);
            -webkit-transform:rotateY(180deg);
        }

        .btn05:hover .back {
            transform:rotateY(360deg);
            -webkit-transform:rotateY(360deg);
        }

</style>  
</head>  
<body background="BG.png" >
<p align="right">
<?php
session_start();

if(isset($_SESSION['id'])){
	echo "ようこそ".$_SESSION['id']."さん";

}else echo header("Location: ./login.php");
?>
<input type="button" value="ログアウト" onclick="location.href ='logout.php'"><br><br><br><br>
 </p>
<div class="parent">
<img src="logo.png" />
<p align="center" class="child">
<a class="btn05" href="List.php">
    <span class="front">絵しりとりの．．．</span>
    <span class="back">一覧</span>
</a><br><br>
<a class="btn05" href="new.php">
    <span class="front">新しい画像を．．．</span>
    <span class="back">投稿</span>
</a><br><br>
<a class="btn05" href="private.php">
    <span class="front">過去に自分が作った．．．</span>
    <span class="back">作品</span>
</a>

</p>
</div>