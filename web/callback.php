<?php

$answer = "";	//返すテキスト

$accessToken = getenv('LINE_CHANNEL_ACCESS_TOKEN');

//ユーザーからのメッセージ取得
$json_string = file_get_contents('php://input');
$jsonObj = json_decode($json_string);

$replyToken = $jsonObj->{"events"}[0]->{"replyToken"};

require_once("function.php");

if($jsonObj->{"events"}[0]->{"type"} == "message"){


$type = $jsonObj->{"events"}[0]->{"message"}->{"type"};
//メッセージ取得
$text = $jsonObj->{"events"}[0]->{"message"}->{"text"};
//ReplyToken取得

$url = parse_url(getenv('DATABASE_URL'));

$dsn = sprintf('pgsql:host=%s;dbname=%s', $url['host'], substr($url['path'], 1));

$existCheck = false;	//検索結果が取得でき高野判断

try{
$pdo = new PDO($dsn, $url['user'], $url['pass']); //DB接続
}catch(PDOException $e){
	exit();
}

if(mb_substr($text, 0, 5) != "リクエスト"){

	$existCheck = searchKey($pdo, $text);
if(!$existCheck){
	//$strArray = mb_str_split($text);//1文字ずつに分解して配列にす
$strArray = preg_split("//u", $text, -1, PREG_SPLIT_NO_EMPTY);

	foreach($strArray as $val){
		$sql = "select id from key where keyword LIKE '".$val."'";
		error_log($sql);
		$stmt = $pdo->query($sql);
		if($stmt){

		$res = $stmt->fetch(PDO::FETCH_ASSOC);
				$sql = "select id from categories where key1 = ".$res['id']." or key2 = ".$res['id'].
				" or key3 = ".$res['id']." or key4 = ".$res['id']." or key5 = ".$res['id'];

				$stmt->closeCursor();

				if($stmt = $pdo->query($sql)){
					while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			      $arrStr = print_r($row, true);
			      error_log($arrStr);
			      $res[] = $row;
			    }
					$existCheck = true;
					break;
        }
			}
	}
}

if($existCheck){
	$sql = "select title, album from songs where category = ";
	$stmt->closeCursor();
  $arrStr = print_r($res, true);
  error_log($arrStr);
	foreach($res as $key=>$val){
		if($key == 0){
			$sql .= $val['id'];
		}else{
			$sql .= " or category = ".$val['id']
      ;
		}
	}

	$stmt = $pdo->query($sql);

  $res = array();

	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $arrStr = print_r($row, true);
    error_log($arrStr);
    $res[] = $row;
  }

  $key = array_rand($res);

	$answer = $res[$key]['title'];

  $sql = "select image from albums where id = ".$res[$key]['album'];

  error_log($sql);

  $stmt->closeCursor();
  $stmt = $pdo->query($sql);
  $res = $stmt->fetch(PDO::FETCH_ASSOC);

  $response_format_text = [
  [
  	"type" => "text",
  	"text" => $answer
  ],
  [
  	"type" => "image",
  	"originalContentUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/".$res['image'].".jpg",
    "previewImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/".$res['image'].".jpg"
  ]];
}else{
		$answer = "見つかりませんでした。";
    $response_format_text = [[
    	"type" => "text",
    	"text" => $answer
    ],
    [
      "type" => "template",
      "altText" => "曲名のリクエストをしますか？",
      "template" => [
        "type" => "confirm",
        "text" => "曲名のリクエストをしますか？",
        "actions" => [[
          "type" => "postback",
          "label" => "はい",
          "data" => "action=request"
        ],
        [
          "type" => "postback",
          "label" => "いいえ",
          "data" => "action=ng"
        ]
      ]
    ]
  	]];}

}else{
	$arrStr = print_r(explode("＝", $text), true);
	$reqTitle = explode("＝", $text)[1];
	if(empty($reqTitle)){
		$reqTitle = explode("=", $text)[1];
	}
	$date = date('c');

	if(!empty($reqTitle)){
	if(!searchSong($pdo,$reqTitle)){
	$stmt = $pdo->prepare("insert into requests (title, date) values (:title, :date)");
	$stmt->bindParam(':title', $reqTitle, PDO::PARAM_STR);
	$stmt->bindParam(':date', $date, PDO::PARAM_STR);
	$flag = $stmt->execute();

	if($flag){
		$answer = "リクエストが完了しました。";
	}else{
		$answer = "リクエストに失敗しました。";
	}
}else{
	$answer = "既に登録されています。";
}
}else{
	$answer = "リクエストに失敗しました。";
}

	$response_format_text = [
	[
		"type" => "text",
		"text" => $answer
	]];

}
	}else if($jsonObj->{"events"}[0]->{"type"} == "postback"){
	if($jsonObj->{"events"}[0]->{"postback"}->{"data"} == "action=request"){
	$response_format_text = [
  [
  	"type" => "text",
  	"text" => "リクエストしたい曲名を、
		『リクエスト＝（リクエストしたい曲名）』の形式で入力してください。"
  ]];
}else{
	exit();
}
}else{
	exit();
}

