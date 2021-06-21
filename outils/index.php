<?php


// function AdminRedirect() {
  
//   if (isset($_SESSION['user']) && !isset($_SESSION['user']['est_admin']) || !isset($_SESSION['user'])){
//     header('location:/');
//   }
  
// }


function redirect() {
  // on cherche dans l'URI le mot admin
  
  if (stristr($_SERVER['REQUEST_URI'], 'admin')) {
    
    // si utilisateur en session (connecté) et utilisateur non admin OU pas d'utilisateur en session (connecté)
    if ((isset($_SESSION['user']) && !$_SESSION['user']['est_admin']) || !isset($_SESSION['user'])) {
      header('Location: /');
      
    }
    // on cherche dans l'URI le mot login
  } elseif (stristr($_SERVER['REQUEST_URI'], 'login') || stristr($_SERVER['REQUEST_URI'], 'inscription')) {
    // si on a un utilisateur en session (connecté)
    if (isset($_SESSION['user'])) {
      header('Location: /');
    }
  }
}