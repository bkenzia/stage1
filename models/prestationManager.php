<?php
function prestation(){

    $pdo = $GLOBALS['pdo'];
    $statement = $pdo->prepare("SELECT * FROM Prestation");
   $statement->execute();

  return $statement->fetchAll();
}

function getPrestationById(int $id) {
  $pdo = $GLOBALS['pdo'];

  $sql = "SELECT * FROM Prestation WHERE prestation_id=:id;";

  $statement = $pdo->prepare($sql);
  $statement->bindValue(':id', $id);
  $statement->execute();
  return $statement->fetch();
}


function creatPrestation($post,string  $justificatif_url, $SESSION){
  $pdo = $GLOBALS['pdo'];
 [
    'adresseCollect' => $adresseCollect,
    'adresseLivraison' => $adresseLivraison,
    'nombreColect' => $nombreCollect,
    
  ] = $post;
  [
'client_id'=>$client_id,
  ]= $SESSION;
  
    

  $statement = $pdo->prepare("INSERT INTO Prestation (address_collect, address_livraison, `nombre_collect`, justificatif_url)
  VALUES(:address_collect, :address_livraison, :nombre_collect, :justificatif_url);");
  $statement->bindValue(':address_collect', htmlentities($adresseCollect));
  $statement->bindValue(':address_livraison', htmlentities($adresseLivraison));
  $statement->bindValue(':nombre_collect', htmlentities($nombreCollect));
  $statement->bindValue(':justificatif_url', htmlentities($justificatif_url));
  $statement->execute();
  $prestation_id = $pdo->lastInsertId();
  

    $stat = $pdo->prepare("INSERT INTO commander (client_id, prestation_id)
      VALUES('$client_id', '$prestation_id');");
      $stat->execute();
    
}



function suprimerPrestation(int $prestation_id): bool {
  $pdo = $GLOBALS['pdo'];

  $statement = $pdo->prepare("DELETE FROM Prestation WHERE prestation_id=:id");
  $statement->bindValue(':id', htmlentities($prestation_id));

  $sta = $pdo->prepare("DELETE FROM commander WHERE prestation_id=:id");
  $sta->bindValue(':id', htmlentities($prestation_id));
  $sta->execute();
  $starticle = $pdo->prepare("DELETE FROM Article WHERE prestation_id=:id");
  $starticle->bindValue(':id', htmlentities($prestation_id));
  $starticle->execute();
  return $statement->execute();
}

function maxIdPrestation(){

    $pdo = $GLOBALS['pdo'];
    $statement = $pdo->prepare("SELECT  prestation_id FROM  Prestation ORDER BY prestation_id DESC LIMIT 1 ; ");
   $statement->execute();

  return $statement->fetchAll();
}