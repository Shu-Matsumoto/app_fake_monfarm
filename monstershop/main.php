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
      <div class="monster_list_area">
        <div class="monsterList">
          <ul class="monsterListUl" id="id_monsterListUl">
            モンスターリスト
            <li class="monsterListItem">ティラノサウルス</li>
            <li class="monsterListItem">インドミナスレックス</li>
            <li class="monsterListItem">インドラプトル</li>
          </ul>
        </div>
      </div>
      <div class="monster_information_area">
        <div class="profile_disp_area">
          <ul class="profile_items">
            <li class="profile_item">
              <p class="profile_item_title">名前</p>
              <p class="profile_item_value">バルボサ</p>
            </li>
            <li class="profile_item" id="profile_birthday">
              <p class="profile_item_title">誕生日</p>
              <p class="profile_item_value">2022年/5/24日</p>
            </li>
          </ul>
        </div>
        <div class="ability_disp_area">
          <table>
            <tr class="ability_item">
              <th>ライフ:</th>
              <td id="ability_life">105</td>
            </tr>
            <tr class="ability_item">
              <th>パワー:</th>
              <td id="ability_power">16</td>
            </tr>
            <tr class="ability_item">
              <th>丈夫さ:</th>
              <td id="ability_durability">57</td>
            </tr>
            <tr class="ability_item">
              <th>命中:</th>
              <td id="ability_hit">318</td>
            </tr>
            <tr class="ability_item">
              <th>回避:</th>
              <td id="ability_evasion">328</td>
            </tr>
            <tr class="ability_item">
              <th>かしこさ:</th>
              <td id="ability_intelligence">543</td>
            </tr>
          </ul>
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
      // 指定したチャンネルのコンテンツリストを取得
      ContentProxy.GetChannelContents(channelName).then((contentsList) => {
        // 親要素
        var list = document.getElementById("id_channelContentsUl");
        // リスト初期化
        while (list.firstChild) {
          list.removeChild(list.firstChild);
        }

        //console.log(contentsList);
        contentsList.forEach((element) => {
          //console.log(element);
          // 追加するチャンネル要素を作成
          var li = document.createElement("li");
          //console.log(element);
          let string = "<tr><td><span style='color:gray'>";
          string += element[1] + " / " + element[0];
          string += "</span><br>";
          string +=
            "<p style='font-size:larger'>" + element[2] + "</p></td></tr>";
          li.innerHTML = string; //element;
          li.className = "channelContentsItem";
          // valueにlistの子要素数をセットして識別する
          li.value = list.childElementCount;
          // 末尾に追加
          list.appendChild(li);
        });
      });
    }
    </script>
  </body>
</html>