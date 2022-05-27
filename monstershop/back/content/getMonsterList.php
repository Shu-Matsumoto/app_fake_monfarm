<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');

include("./dataBaseCommon.php");
// DB接続
$pdo = ConnectToDB();

// SQL作成&実行
//$sql = "SELECT ".$DB_TABLE_PRIMARY_KEY." FROM ".$DB_TABLE_NAME."";
$sql = "SELECT `name` FROM `monster_ability`";
$stmt = $pdo->prepare($sql);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$listLocal = $stmt->fetchAll(PDO::FETCH_ASSOC);

$list = array();
foreach ($listLocal as $record) {
  array_push($list, $record["name"]);
}

$output = [
  "monsterList" => $list,
  "result" => "NORMAL_END"
];

echo json_encode($output);
?>