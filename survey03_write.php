<?php

$name = $_POST["name"];
$age = $_POST["age"];
$mail = $_POST["mail"];
$breakfast = $_POST["breakfast"];
$egg = $_POST["egg"];
$rate = $_POST["rate"];


//文字作成

// タイムゾーンを日本に設定
date_default_timezone_set("Asia/Tokyo");

$string = $age.",".$breakfast.",".$egg.",".$rate.",".$name.",".$mail.",".date("Y年m月d日 H:i");
// $string = date("Y-m-d H:i:s").",".$name.",".$mail;

//File書き込み
$file = fopen("data/data2.txt","a");	// ファイル読み込み
fwrite($file, $string."\n");
fclose($file);

?>


<html>
<head>
<meta charset="utf-8">
<title>File書き込み</title>
</head>
<body>

<div>アンケートにご協力いただきありがとうございます</div>

<ul>
<li><a href="survey04_result.php">アンケート結果を見る</a></li>
</ul>
</body>
</html>