//返信データ作成
/*if ($text == 'はい') {
  $response_format_text = [
    "type" => "template",
    "altText" => "こちらの〇〇はいかがですか？",
    "template" => [
      "type" => "buttons",
      "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img1.jpg",
      "title" => "○○レストラン",
      "text" => "お探しのレストランはこれですね",
      "actions" => [
          [
            "type" => "postback",
            "label" => "予約する",
            "data" => "action=buy&itemid=123"
          ],
          [
            "type" => "postback",
            "label" => "電話する",
            "data" => "action=pcall&itemid=123"
          ],
          [
            "type" => "uri",
            "label" => "詳しく見る",
            "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
          ],
          [
            "type" => "message",
            "label" => "違うやつ",
            "text" => "違うやつお願い"
          ]
      ]
    ]
  ];
} else if ($text == 'いいえ') {
  exit;
} else if ($text == '違うやつお願い') {
  $response_format_text = [
    "type" => "template",
    "altText" => "候補を３つご案内しています。",
    "template" => [
      "type" => "carousel",
      "columns" => [
          [
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-1.jpg",
            "title" => "●●レストラン",
            "text" => "こちらにしますか？",
            "actions" => [
              [
                  "type" => "postback",
                  "label" => "予約する",
                  "data" => "action=rsv&itemid=111"
              ],
              [
                  "type" => "postback",
                  "label" => "電話する",
                  "data" => "action=pcall&itemid=111"
              ],
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
              ]
            ]
          ],
          [
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-2.jpg",
            "title" => "▲▲レストラン",
            "text" => "それともこちら？（２つ目）",
            "actions" => [
              [
                  "type" => "postback",
                  "label" => "予約する",
                  "data" => "action=rsv&itemid=222"
              ],
              [
                  "type" => "postback",
                  "label" => "電話する",
                  "data" => "action=pcall&itemid=222"
              ],
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
              ]
            ]
          ],
          [
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-3.jpg",
            "title" => "■■レストラン",
            "text" => "はたまたこちら？（３つ目）",
            "actions" => [
              [
                  "type" => "postback",
                  "label" => "予約する",
                  "data" => "action=rsv&itemid=333"
              ],
              [
                  "type" => "postback",
                  "label" => "電話する",
                  "data" => "action=pcall&itemid=333"
              ],
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
              ]
            ]
          ]
      ]
    ]
  ];
} else {

}*/

$post_data = [
	"replyToken" => $replyToken,
	"messages" => $response_format_text
];


$ch = curl_init("https://api.line.me/v2/bot/message/reply");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json; charser=UTF-8',
    'Authorization: Bearer ' . $accessToken
    ));
$result = curl_exec($ch);
curl_close($ch);
