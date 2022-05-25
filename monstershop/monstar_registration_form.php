<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>モンスター情報登録</title>
  </head>
  <body>
     <form action="./monstar_registration.php" method="POST" enctype="multipart/form-data">
    <fieldset>
      <legend>モンスター情報登録</legend>
      <a href="./registered_monster_read.php">一覧画面</a>
      <div>
        名前: <input type="text" name="name">
      </div>
      <div>
        プロフィール画像(16MBまで): <input type="file" name="profileImageUrl">
      </div>
      <div>
        誕生日: <input type="date" name="birthday">
      </div>
      <div>
        売値: <input type="number" name="sellingPrice">
      </div>
      <div>
        ライフ: <input type="number" name="life">
      </div>
      <div>
        パワー: <input type="number" name="power">
      </div>
      <div>
        頑丈さ: <input type="number" name="durability">
      </div>
      <div>
        命中: <input type="number" name="hit">
      </div>
      <div>
        回避: <input type="number" name="evasion">
      </div>
      <div>
        賢さ: <input type="number" name="intelligence">
      </div>
      <div>
        <button>submit</button>
      </div>
    </fieldset>
  </form>
  </body>
</html>

