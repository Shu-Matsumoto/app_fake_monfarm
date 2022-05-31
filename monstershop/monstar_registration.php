<?php
include("./back/content/dataBaseCommon.php");

session_start();
// ログイン状態チェック (ログインしていない状態だとログイン画面へ遷移する)
check_session_id("../login.php");

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

// プロフィール画像
// ファイル名をユニーク化(同じファイル名を指定されても重複させない対策)
$image = uniqid(mt_rand(), true);
// アップロードされたファイルの拡張子を取得
$image .= '.'.substr(strrchr($_FILES['profileImageUrl']['name'], '.'), 1);
$file = "images/$image";

// DB接続
$pdo = ConnectToDB();

// SQL作成&実行
// SQL作成&実行
$sql = "INSERT INTO ".
"monster_ability ".
"(name, profileImageUrl, birthday, sellingPrice, life, power, durability, hit, evasion, intelligence) ".
"VALUES (:name, :profileImageUrl, :birthday, :sellingPrice, :life, :power, :durability, :hit, :evasion, :intelligence)";

$stmt = $pdo->prepare($sql);

// バインド変数を設定
$stmt->bindValue(':name',         $name, PDO::PARAM_STR);
$stmt->bindValue(':profileImageUrl',        $image, PDO::PARAM_STR);
$stmt->bindValue(':birthday',     $birthday, PDO::PARAM_STR);
$stmt->bindValue(':sellingPrice', $sellingPrice, PDO::PARAM_STR);
$stmt->bindValue(':life',         $life, PDO::PARAM_STR);
$stmt->bindValue(':power',        $power, PDO::PARAM_STR);
$stmt->bindValue(':durability',   $durability, PDO::PARAM_STR);
$stmt->bindValue(':hit',          $hit, PDO::PARAM_STR);
$stmt->bindValue(':evasion',      $evasion, PDO::PARAM_STR);
$stmt->bindValue(':intelligence', $intelligence, PDO::PARAM_STR);

//ファイルが選択されていれば$imageにファイル名を代入
if (!empty($_FILES['profileImageUrl']['name'])) {
  
  try {

    // ファイルオープン
    $logfile = fopen("debugLog.txt", "a");

    $write_data = array($_FILES['profileImageUrl']['name'], $_FILES["profileImageUrl"]["tmp_name"], $file);
    // ファイルへデータ書込
    fputcsv($logfile, $write_data);

    // ファイルクローズ
    fclose($logfile);

    //imagesディレクトリにファイル保存
    move_uploaded_file($_FILES["profileImageUrl"]["tmp_name"], "./images/" . $image);
    
    //画像ファイルかのチェック
    if (!exif_imagetype($file)) {
      echo json_encode("画像ファイルではありません");
      exit();
    }
  } catch (PDOException $e) {
  echo json_encode(["image file upload error" => "{$e->getMessage()}"]);
  exit();
}
}

// SQL実行（実行に失敗すると `sql error ...` が出力される）
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:monstar_registration_form.php");
exit();
