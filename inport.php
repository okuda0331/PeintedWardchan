 // ファイル取得
    $filepath = "../file/test.csv";
    $file = new SplFileObject($filepath); 
    $file->setFlags(SplFileObject::READ_CSV);
 
    // 全行のINSERTデータ格納用
    $ins_values = "";
 
     
 
    // ファイル内のデータループ
 
    foreach ( $file as $key => $line ) {
 
     
        // 配列の値がすべて空か判定
        $judge = count( array_count_values( $line ) );
         
        if( $judge == 0 ){
             
            // 配列の値がすべて空の時の処理
            continue;
        }
         
        // 1行毎のINSERTデータ格納用
        $values = "";
 
        foreach ( $line as $line_key => $str ) {
             
            if( $line_key > 0 ){
 
                $values .= ", ";
            }
 
            // INSERT用のデータ作成
            $values .= "'".mb_convert_encoding( $str, "utf-8", "sjis" )."'";
        }
         
        if( !empty( $ins_values ) ){ 
 
            $ins_values .= ", ";
        }
 
        $ins_values .= "(". $values . ")";
    }
 
 
    $sql_insert = "INSERT INTO テーブル名 ( カラム01, カラム02, カラム03 ) VALUES " . $values;
    mysql_query( $sql_insert, $connect );
