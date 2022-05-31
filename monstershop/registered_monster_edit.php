<?php
include("./back/content/dataBaseCommon.php");

session_start();
// ログイン状態チェック (ログインしていない状態だとログイン画面へ遷移する)
check_session_id("../login.php");

// id受け取り
$name = $_GET['name'];

// DB接続
$pdo = ConnectToDB();

// SQL実行
$sql = 'SELECT * FROM monster_ability WHERE name=:name';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$record = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>登録済モンスター情報リスト（編集画面）</title>
  <link rel="stylesheet" href="monster_registration_form_style.css">
</head>

<body>
  <form action="registered_monster_update.php" method="POST" id="contact">
    <div class="container">
      <div class="head">  
        <fieldset>
          <legend>登録済モンスター情報リスト（編集画面）</legend>
          <a href="registered_monster_read.php">一覧画面</a>
          <a href="../logout.php">ログアウト</a>
          <div>
            名前: <input type="text" name="name" value="<?= $record['name']?>" readonly>
          </div>
          <div>
            誕生日: <input type="date" name="birthday" value="<?= $record['birthday'] ?>">
          </div>
          <div>
            売値: <input type="number" name="sellingPrice" value="<?= $record['sellingPrice'] ?>">
          </div>
          <div>
            ライフ: <input type="number" name="life" value="<?= $record['life'] ?>">
          </div>
          <div>
            パワー: <input type="number" name="power" value="<?= $record['power'] ?>">
          </div>
          <div>
            頑丈さ: <input type="number" name="durability" value="<?= $record['durability'] ?>">
          </div>
          <div>
            命中: <input type="number" name="hit" value="<?= $record['hit'] ?>">
          </div>
          <div>
            回避: <input type="number" name="evasion" value="<?= $record['evasion'] ?>">
          </div>
          <div>
            賢さ: <input type="number" name="intelligence" value="<?= $record['intelligence'] ?>">
          </div>
          <div>
            <button>submit</button>
          </div>
        </fieldset>
      </div>
    </div>
  </form>

</body>

</html>