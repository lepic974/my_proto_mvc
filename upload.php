<?php

/***************************************************
 * (FR) URL de base de votre serveur
 * (EN) Base URL of your serve
 ***************************************************/
$accepted_origins = array("http://localhost");

/*********************************************
 * 
 * (FR) Chemin vers le dossiers où les images sont stockées *
 * (EN) Path to the folder where the images are stored
 * 
 *********************************************/
$imageFolder = "monsite\webroot\img/";

/*(FR) Je remets le pointeur de ma table début
    (EN) I put the pointer of my table back */

reset($_FILES);
/* (FR) Je récupère le premier élément et je stocke dans la variable $temps */
/* (EN) I get the first element and I store in the variable $temps */
$temp = current($_FILES);

/* (FR) Je vérifie que le fichier a été transmis par le HTTP POST */
/* (EN) I verify that the file was transmitted by HTTP POST*/
if (is_uploaded_file($temp['tmp_name'])) {

  /* (FR) Je verifie si TTP_ORIGIN existe ou si elle n'est pas égale à NULL
      (EN) check if TTP_ORIGIN exists or if it is not equal to NULL*/
  if (isset($_SERVER['HTTP_ORIGIN'])) {

    /* (FR)  Je vérifie que la variable de base que j'ai renseigné dans $accepted_origins
       est la même que celle dans ma variable $_SERVER['HTTP_ORIGIN'] */

    /* (EN)I check that the base variable that I entered in $ accepted_origins
       is the same as in my variable $ _SERVER ['HTTP_ORIGIN'] */
    if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {

      header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
    } else {

      header("HTTP/1.1 403 Origin Denied");
      return;
    }
  }


  /* (FR)Je vais vérifier que les extensions correspondent */
  /* (EN)I will check that the extensions match */
  if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
    header("HTTP/1.1 400 Invalid extension.");
    return;
  }

  /*(FR) Je définis le chemin où je vais enregistrer mon image et je la stock dans la variable $filetowrite*/
  /* (EN)I define the path where I will save my image and I store it in the variable $filetowrite */
  $filetowrite = $imageFolder . $temp['name'];

  move_uploaded_file($temp['tmp_name'], $filetowrite);

  /*  Je crée un nouveau tableau dans laquelle je rajoute une clé et que je nomme
     location qui aura le chemin vers mon image.*/

  /* (EN)I create a new table in which I add a key and which I name
     location which will have the way to my image. */
  $_new_path = array('location' => '/' . $filetowrite);

  /* (FR)Je convertis le contenu de mon tableau en json 
  (EN)I convert the content of my table to json */
  $_new_path = json_encode($_new_path);

  /*(FR) et je fais un echo qui sera récupéré dans la vue admin_edit 
  (EN)  and I make an echo which will be retrieved in the admin_edit view*/
  echo $_new_path;
} else {/* (FR) Si le fichier n'a pas été envoyé par HTTP POST  */

  /*  (FR) Je retourne une erreur 
  (EN)I return an error*/
  header("HTTP/1.1 500 Server Error");
}
