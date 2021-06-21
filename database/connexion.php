<?php

try {
// le bloc de code à essayer
  global $pdo;
  $pdo = new PDO("mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}", $_ENV["DB_USER"], $_ENV["DB_PASS"],
    [
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
   
} catch (PDOException $e) {
  $twig = $GLOBALS['twig'];
  echo $twig->render('500.twig', ['page_title' => 'Erreur serveur']);
  die();
  
}