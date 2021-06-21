<?php

function getHome() {
  $twig = $GLOBALS['twig'];
  
  // logique serveur...
  // ici on peut faire appelle au model pour recuperer des données provenant de la base de données
  $users = getAllUsers();

  // envoie de la vue
  echo $twig->render('Acceuil.twig', [
    // paramètres diponibles dans le template
    'users' => $users,
  ]);
}

function redirectClient() {
  header('Location: /client/prestation');
}

function getInscription() {
  $twig = $GLOBALS['twig'];
  
  // logique serveur...
  // ici on peut faire appelle au model pour recuperer des données provenant de la base de données
  $users = getAllUsers();

  // envoie de la vue
  echo $twig->render('inscription.twig', [
    // paramètres diponibles dans le template
    'users' => $users,
    'page_title' => "Inscription",
  ]);
}



function postInscription() {
  $twig = $GLOBALS['twig'];
 
  [
    'is_form_valid' => $is_form_valid,
    'errors' => $errors,
  ] = validateForm($_POST);
    // echo var_dump($errors);
    // die();
    [
    'email' => $email,
    'mot_de_passe' => $password,
    'Nom'=>$Nom,
    'Prénom'=>$Prénom,
    'Nom_de_société'=>$Nom_de_société,
    'age'=>$age,
    
    'téléphone'=>$téléphone,
    'confirm_email'=>$confirm_email,
    'mot_de_passe'=>$mot_de_passe,
    'confirm_password'=>$confirm_password,
    
  ] = $_POST;
      $known_user= getUserByEmail($email);
  if ($is_form_valid and empty($known_user) ) {
    if ($_POST['mot_de_passe'] === $_POST['confirm_password'] & $_POST['email'] === $_POST['confirm_email']) {
      createUser($_POST);
      header('Location: /connexion');
      return;
    } else {
      $errors['password_match'] = 'Les mots de passes ne sont pas identiques';
      $errors['email_match'] = 'Les emails ne sont pas identiques';
    }
  }else{
    $errors['email'] = 'l\'email existe déja';
  }
  
  echo $twig->render('inscription.twig', [
    'errors' => $errors,

    'fields' => $_POST,
    'page_title' => "Inscription",
    
  ]);
  
}

function getConnexion() {
  $twig = $GLOBALS['twig'];
  
  // logique serveur...
  // ici on peut faire appelle au model pour recuperer des données provenant de la base de données
  $users = getAllUsers();

  // envoie de la vue
  echo $twig->render('connexion.twig', [
    // paramètres diponibles dans le template
    'users' => $users,
    'page_title' => "Connection",
  ]);
}

function postConnexion() {
  $twig = $GLOBALS['twig'];

  [
    'is_form_valid' => $is_form_valid,
    'errors' => $errors,
  ] = validateForm($_POST);

  // on récupère les données du formulaire
  [
    'email' => $email,
    'mot_de_passe' => $password,
    'Utilisateur'=>$Utilisateur,
  ] = $_POST;

  if ($is_form_valid) {

    // on fait appelle à la fonction getUserByMail() de notre userManager pour chercher un utilisateur par son email
    //! dans le modele MVC on ne mélange pas les responsabilitées
    $known_user = getUserByEmail($email);
    

    if ($known_user && password_verify($password, $known_user['mot_de_passe'])) {
      $_SESSION['user'] = $known_user;
      header('Location: /');
      return;
    } else {
      $errors['not_found'] = "email ou mot de passe incorrect";
    }
  }

  echo $twig->render('connexion.twig', [
    'email' => $email,
    'mot_de_passe' => $password,
    'errors' => $errors,
    'Utilisateur'=>$Utilisateur,
    'connexion_page' => true,
    'page_title' => "Connexion",
    'button_text' => 'Se connecter',
    
  ]);
}

function postLogout() {
  unset($_SESSION['user']);
  header("Location: /");
}
// echo var_dump($_POST);
// die();

function getPrestation() {
  $twig = $GLOBALS['twig'];
  $prestation=prestation();
   
  // logique serveur...
  // ici on peut faire appelle au model pour recuperer des données provenant de la base de données
  $users = getAllUsers();

  // envoie de la vue
  echo $twig->render('./client/prestation.twig', [
    // paramètres diponibles dans le template
    'users' => $users,
    'prestation'=>$prestation,
    'page_title' => "Prestation",
  ]);
}

function getAddPrestation() {
  $twig = $GLOBALS['twig'];
  
  // logique serveur...
  // ici on peut faire appelle au model pour recuperer des données provenant de la base de données
  $users = getAllUsers();

  // envoie de la vue
  echo $twig->render('./client/add_prestation.twig', [
    // paramètres diponibles dans le template
    'users' => $users,
    'page_title' => "Prestation",
  ]);
}
function postAddPrestation() {
  $twig = $GLOBALS['twig'];
  [
    'is_form_valid' => $is_form_valid,
    'errors' => $errors,
  ] = validateForm($_POST);
  

  $is_file_uploaded = false;

  ['file' => $file] = $_FILES;
  

  if ($file['error'] === UPLOAD_ERR_OK) {
    $allowed_file_types = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];

    [
      'name' => $file_name_with_extension,
      'tmp_name' => $file_tmp_name,
    ] = $file;

    [
      'filename' => $file_name,
      'extension' => $file_extension,
    ] = pathinfo($file_name_with_extension);

    if (in_array($file_extension, $allowed_file_types)) {
      $destination_folder = "/public/uploads/prestation";
      $destination = dirname(__DIR__) . $destination_folder;

      if (!is_dir($destination)) {
        mkdir($destination, 0777, true);
      }

      $new_filename = md5($file_name) . '-' . time() . ".$file_extension";

      // deplacer l'image
      $is_file_uploaded = move_uploaded_file($file_tmp_name, "$destination/$new_filename");
    }

  } elseif ($file['error'] === UPLOAD_ERR_NO_FILE) {
    echo "Pas de fichier envoyée !";
  }

    if ($is_form_valid && $is_file_uploaded ) {

      $image_path = "$destination_folder/$new_filename";
      creatPrestation($_POST,$image_path, $_SESSION['user']);

      // $product = createOrUpdateProduct($_POST, $image_path, $product_id ?? false);

      header('location: /client/prestation');
    }

    echo $twig->render('Add-prestation.twig', [
    
    'page_title' => "Add-prestation",
     'errors' => $errors,
    
    
  ]);
}

