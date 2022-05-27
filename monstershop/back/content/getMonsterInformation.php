<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');

include("./dataBaseCommon.php");
// DB接続
$pdo = ConnectToDB();

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