<?php
function produit(){

    $pdo = $GLOBALS['pdo'];
    $statement = $pdo->prepare("SELECT * FROM Article");
   $statement->execute();

  return $statement->fetchAll();
}

function getProduitById(int $id) {
  $pdo = $GLOBALS['pdo'];

  $sql = "SELECT * FROM Article WHERE article_id=:id;";

  $statement = $pdo->prepare($sql);
  $statement->bindValue(':id', $id);
  $statement->execute();
  return $statement->fetch();
}

function creatProduit($post){
  $pdo = $GLOBALS['pdo'];
 [
    'nom' => $nom,
    'fragilité' => $fragilité,
    'températeur' => $températeur,
    'volum' => $volum,
    'description' => $description,
    
  ] = $post;
  if($fragilité==='oui'){
    $fragilit=1;

  }else{
    $fragilit=0;
  }
  

  if($températeur==='oui'){
    $temp=1;

  }else{
    $temp=0;
  }
  $stat = maxIdPrestation()[0]["prestation_id"];
  
    

  $statement = $pdo->prepare("INSERT INTO Article (nom, description, `est_fragile`, est_temperatures, volum, prestation_id)
  VALUES(:nom, :description, :est_fragile, :est_temperateur, :volum,  $stat);");
  $statement->bindValue(':nom', htmlentities($nom));
  $statement->bindValue(':description', htmlentities($description));
  $statement->bindValue(':est_fragile', htmlentities($fragilit));
  $statement->bindValue(':est_temperateur', htmlentities($temp));
  $statement->bindValue(':volum', htmlentities($volum));
  $statement->execute();
//   $prestation_id = $pdo->lastInsertId();
  

    

}

function suprimerProduit(int $article_id): bool {
  
  $pdo = $GLOBALS['pdo'];

  $statement = $pdo->prepare("DELETE FROM Article WHERE article_id=:id");
  $statement->bindValue(':id', htmlentities($article_id));
  
  // $sta = $pdo->prepare("DELETE FROM commander WHERE prestation_id=:id");
  // $sta->bindValue(':id', htmlentities($prestation_id));
  // $sta->execute();
  return $statement->execute();
}