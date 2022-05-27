<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>モンスターショップ</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <header></header>
    <main>
      <a href="../index.html">ホーム画面</a>
      <div class="monster_list_area">
        <div class="monsterList">
          <ul class="monsterListUl" id="id_monsterListUl">
            モンスターリスト
            <!-- <li class="monsterListItem">ティラノサウルス</li>
            <li class="monsterListItem">インドミナスレックス</li>
            <li class="monsterListItem">インドラプトル</li> -->
          </ul>
        </div>
      </div>
      <div class="monster_information_area">
        <div class="profile_disp_area">
          <ul class="profile_items" id="id_profile_items">
          </ul>
        </div>
        <div class="ability_disp_area">
          <table id="id_monster_ability_items">
        </div>
      </div>
    </main>
    <footer></footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- axiosライブラリの読み込み -->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script type="module">
      import { AppData } from "./appDataDef.js";
      import { ContentProxy } from "./monsterinformationProxy.js";

      // アプリ状態を記憶するインスタンス
      let appData = new AppData("", ""); 

      // チャンネルリストの更新
      function updateMonsterList() {
        ContentProxy.GetMonsterList().then((monsterList) => {
          // 親要素
          var list = document.getElementById("id_monsterListUl");

          for (let index = 0; index < monsterList.length; index++) {
            // 追加するチャンネル要素を作成
            var li = document.createElement("li");
            li.innerHTML = monsterList[index];
            li.className = "monsterListItem";
            // valueにlistの子要素数をセットして識別する
            li.value = list.childElementCount;
            // 末尾に追加
            list.appendChild(li);
          }
          //console.log(list);
        });
      }
      updateMonsterList();

      // モンスター名をクリックしたらそのモンスターの内容に切替
      //$(".channelListItem").on("click", function (args) {←これだと動的追加したアイテムはイベント起きない
      $(document).on("click", ".monsterListItem", function (args) {
        if (args.target.innerText == "") {
          return;
        }

        // 選択されているチャンネル名の切り替え
        appData.CurrentSelectedMonsterName = args.target.innerText;
        localStorage.setItem(
          "AppFakeMonFarmCurrentSelectedMonsterName",
          appData.CurrentSelectedMonsterName
        );

        // 表示コンテンツリフレッシュ
        updateContents(appData.CurrentSelectedMonsterName);
      });

      // コンテンツアップデート
    function updateContents(monsterName) {
      
      // データラベル
      const dataLabels = {
        name:"名前　", 
        profileImageUrl:"画像　",
        birthday:"誕生日　",
        sellingPrice:"売値　",
        life:"ライフ",
        power:"パワー",
        durability:"頑丈さ",
        hit:"命中　",
        evasion:"回避　",
        intelligence:"賢さ　"
      };

      // メーター閾値
      const meterThresholds = {
        sellingPrice:[1500,600,1000],
        life:[500,300,400],
        power:[500,300,400],
        durability:[500,300,40],
        hit:[100,60,80],
        evasion:[200,120,60],
        intelligence:[500,300,400]
      };

      // 指定したチャンネルのコンテンツリストを取得
      ContentProxy.GetMonsterInformation(monsterName).then((contentsList) => {
        // 親要素(プロフィール)
        var profileList = document.getElementById("id_profile_items");
        // リスト初期化
        while (profileList.firstChild) {
          profileList.removeChild(profileList.firstChild);
        }
        let profileString = "";

        // 親要素(能力プロフィール)
        var abilityList = document.getElementById("id_monster_ability_items");
        // リスト初期化
        while (abilityList.firstChild) {
          abilityList.removeChild(abilityList.firstChild);
        }
        let abilityString = "";

        console.log(contentsList);
        Object.keys(contentsList).forEach((key) => {
          console.log(key);

          if (key == "name" || key == "birthday"){
            profileString += "<li class='profile_item'>";
            profileString += "<p class='profile_item_title'>" + dataLabels[key] +"</p>";
            profileString += "<p class='profile_item_value'>" + contentsList[key] + "</p></li>";
          } else if(key == "profileImageUrl"){
            console.log('url("./images/' + contentsList[key] + '")');
            // 背景画像を選択されたモンスター画像に変更
            $('.monster_information_area').css({
              backgroundImage: 'url("./images/' + contentsList[key] + '")'
            });
          } else{
            abilityString += "<div class='ability_item'>";
            abilityString += "<p>" + dataLabels[key] + ":</p>";
            abilityString += "<p>" + contentsList[key] + "</p>";
            // abilityString += '<meter max="100" low="60" high="80" value="' + contentsList[key] + '"></meter></div>';
            abilityString += '<meter max="' + meterThresholds[key][0] + 
            '" low="' + meterThresholds[key][1] + '" high="' + meterThresholds[key][1] + '" value="' + contentsList[key] + '"></meter></div>';
          }
        });
        profileList.innerHTML = profileString;
        abilityList.innerHTML = abilityString;
      });
    }
    </script>
  </body>
</html>