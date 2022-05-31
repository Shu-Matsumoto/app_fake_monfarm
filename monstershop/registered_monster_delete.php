<?php
include("./back/content/dataBaseCommon.php");

session_start();
// ログイン状態チェック (ログインしていない状態だとログイン画面へ遷移する)
check_session_id("../login.php");

var_dump($_GET);

// 入力項目のチェック
if (
  !isset($_GET['name']) || $_GET['name'] == ''
) {
  exit('paramError');
}

// データ受け取り
$name = $_GET['name'];

// DB接続
$pdo = ConnectToDB();

// SQL実行
$sql = 'DELETE FROM monster_ability WHERE name=:name';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:registered_monster_read.php");
exit();
