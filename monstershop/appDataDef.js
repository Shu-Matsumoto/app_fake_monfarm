// アプリ内データ定義
export class AppData{
  
  constructor(userName, channelName) {
    // 現在のログインユーザー
    this.CurrentLoginUser = userName;
    // 現在選択されているチャンネル名
    this.CurrentSelectedMonsterName = "";
  }
}