function suprimerClientPrestation(int $prestation_id) {
  
  if ($prestation_id) {
    
    suprimerPrestation($prestation_id);
  }

  header('Location: /client/prestation');
}



function getProduit() {
  $twig = $GLOBALS['twig'];
  $produit=produit();
   
  // logique serveur...
  // ici on peut faire appelle au model pour recuperer des données provenant de la base de données
  $users = getAllUsers();

  // envoie de la vue
  echo $twig->render('./client/produit.twig', [
    // paramètres diponibles dans le template
    'users' => $users,
    'produit'=>$produit,
    'page_title' => "Produits",
  ]);
}

function getAddProduit() {
  $twig = $GLOBALS['twig'];
  
  // logique serveur...
  // ici on peut faire appelle au model pour recuperer des données provenant de la base de données
  $users = getAllUsers();

  // envoie de la vue
  echo $twig->render('./client/add_produit.twig', [
    // paramètres diponibles dans le template
    'users' => $users,
    'page_title' => "Produit",
  ]);
}


function postAddProduit() {
  $twig = $GLOBALS['twig'];
  [
    'is_form_valid' => $is_form_valid,
    'errors' => $errors,
  ] = validateForm($_POST);
  
    if ($is_form_valid  ) {

      
      creatProduit($_POST);

      // $product = createOrUpdateProduct($_POST, $image_path, $product_id ?? false);

      header('location: /client/produit');
    }

  echo $twig->render('Add-produit.twig', [
    
    'page_title' => "Add-prestation",
     'errors' => $errors,
    
    
  ]);
}


function suprimerClientProduit(int $article_id) {
  
  if ($article_id) {
    
    suprimerProduit($article_id);
  }

  header('Location: /client/produit');
}



function redirectAdmin() {
  header('Location: /admin/livreur');
}

function getLivreur() {
  $twig = $GLOBALS['twig'];
  $livreur=Livreur();
  
  // logique serveur...
  // ici on peut faire appelle au model pour recuperer des données provenant de la base de données
  $users = getAllUsers();
  
  // envoie de la vue
  echo $twig->render('/admin/adminLivreur.twig', [
    // paramètres diponibles dans le template
    'users' => $users,
    'livreur'=>$livreur,
    'page_title' => "Livreur",
  ]);
}

function getAddLivreur() {
  $twig = $GLOBALS['twig'];
  redirect();
  
  // logique serveur...
  // ici on peut faire appelle au model pour recuperer des données provenant de la base de données
  $users = getAllUsers();

  // envoie de la vue
  echo $twig->render('/admin/adminAddLivreur.twig', [
    // paramètres diponibles dans le template
    'users' => $users,
    'page_title' => "Livreur",
  ]);
}

function postAddLivreur() {
  redirect();
  $twig = $GLOBALS['twig'];
  [
    'is_form_valid' => $is_form_valid,
    'errors' => $errors,
  ] = validateForm($_POST);
  
    if ($is_form_valid  ) {

      
      creatLivreur($_POST);

      // $product = createOrUpdateProduct($_POST, $image_path, $product_id ?? false);

      header('location: /admin/livreur');
    }

    echo $twig->render('./admin/adminAddLivreur.twig', [
    
    'page_title' => "Add-livreur",
    'errors' => $errors,
    
    
  ]);
}



function suprimerAdminLivreur(int $client_id) {
  
  
  if ($client_id) {
    
    suprimerLivreur($client_id);

  }

  header('Location: /admin/livreur');
}



function getPlanning() {
  $twig = $GLOBALS['twig'];
  // $livreur=Livreur();
  
  // logique serveur...
  // ici on peut faire appelle au model pour recuperer des données provenant de la base de données
  $users = getAllUsers();
  
  // envoie de la vue
  echo $twig->render('/admin/adminPlanningLivreur.twig', [
    // paramètres diponibles dans le template
    'users' => $users,
    
    'page_title' => "Planning",
  ]);
}

function getAdminPrestation() {
  $twig = $GLOBALS['twig'];
  $prestation=prestation();
   $produit=produit();
  // logique serveur...
  // ici on peut faire appelle au model pour recuperer des données provenant de la base de données
  $users = getAllUsers();

  // envoie de la vue
  echo $twig->render('./admin/adminPrestation.twig', [
    // paramètres diponibles dans le template
    'users' => $users,
    'prestation'=>$prestation,
    'produit'=>$produit,
    'page_title' => "Prestation",
  ]);
}

// function ajouterPlanningLivreur(int $client_id) {
  
  
//   if ($client_id) {
    
//     ajouterPlanning($client_id);

//   }

//   header('Location: /admin/planning');
// }

