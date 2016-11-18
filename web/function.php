<?php
function searchKey($pdo = "", $text = ""){
  $sql = "select id from key where keyword LIKE '%".$text."%'";
  $stmt = $pdo->query($sql);

  	$res = $stmt->fetch(PDO::FETCH_ASSOC);
  	if(!empty($res['id'])){
  	$sql = "select id from categories where key1 = ".$res['id']." or key2 = ".$res['id'].
  	" or key3 = ".$res['id']." or key4 = ".$res['id']." or key5 = ".$res['id'];
  	$stmt->closeCursor();
    $res = array();
  	$stmt = $pdo->query($sql);
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $arrStr = print_r($row, true);
        error_log($arrStr);
        $res[] = $row;
      }
  	return true;
  }else{
    return false;
  }
}

function searchSong($pdo = "", $text = ""){
  //$sql = "select id from songs where title = '".$text."'";
  //$stmt = $pdo->query($sql);
  $stmt = $pdo->query("select id from songs where title = '".$text."'");
  if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  	return true;
  }else{
    return false;
  }
}


 ?>
