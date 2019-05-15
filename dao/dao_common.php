<?php
function getcConectDb() {
  try {
    $pdo = new PDO(DSN,DB_USER,DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
  } catch (PDOException $e) {
    echo $e->getMessage();
    exit;
  }
  return connectDb();
}
?>