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

?>