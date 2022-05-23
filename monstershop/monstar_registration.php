<?php
// POSTデータ確認
if (
  !isset($_POST['name']) || $_POST['name']=='' ||
  !isset($_POST['birthday']) || $_POST['birthday']=='' ||
  !isset($_POST['sellingPrice']) || $_POST['sellingPrice']=='' ||
  !isset($_POST['life']) || $_POST['life']=='' ||
  !isset($_POST['power']) || $_POST['power']=='' ||
  !isset($_POST['durability']) || $_POST['durability']=='' ||
  !isset($_POST['hit']) || $_POST['hit']=='' ||
  !isset($_POST['evasion']) || $_POST['evasion']=='' ||
  !isset($_POST['intelligence']) || $_POST['intelligence']==''
) {
  exit('ParamError');
}

$name = $_POST['name'];
$birthday = $_POST['birthday'];
$sellingPrice = $_POST['sellingPrice'];
$life = $_POST['life'];
$power = $_POST['power'];
$durability = $_POST['durability'];
$hit = $_POST['hit'];
$evasion = $_POST['evasion'];
$intelligence = $_POST['intelligence'];

// DB接続
// 各種項目設定
$dbn ='mysql:dbname=app_fake_monfarm;charset=utf8mb4;port=3306;host=localhost';
$user = 'root';
$pwd = '';

// DB接続
try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}

// SQL作成&実行
// SQL作成&実行
$sql = "INSERT INTO ".
"monster_ability ".
"(name, birthday, sellingPrice, life, power, durability, hit, evasion, intelligence) ".
"VALUES (:name, :birthday, :sellingPrice, :life, :power, :durability, :hit, :evasion, :intelligence)";

$stmt = $pdo->prepare($sql);

// バインド変数を設定
$stmt->bindValue(':name',         $name, PDO::PARAM_STR);
$stmt->bindValue(':birthday',     $birthday, PDO::PARAM_STR);
$stmt->bindValue(':sellingPrice', $sellingPrice, PDO::PARAM_STR);
$stmt->bindValue(':life',         $life, PDO::PARAM_STR);
$stmt->bindValue(':power',        $power, PDO::PARAM_STR);
$stmt->bindValue(':durability',   $durability, PDO::PARAM_STR);
$stmt->bindValue(':hit',          $hit, PDO::PARAM_STR);
$stmt->bindValue(':evasion',      $evasion, PDO::PARAM_STR);
$stmt->bindValue(':intelligence', $intelligence, PDO::PARAM_STR);

// SQL実行（実行に失敗すると `sql error ...` が出力される）
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:monstar_registration_form.php");
exit();
