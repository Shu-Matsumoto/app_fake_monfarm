<?php

include("monsterDataBaseDef.php");

// DBへ接続
function ConnectToDB()
{
  return _connectToDB(DB_SERVER, DB_ACCESS_USER, DB_ACCESS_PWD);
}

// DBへ接続
function _connectToDB($dbServerAddress, $user, $pwd)
{
  $pdo = NULL;
  try {
    $pdo = new PDO($dbServerAddress, $user, $pwd);
  } catch (PDOException $e) {
    echo json_encode(["db error" => "{$e->getMessage()}"]);
    exit();
  }
  return $pdo;
}

// ログイン状態のチェック関数
function check_session_id($transitionPage)
{
  if (!isset($_SESSION["session_id"]) ||$_SESSION["session_id"] != session_id()) {
    header('Location:'.$transitionPage);
    exit();
  } else {
    session_regenerate_id(true);
    $_SESSION["session_id"] = session_id();
  }
}

?>