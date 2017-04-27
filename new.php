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
canvas {
    border: solid 3px #000;
}

    </style>
</head>
<body background="BG.png" >
        <form action="peint3.php" method="post" enctype="multipart/form-data">
           <p align="center">
<p>
        この絵の次を書いてください<br>
<?php
try {
 
$connectionInfo = array("UID" => "i13008@oktm", "pwd" => "*パスワードなので秘匿*", "Database" => "i13008", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:oktm.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);

  $tableName = "i13008_picture";
$stmt = sqlsrv_query( $conn, 'SELECT TOP 1 UP_TIME,(SELECT name FROM  i13008_player WHERE id = player_id) FROM i13008_picture  order by id desc' );
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC) ) {
echo "<img src=\"img/$row[1]_$row[0].png\" align=\"left\" />
<label>ペンの色：</label><input type=\"color\" value=\"#000000\"><br>
<label>ペン太さ：</label><input type=\"number\" value=\"1\" id=\"penWidth\" min=\"1\" max=\"25\"></p><br>
製作者:$row[1]<br>";
    }

}catch( PDOException $error ){
    echo "接続失敗:".$error->getMessage();
    die();
}
?>

            <input type="button" value="戻る" id="backBtn">
            <input type="button" value="進む" id="forwardBtn">
    

            <input type="button" id="erase" value="消去">
別の場所で書いた場合は<input type="file" id="uploadFile" size="30" /><br>
<?php
    session_start();
    echo $_SESSION['id'].'さん作';
    ?><input type="text" name="name" value="">
<input type="button"  id="posting" value="投稿" /><br>

        <canvas width="400" height="300" id="mycanvas">
            Canvasに対応したブラウザを用意してください。
        </canvas>
        </p>
