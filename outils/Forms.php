<?php
/**
 * @param $post is the $_POST variable
 */
function validateForm(array $post) {
  $is_form_valid = true;
  
  $errors = [];

  // on boucle sur la variable $post qui correspond au tableau $_POST pour vérifier les champs du formulaire
  foreach ($post as $key => $value) {
    if (!$value) {
      $errors[$key] = 'ce champ ne peut pas être vide !';
      $is_form_valid = false;
    } else {
      if ($key === 'email') {
        // vérification de l'email
        if (!preg_match("/^\S+@\S+\.\S+$/", $value)) {
          $errors['email'] = "cet email n'est pas un email valide";
          $is_form_valid = false;
        }
      } elseif ($key === 'mot_de_passe') {
        // 8 caractères minimum, au moins une majuscule, au moins une minuscule, un chiffre et un caractère spécial
        if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-\/+_]).{8,}$/", $value)) {
          $errors['mot_de_passe'] = "votre mot de passe n'est pas assez sécurisé;il faut qu'il contient 8 caractères minimum, au moins une majuscule, au moins une minuscule, un chiffre et un caractère spécial";
          $is_form_valid = false;
        }
      } elseif ($key === 'postal_code') {
        // exactement 5 chiffres
        if (!preg_match("/^[0-9]{5}$/", $value)) {
          $errors['postal_code'] = "ce n'est pas un code postal valide";
          $is_form_valid = false;
        }
      }elseif($key === 'age'){
        if($value <  16){
          $errors['age'] = "votre age est infirieur à 16";
          $is_form_valid = false;

        }

      }
    }
  }
  

  return [
    'is_form_valid' => $is_form_valid,
    'errors' => $errors,
  ];
  

}