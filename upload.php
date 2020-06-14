<?php

/* (FR) INFO CONNECTION BASE DONEE CONNECTION  (EN)INFO CONNECTION DATABASE */
$conf = array(

  'host' => 'localhost', //(FR) Adresse de la base de donnée (EN)database address
  'database' => 'tuto', //(FR) Nom de la table (EN) Table Name
  'login' => 'root', //(FR)Nom utilisateur (EN)User name
  'password' => '' //Mot de passe de l'utilisateur (EN) user password
);
$table = 'medias';/* (FR)table visé (EN)Target table */
$fields = array();/*(FR)champ viser dans la table (EN)target field in the table */


/***************************************************
 * (FR) URL de base de votre serveur
 * (EN) Base URL of your serve
 ***************************************************/
$accepted_origins = array("http://localhost");

/*********************************************
 * (FR) Chemin vers le dossiers où les images sont stockées *
 * (EN) Path to the folder where the images are stored
 *********************************************/
$imageFolder = "monsite\webroot\img/";

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
  $file = array('location' => '/' . $filetowrite);

/* -----------------------------------(FR)PREPARATION DES DONNEES ET INITIALISATION DE LA CONNECTION LA BASE DE DONEE----------------------------- */
/* -----------------------------------(EN) DATA PREPARATION AND INITIALIZATION OF THE DONEE CONNECTION----------------------------- */

/* (FR) Sérialisation des info de l'image pour les sauvegarder la base données
 (EN) Serialization of image info to save the database */
  $data = array(
    'name' => $temp['name'],
    'file' => $filetowrite,
    'type' => 'img'
  );

  try {/* (FR) Si je ne suis pas connecté j'essaie de démarrer une connexion
    (EN) If I am not connected I try to start a connection */

/* (FR)Démarrage de la connexion
 (EN)Connection start */
    $pdo = new PDO('mysql:host =' . $conf['host'] . ';dbname=' . $conf['database'] .
      ';', $conf['login'], $conf['password'], array((PDO::MYSQL_ATTR_INIT_COMMAND) => 'SET NAMES utf8'));

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

  } catch (PDOException $e) {

    die('impossible de se Connecter a la base de donnée');
  
  }

/* (FR)Parcours du tableau data
(EN) Browsing the data table */
  foreach ($data as $_key => $_value) {

    $fields[] = "$_key=:$_key";/* (FR)Les clés de Vienne des champs (EN)The keys to Vienna from the fields */

    $d[":$_key"] = $_value;/* (FR) Et les value devient des valeurs à entrer dans le tableau
     (EN) And the values ​​become values ​​to enter in the array */
  }

/* (FR)Préparation de la requête SQL
 (EN)SQL query preparation */
  $sql = 'INSERT INTO ' . $table . ' SET ' . implode(',', $fields);

  $pre = $pdo->prepare($sql);
  $pre->execute($d);


  /* (FR)Je convertis le contenu de mon tableau en json 
  ( EN)I convert the content of my table to json */
  $_new_path = json_encode($file);

  /*(FR) et je fais un echo qui sera récupéré dans la vue admin_edit 
      (EN)  and I make an echo which will be retrieved in the admin_edit view*/
  echo $_new_path;
  /*   } */

} else {/* (FR) Si le fichier n'a pas été envoyé par HTTP POST  */

  /*  (FR) Je retourne une erreur 
  (EN)I return an error*/
  header("HTTP/1.1 500 Server Error");
}
