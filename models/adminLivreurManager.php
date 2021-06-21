<?php


function Livreur(){

    $pdo = $GLOBALS['pdo'];
    $statement = $pdo->prepare("SELECT * FROM Client WHERE est_livreur =TRUE");
   $statement->execute();
  return $statement->fetchAll();
}

function getLivreurById(int $id) {
  $pdo = $GLOBALS['pdo'];

  $sql = "SELECT * FROM Client WHERE client_id=:id;";

  $statement = $pdo->prepare($sql);
  $statement->bindValue(':id', $id);
  $statement->execute();
  return $statement->fetch();
}




function creatLivreur($post){
  $pdo = $GLOBALS['pdo'];
 [
    'nom' => $nom,
    'prenom' => $prenom,
    'livreu_id' => $livreur_id,
    'mot_de_passe' => $mot_de_passe,
    'livreur' => $livreur,
    'age' => $age,
    'telephone' => $telephone,
    
  ] = $post;
  
  $age = (string) $age;
   $telephone= (string)$telephone; 

  $statement = $pdo->prepare("INSERT INTO Client (nom, prénom, age, email, telephone, mot_de_passe, est_livreur, postal_code, ville)
  VALUES(:nom, :prenom, :age, :email, :telephone, :mot_de_passe, TRUE, '94400', 'vitry');");

  $statement->bindValue(':nom', htmlentities($nom));
  $statement->bindValue(':prenom', htmlentities($prenom));
  $statement->bindValue(':age', htmlentities($age));
  $statement->bindValue(':telephone', htmlentities($telephone));
  $statement->bindValue(':email', htmlentities($livreur_id));
  $statement->bindValue(':mot_de_passe', htmlentities($mot_de_passe));

  $statement->execute();
  $livreur_id = $pdo->lastInsertId();
   $stat = $pdo->prepare("INSERT INTO Livreur (client_id )
  VALUES($livreur_id);");
  $stat->execute();

}


function suprimerLivreur(int $client_id): bool {
  $pdo = $GLOBALS['pdo'];
  
  $statement = $pdo->prepare("DELETE FROM Client WHERE client_id=:id");
  $statement->bindValue(':id', htmlentities($client_id));

  // $sta = $pdo->prepare("DELETE FROM commander WHERE prestation_id=:id");
  // $sta->bindValue(':id', htmlentities($prestation_id));
  // $sta->execute();
  return $statement->execute();
}


function ajouterPlanning(int $client_id): bool {
  $pdo = $GLOBALS['pdo'];

  $statement = $pdo->prepare("UPDATE Livreur SET planning = 'test' WHERE client_id=$client_id");
 

  
  return $statement->execute();
}