</form>    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

    <script>
        $(function(){
            var canvas = document.getElementById('mycanvas');
            if( !canvas || !canvas.getContext) return false;
            var ctx = canvas.getContext('2d');
            var paintFlag = "pen";
            var imageMemory = new Array(5);
            var flagMemory = 0;
            $('#backBtn, #forwardBtn').attr('disabled', true);
            
            
            var startX, startY, x, y;
            var thisX, thisY;
            var borderWidth = 10;
            var isDrawing = false;
            var ImageData;
            saveImageData();
            
            ctx.lineCap = "round";
            
            $('#mycanvas').on('touchstart mousedown', function(e){              
                
                e.preventDefault();
                thisX = e.pageX || e.originalEvent.changedTouches[0].pageX;
                thisY = e.pageY || e.originalEvent.changedTouches[0].pageY;
                
                startX = thisX - $(this).offset().left - borderWidth;
                startY = thisY - $(this).offset().top - borderWidth;
                
                if(paintFlag === "pen"){
                    isDrawing = true;
                    ctx.beginPath();
                    ctx.moveTo(startX, startY);
                }
                
                if(paintFlag === "fill"){
                    
                    ImageData = ctx.getImageData(0,0,canvas.width,canvas.height);
                    ctx.fillStyle = $('input[type="color"]')[0].value;
                    
                    
                    ctx.putImageData(ImageData, 0, 0);
                }
            })
            .on('touchmove mousemove',function(e){
                if(!isDrawing) return;
                e.preventDefault();
                thisX = e.pageX || e.originalEvent.changedTouches[0].pageX;
                thisY = e.pageY || e.originalEvent.changedTouches[0].pageY;
                x = thisX - $(this).offset().left - borderWidth;
                y = thisY - $(this).offset().top - borderWidth;
                
                ctx.lineTo(x, y);
                ctx.stroke();
                startX = x;
                startY = y;
                
            })
            .on('touchend mouseup', function(){
                saveImageData();
                isDrawing = false;
            })
            .on('touchleave mouseleave', function(e){
                if(!isDrawing) return;
                saveImageData();
                e.preventDefault();
                thisX = e.pageX || e.originalEvent.changedTouches[0].pageX;
                thisY = e.pageY || e.originalEvent.changedTouches[0].pageY;
                x = thisX - $(this).offset().left - borderWidth;
                y = thisY - $(this).offset().top - borderWidth;
                ctx.translate(0.5,0.5);
                ctx.lineTo(x, y);
                ctx.stroke();
                startX = x;
                startY = y;
                
                isDrawing = false;
            });
            
            $('#penColor').change(function(){
                $('input[type="color"]')[0].color.fromString($(this).val());
                $('input[type="color"]').trigger('change');
            });
            $('input[type="color"]').on('keyup input change', function(){
                ctx.strokeStyle =$(this).val();
            });
            
            $('#penWidth').on('change input', function(){
                ctx.lineWidth = $(this).val();
                onChangePenSample();
            });
            
            $('#erase').click(function(){
                if(!confirm('本当に消去しますか?')) return; 
                ctx.clearRect(0,0,canvas.width, canvas.height);
            });
            
            $('#posting').click(function(){
				var sendImageBinary = function(blob) {
                                var formData = new FormData();
					formData.append('picture', blob);
					formData.append('name', document.getElementsByName("name")[0].value);
					$.ajax({
						type: 'POST',
						url: 'peint2.php',
						data: formData,
						contentType: false,
						processData: false,
						success:function(date, dataType){
							var $img = $('img');
                           
                              document.forms[0].submit();
						},
						error: function(XMLHttpRequest, textStatus, errorThrown){
						}
					});
				};
				
				
                canvas = $('#mycanvas')[0].toDataURL();
				var base64Data = canvas.split(',')[1],
				    data = window.atob(base64Data), 
					buff = new ArrayBuffer(data.length),
					arr = new Uint8Array(buff),
					blob, i, dataLen;
                    
				for( i = 0, dataLen = data.length; i < dataLen; i++){
					arr[i] = data.charCodeAt(i);
				}
				blob = new Blob([arr], {type: 'image/png'});
				sendImageBinary(blob);
			});
            
            $('input[name="paintFlag"]').click(function(){
                paintFlag = $(this).data('paintflag');
            });
            
            function saveImageData(){
                if(flagMemory == imageMemory.length-1){
                    imageMemory.shift();
                }else{
                    ++flagMemory;
                }
                
                if(flagMemory == imageMemory.length-1){
                    $('#forwardBtn').attr('disabled',true);   
                }
                
                imageMemory[flagMemory] = ctx.getImageData(0,0,canvas.width,canvas.height);
                
                $('#backBtn').attr('disabled',false);
            }
            $('#backBtn').click(function(){
                if(flagMemory > 0){
                    flagMemory--;
                    ctx.putImageData(imageMemory[flagMemory], 0, 0);
                    
                    $('#forwardBtn').attr('disabled', false);
                    if(flagMemory==0){
                        $('#backBtn').attr('disabled', true);   
                    }
                }
            });
            $('#forwardBtn').click(function(){
                if(flagMemory < imageMemory.length-1){
                    flagMemory++;
                    ctx.putImageData(imageMemory[flagMemory], 0, 0);
                    
                    $('#backBtn').attr('disabled', false);
                    if(flagMemory==imageMemory.length-1){
                        $('#forwardBtn').attr('disabled', true);   
                    }
                }
                
            });
        });
  $("#uploadFile").change(function() {
    var canvas = $("#mycanvas");
    var ctx = canvas[0].getContext("2d");

    var file = this.files[0];

    if (!file.type.match(/^image\/(png|jpeg|gif)$/)) return;

    var image = new Image();
    var reader = new FileReader();

    reader.onload = function(evt) {

      image.onload = function() {
        ctx.drawImage(image, 0, 0,image.width*canvas[0].height/image.height,canvas[0].height);
      }

      image.src = evt.target.result;
    }

    reader.readAsDataURL(file);
  });

    </script>
</body>
</html>
