<?php
include("./back/content/dataBaseCommon.php");

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
$pdo = ConnectToDB();

// SQL実行]
$sql = 'UPDATE monster_ability SET birthday=:birthday, sellingPrice=:sellingPrice, 
life=:life, 
power=:power, 
durability=:durability, 
hit=:hit, 
evasion=:evasion, 
intelligence=:intelligence WHERE name=:name';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':birthday', $birthday, PDO::PARAM_STR);
$stmt->bindValue(':sellingPrice', $sellingPrice, PDO::PARAM_STR);
$stmt->bindValue(':life', $life, PDO::PARAM_STR);
$stmt->bindValue(':power', $power, PDO::PARAM_STR);
$stmt->bindValue(':durability', $durability, PDO::PARAM_STR);
$stmt->bindValue(':hit', $hit, PDO::PARAM_STR);
$stmt->bindValue(':evasion',      $evasion, PDO::PARAM_STR);
$stmt->bindValue(':intelligence', $intelligence, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header('Location:registered_monster_read.php');
exit();
