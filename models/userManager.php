<?php

function getAllUsers() {
  // requete à la base de donnée
  // ...
  // requete à la base de donnée
  // ...
  $pdo = $GLOBALS['pdo'];

  $statement = $pdo->prepare("SELECT * FROM Client");
  $statement->execute();
  
  return $statement->fetchAll();
  // on renvoie les données
  // on renvoie les données
}

function getUserByEmail($email) {
  $pdo = $GLOBALS['pdo'];

  $statement = $pdo->prepare("SELECT * FROM Client WHERE email=:email");
  $statement->bindValue(":email", htmlentities($email));
  $statement->execute();
  
  return $statement->fetch();
}

function getUserById(int $id) {
  $pdo = $GLOBALS['pdo'];
   
  $statement = $pdo->prepare("SELECT * FROM Client WHERE :client_id = $id");
  // echo var_dump($statement);
  // die();
  // $statement->bindValue(":id", htmlentities($id));
  // $statement->execute();

  return $statement->fetch();

}

function createUser(array $post) {
  $pdo = $GLOBALS['pdo'];

  [
    'Nom' => $Nom,
    'Prénom' => $Prénom,
    'Nom_de_société' => $Nom_de_société,
    'age'=>$age,
    'téléphone' => $téléphone,
    'email' => $email,
    'mot_de_passe' => $mot_de_passe,
    'koko' => $chiker,
    
  ] = $post;
  
  $hashed_password = password_hash($mot_de_passe, PASSWORD_BCRYPT, ['cost' => 14]);
  
  
  
  // on stock la requete dans une variable avec la syntaxe HEREDOC
  $sql = <<< EOT
    INSERT INTO Client
    (nom, prénom, age, email, telephone, mot_de_passe, postal_code,  ville )
    VALUES ('$Nom', '$Prénom','$age', '$email', $téléphone, '$hashed_password', '94400', 'vitry' );
  EOT;
  
  $statement=$pdo->query($sql);
  
  $user_id = $pdo->lastInsertId();
  return getUserById($user_id);
}