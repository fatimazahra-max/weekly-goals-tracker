<?php

$dsn = 'mysql:host=localhost;dbname=weekly_goals';
$user = 'root';
$password = '';
try {
  $pdo = new PDO($dsn, $user, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die('Connection failed: ' . $e->getMessage());
}
