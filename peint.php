<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>canvasを使ったお絵描き投稿システム</title>
    <style>
        #main{
            overflow:hidden;
        }
        #mycanvas{
            border: 10px solid #999;
            cursor:crosshair;
        }
        #canvasTool{
            float:left;
        }
        #penWidth{
            width:50px;
        }
    </style>
</head>
<body>
    <div id="main">
        <div id="canvasTool">
            <input class="color" value="000000">
            <select id="penColor">
                <option value="000000">黒色</option>
                <option value="FF0000">赤色</option>
                <option value="FFFF00">黄色</option>
                <option value="00FF00">緑色</option>
                <option value="0000FF">青色</option>
                <option value="FFFFFF">白色</option>
            </select>
            <br>
            <label>ペンの太さ：</label>
            <input type="number" value="1" id="penWidth" min="1" max="25">
            <br>
            <canvas id="penSample" width="100" height="100"></canvas>
            <br>
            <label><input type="radio" name="paintFlag" data-paintflag="pen" checked>ペン</label>
            <label><input type="radio" name="paintFlag" data-paintflag="fill">塗りつぶし</label>
            <br>
            <input type="button" value="戻る" id="backBtn">
            <input type="button" value="進む" id="forwardBtn">
            <br>
            <input type="button" id="erase" value="消去">
            <input type="button" id="posting" value="投稿">
            <input type="button" id="imaging" value="画像化">
        </div>
        <canvas width="400" height="200" id="mycanvas">
            Canvasに対応したブラウザを用意してください。
        </canvas>
    </div>
    <div>
        <p>最近投稿された画像</p>
        <img src="test.png" alt="">
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="jscolor/jscolor.js"></script>
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
            
            var penSampleCtx = document.getElementById('penSample').getContext('2d');
            var onChangePenSample = function(){
                penSampleCtx.clearRect(0,0,document.getElementById('penSample').width, document.getElementById('penSample').height);
                penSampleCtx.lineCap = "round";
                penSampleCtx.strokeStyle = "#" + $('.color').val();
                penSampleCtx.lineWidth = $('#penWidth').val();
                penSampleCtx.beginPath();
                penSampleCtx.moveTo(25, 25);
                penSampleCtx.lineTo(50, 50);
                penSampleCtx.stroke();
            };
            onChangePenSample();

            $('#mycanvas').on('touchstart mousedown', function(e){              
                
                //console.log(e);
                //console.log(e.preventDefault);
                //console.log("touchstart mousedown");
                e.preventDefault();
                thisX = e.pageX || e.originalEvent.changedTouches[0].pageX;
                thisY = e.pageY || e.originalEvent.changedTouches[0].pageY;
                //console.log("thisX:" + thisX + ",thisY:" + thisY);
                
                startX = thisX - $(this).offset().left - borderWidth;
                startY = thisY - $(this).offset().top - borderWidth;
                
                if(paintFlag === "pen"){
                    isDrawing = true;
                    ctx.beginPath();
                    ctx.moveTo(startX, startY);
                }
                
                if(paintFlag === "fill"){
                    
                    ImageData = ctx.getImageData(0,0,canvas.width,canvas.height);
                    var colorCode = $('.color')[0].value;
                    var rgbCode = new Array(3);
                    rgbCode[0] = parseInt(colorCode.substr(0,2),16)
                    rgbCode[1] = parseInt(colorCode.substr(2,2),16)
                    rgbCode[2] = parseInt(colorCode.substr(4,2),16)
                    console.log('colorValue-10進数:' + rgbCode);
                    regionFill(ImageData, startX, startY, rgbCode);
                    /*
                    赤い点を打つ
                    ImageData.data[(startY*ImageData.width+startX)*4] = 255;
                    ImageData.data[(startY*ImageData.width+startX)*4+3] = 255;
                    */
                    
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
                //console.log("touchend mouseup");
                isDrawing = false;
            })
            .on('touchleave mouseleave', function(e){
                //console.log("touchleave mouseleave");
                if(!isDrawing) return;
                saveImageData();
                e.preventDefault();
                thisX = e.pageX || e.originalEvent.changedTouches[0].pageX;
                thisY = e.pageY || e.originalEvent.changedTouches[0].pageY;
                x = thisX - $(this).offset().left - borderWidth;
                y = thisY - $(this).offset().top - borderWidth;
                
                console.log("x:" + x);
                console.log("y:" + y);
                
                //ctx.beginPath();
                ctx.translate(0.5,0.5);
                //ctx.moveTo(startX, startY);
                ctx.lineTo(x, y);
                ctx.stroke();
                startX = x;
                startY = y;
                
                isDrawing = false;
            });
            
            $('#penColor').change(function(){
                $('.color')[0].color.fromString($(this).val());
                $('.color').trigger('change');
            });
            $('.color').on('keyup input change', function(){
                ctx.strokeStyle = "#" + $(this).val();
                onChangePenSample();
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
				
				// バイナリ化した画像をPOSTで送る関数
				// http://blog.sarabande.jp/post/30694191998
				var sendImageBinary = function(blob) {
					var formData = new FormData();
					formData.append('picture', blob);
					
					$.ajax({
						type: 'POST',
						url: 'peint2.php',
						data: formData,
						contentType: false,
						processData: false,
						success:function(date, dataType){
							//console.log("succcess");
							//console.log(data);
							var $img = $('img');
							var imgSrc = $img.attr('src');
							$img.attr('src', "");
							$img.attr('src', imgSrc);
						},
						error: function(XMLHttpRequest, textStatus, errorThrown){
							//console.log("error");
							//console.log(XMLHttpRequest);
							//console.log(textStatus);
						}
					});
				};
				
				
                canvas = $('#mycanvas')[0].toDataURL();
				var base64Data = canvas.split(',')[1], // Data URLからBase64のデータ部分のみを取得
				    data = window.atob(base64Data), // base64形式の文字列をデコード
					buff = new ArrayBuffer(data.length),
					arr = new Uint8Array(buff),
					blob, i, dataLen;
				
				// blobの生成
				for( i = 0, dataLen = data.length; i < dataLen; i++){
					arr[i] = data.charCodeAt(i);
				}
				blob = new Blob([arr], {type: 'image/png'});
				sendImageBinary(blob);
			});
            
            $('#imaging').click(function(){
                window.open($('#mycanvas')[0].toDataURL());
            });
            
            $('input[name="paintFlag"]').click(function(){
                paintFlag = $(this).data('paintflag');
                console.log(paintFlag);
            });
            
            // 現在のキャンバス状態を保存
            function saveImageData(){
                // 現在の状態を保存
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
            // 戻るボタン
            $('#backBtn').click(function(){
                if(flagMemory > 0){
                    flagMemory--;
                    //console.log("flagMemory;" + flagMemory);
                    ctx.putImageData(imageMemory[flagMemory], 0, 0);
                    
                    $('#forwardBtn').attr('disabled', false);
                    if(flagMemory==0){
                        $('#backBtn').attr('disabled', true);   
                    }
                }
            });
            // 進むボタン
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
            
            // 色比較用関数
            function compareColor(ImageData, x, y,selectColorRGB,isAlpha){
                // xやyがcanvasの域内に収まっていなければfalseを返す
                if(x<0 || y<0 || x>=ImageData.width || y>=ImageData.height){
                    return false;
                }
                
                var currentColorRGB = new Array(3);
                currentColorRGB[0] = ImageData.data[(y*ImageData.width+x)*4+0];
                currentColorRGB[1] = ImageData.data[(y*ImageData.width+x)*4+1];
                currentColorRGB[2] = ImageData.data[(y*ImageData.width+x)*4+2];
                var alphaInfo = ImageData.data[(y*ImageData.width+x)*4+3];

                if(alphaInfo !== 0){
                    // 最初に選択した色と現在処理している色が違うならばfalseを返す
                    if(selectColorRGB[0] !== currentColorRGB[0] ||
                      selectColorRGB[1] !== currentColorRGB[1] ||
                      selectColorRGB[2] !== currentColorRGB[2]){
                        return false;
                    }
                    // 最初に選択した色が透明で現在処理中の色が透明でなければfalseを返す
                    if(isAlpha){
                        return false;
                    }
                // 最初に選択した色が透明でなく、現在処理中の色が透明であればfalseを返す
                }else if(alphaInfo === 0 && !isAlpha){
                    return false;
                }
                
                return true;
            }
            
            // 塗りつぶし用関数
            // ImageData:canvasのgetImageDataで取得したデータ
            // fillColor:塗りつぶし用の色の16進数コード(赤：FF0000,白：FFFFFF) もしくは、RGB値を入れた配列
            function regionFill(ImageData, x, y, fillColor){
                /*
                console.log("regionFill");
                console.log("x:" + x + "-y:" + y);
                console.log("width:" + ImageData.width + "-height:" + ImageData.height);
                */
                var fillColorRGB = fillColor;
                if(x<0 || y<0 || x>=ImageData.width || y>=ImageData.height){
                    return;
                }
                
                if(typeof fillColorRGB === 'string'){
                    fillColorRGB = [parseInt(fillColor.substr(0,2),16),
                                    parseInt(fillColor.substr(2,2),16),
                                    parseInt(fillColor.substr(4,2),16)];
                }
                var selectColorRGB = new Array(3);
                selectColorRGB[0] = ImageData.data[(y*ImageData.width+x)*4+0];
                selectColorRGB[1] = ImageData.data[(y*ImageData.width+x)*4+1];
                selectColorRGB[2] = ImageData.data[(y*ImageData.width+x)*4+2];
                var alphaInfo = ImageData.data[(y*ImageData.width+x)*4+3];
                
                var isAlpha = !Boolean(alphaInfo);
                if(alphaInfo !== 0){
                    // 塗りつぶす色と現在処理している色が同じならば関数を抜ける
                    if(fillColorRGB[0] === selectColorRGB[0] &&
                      fillColorRGB[1] === selectColorRGB[1] &&
                      fillColorRGB[2] === selectColorRGB[2]){
                        console.log("return");
                        return;
                    }
                }
                
                var pxlArr = [{ x:x, y:y}];
                var idx,p;
                
                while(pxlArr.length){
                    p = pxlArr.pop();
                    
                    // 現在のピクセル
                    if(compareColor(ImageData, p.x, p.y,selectColorRGB,isAlpha)){
                        idx = (p.y*ImageData.width+p.x)*4;
                        ImageData.data[idx+0] = fillColorRGB[0];
                        ImageData.data[idx+1] = fillColorRGB[1];
                        ImageData.data[idx+2] = fillColorRGB[2];
                        ImageData.data[idx+3] = 255;
                        
                        // 上
                        if( compareColor(ImageData, p.x, p.y-1,selectColorRGB,isAlpha) ){
                            pxlArr.push({x:p.x, y:p.y-1});
                        }
                        // 右
                        if( compareColor(ImageData, p.x+1, p.y,selectColorRGB,isAlpha) ){
                            pxlArr.push({x:p.x+1, y:p.y});
                        }
                        // 下
                        if( compareColor(ImageData, p.x, p.y+1,selectColorRGB,isAlpha) ){
                            pxlArr.push({x:p.x, y:p.y+1});
                        }
                        
                        // 左
                        if( compareColor(ImageData, p.x-1, p.y,selectColorRGB,isAlpha) ){
                            pxlArr.push({x:p.x-1, y:p.y});
                        }
                        
                    }
                    
                }
            }
        });
    </script>
</body>
</html>