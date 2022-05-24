<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');

// 外部ファイルのインクルード
require("./monsterDataBaseDef.php");

try {
  $pdo = new PDO($DB_SERVER, $DB_ACCESS_USER, $DB_ACCESS_PWD);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}

// SQL作成&実行
$sql = "SELECT * FROM `monster_ability` WHERE name = \"".$_POST["monsterName"]."\"";
//$sql = "SELECT * FROM `monster_ability` WHERE name = \"ティラノサウルス\"";
$stmt = $pdo->prepare($sql);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$ability = $stmt->fetch(PDO::FETCH_ASSOC);

$output = [
  "monsterAbility" => $ability,
  "sqlStr" => $sql,
  "result" => "NORMAL_END"
];

echo json_encode($output);
?>