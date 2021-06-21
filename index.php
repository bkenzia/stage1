<?php

session_start();

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/env.php';

// Moteur de templates
// on instancie la class FilesystemLoader de twig en lui disant ou trouver les templates qu'on lui demandera d'envoyer
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/views');

// on déclare twig en tant que variable globale
global $twig;
$twig = new \Twig\Environment($loader, [
  'cache' => false,
]);
// on ajoute des variables globales pour nos templates twig
$twig->addGlobal('user', $_SESSION['user'] ?? false);

$uri = $_SERVER['REQUEST_URI'] !== '/' ? $_SERVER['REQUEST_URI'] : 'home';
$twig->addGlobal('active_page', $uri);

require_once __DIR__ . '/database/connexion.php';

// Router
$router = new AltoRouter();
require_once __DIR__ . '/outils/Forms.php';
require_once __DIR__ . '/outils/index.php';
require_once __DIR__ . '/models/index.php';
require_once __DIR__ . '/controllers/index.php';
require_once __DIR__ . '/routes/index.php';


// on vérifie les correspondance de routes
$match = $router->match();

redirect();
// appelle la fonction match['target'] si c'est une fonction ou envoie une 404
// echo var_dump($_POST);
// die();
if (is_array($match) && is_callable($match['target'])) {
  call_user_func_array($match['target'], $match['params']);
} else {
  // aucune route n'est trouvée
  echo $twig->render('404.twig', ['page_title' => 'Page introuvable']);
  // echo '404.twig';
}

