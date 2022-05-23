<?php

// DBへ接続
function ConnectToDB($dbServerAddress, $user, $pwd)
{
  $pdo = NULL;
  try {
    $pdo = new PDO($dbServerAddress, $user, $pwd);
  } catch (PDOException) {}
  return $pdo;
}

?>