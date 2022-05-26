<?php
include("./back/content/dataBaseCommon.php");

// DB接続
$pdo = ConnectToDB();

$sql = 'SELECT * FROM monster_ability ORDER BY name ASC';

$stmt = $pdo->prepare($sql);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$output = "";
foreach ($result as $record) {
  $output .= "
    <tr>
      <td>{$record["name"]}</td>
      <td><img src='./thumbnail.php?imagePath=images/{$record["profileImageUrl"]}'></td>
      <td>{$record["birthday"]}</td>
      <td>{$record["sellingPrice"]}</td>
      <td>{$record["life"]}</td>
      <td>{$record["power"]}</td>
      <td>{$record["durability"]}</td>
      <td>{$record["hit"]}</td>
      <td>{$record["evasion"]}</td>
      <td>{$record["intelligence"]}</td>
      <td>
        <a href='registered_monster_edit.php?name={$record["name"]}'>edit</a>
      </td>
      <td>
        <a href='registered_monster_delete.php?name={$record["name"]}'>delete</a>
      </td>
    </tr>
  ";
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>登録済モンスター情報一覧</title>
</head>

<body>
  <fieldset>
    <legend>登録済モンスター情報一覧</legend>
    <a href="monstar_registration_form.php">入力画面</a>
    <table>
      <thead>
        <tr>
          <th>名前</th>
          <th>プロフィール画像</th>
          <th>誕生日</th>
          <th>売値</th>
          <th>ライフ</th>
          <th>パワー</th>
          <th>頑丈さ</th>
          <th>命中</th>
          <th>回避</th>
          <th>賢さ</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?= $output ?>
        <img src='./thumbnail.php'>
      </tbody>
    </table>
  </fieldset>
</body>

</html>