<?php

include("funcs.php");

$name = $_POST["name"];
$mail = $_POST["mail"];
$age = $_POST["age"];
$breakfast = $_POST["breakfast"];

?>

<html>
<head>
<meta charset="utf-8">
<title>POST（受信）</title>
</head>
<body>
お名前：<?= h($name) ?>
年齢：<?= h($age) ?>
朝食：<?= h($breakfast) ?>
Mail：<?= h($mail) ?>
<ul>
<li><a href="index.php">index.php</a></li>
</ul>
</body>
</html>