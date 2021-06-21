<?php

$router->map('GET', '/', 'getHome');
$router->map('GET', '/inscription', 'getInscription');
$router->map('POST', '/inscription', 'postInscription');


$router->map('GET', '/connexion', 'getConnexion');
$router->map('POST', '/connexion', 'postConnexion');
$router->map('GET', '/logout', 'postLogout');


$router->map('GET', '/client/prestation', 'getPrestation');
$router->map('GET', '/client/prestation/add_prestation', 'getAddPrestation');
$router->map('POST', '/client/prestation/add_prestation', 'postAddPrestation');
$router->map('POST', '/client/prestation/suprimer[i:prestation_id]', 'suprimerClientPrestation');

// $router->map('GET', '/client', 'getClient');
$router->map('GET', '/client', 'redirectClient');


$router->map('GET', '/client/produit', 'getProduit');
$router->map('GET', '/client/produit/add_produit', 'getAddProduit');
$router->map('POST', '/client/produit/add_produit', 'postAddProduit');
$router->map('POST', '/client/produit/suprimer[i:article_id]', 'suprimerClientProduit');


// $router->map('GET', '/admin', 'getAdmin');
$router->map('GET', '/admin', 'redirectAdmin');

$router->map('GET', '/admin/livreur', 'getLivreur');
$router->map('GET', '/admin/livreur/add_livreur', 'getAddLivreur');
$router->map('POST', '/admin/livreur/add_livreur', 'postAddLivreur');
$router->map('POST', '/admin/livreur/suprimer[i:client_id]', 'suprimerAdminLivreur');
// $router->map('POST', '/admin/planning[i:client_id]', 'ajouterPlanningLivreur');
// echo var_dump($_SERVER['REQUEST_URI']);
// die();
// $router->map('POST', '/admin/planning[i:client_id]', 'postPlanning');
$router->map('GET', '/admin/planning', 'getPlanning');
$router->map('GET', '/admin/prestation', 'getAdminPrestation');

