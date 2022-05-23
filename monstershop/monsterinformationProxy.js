import { SERVER_URL, SCRIPT_PATH } from "./back/serverDefine.js";

export class ContentProxy {

  // モンスターリスト取得
  static async GetMonsterList() {

    // awaitしないと正常に戻り値が返らない
    let result = await axios.post(SERVER_URL + SCRIPT_PATH + "getMonsterList.php", null);
    //console.log(result.data.channelList);
    return result.data.monsterList;
  }

  // チャンネルの内容取得
  // channelName:チャンネルネーム
  static async GetMonsterInformation(monsterName) {

    let params = new URLSearchParams();
    params.append("monsterName", monsterName);
    
    // awaitしないと正常に戻り値が返らない
    let result = await axios.post(SERVER_URL + SCRIPT_PATH + "getMonsterInformation.php", params)
    //console.log(result.data);
    return result.data.contentsArray;
  }

}