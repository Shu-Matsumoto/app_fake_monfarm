<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');

// 外部ファイルのインクルード
require("./monsterDataBaseDef.php");

$fileName = $_POST["channelName"] . ".csv";

// ファイルオープン
$file = fopen($CHANNELS_DIR."/".$fileName, "r");

// ファイルロック・・・ファイル排他制御
flock($file, LOCK_EX);

$contentsArray = array();
if ($file) {
  // 読み込めなくなるまで読み込み、末尾に読み込んだ文字列を連結する
  while ($line = fgetcsv($file)) {
    array_push($contentsArray, $line);
  }
}

// ファイルロック解除
flock($file, LOCK_UN);

// ファイルクローズ
fclose($file);

$output = [
  "channelName" => $_POST["channelName"],
  "contentsArray" => $contentsArray,
  "result" => "NORMAL_END"
];

echo json_encode($output);
?>