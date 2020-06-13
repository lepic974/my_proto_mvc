<?php

class Request
{
    /* (FR) Définition de variable
    (EN) Definition of variable */

    public $url; /* (FR) URL appeler par l'utilisateur (EN) URL to call by user */
    public $page = 1;
    public $prefix = false; /*(FR) Par défaut on considère qu'il n'y a pas de prefix dans l'URL
     (EN) By default we consider that there is no prefix in the URL */
    public $data = false;

    function __construct()
    {
        /*(FR) Je recupere URL taper par l'utilisateur
        (EN) I recover URL type by user */
        $this->url = isset($_SERVER['PATH_INFO'])? $_SERVER['PATH_INFO']:'/';
        
/* ------------------------------------PAGINATION-------------------------- */
        /* (FR) J'ai mis ça ici mais c'est pas sure que ça il reste
        (EN) I put this here but it's not sure that it remains */

        /* (FR) Si la variable $_GET contient la clé page
        (EN) If the variable $ _GET contains the page key */
        if (isset($_GET['page'])) {

           /* (FR) Par securité je verifie bien que ces une valeur numérique 
           (EN) by security I check that these numerical values */
            if (is_numeric($_GET['page'])) {

                /* (FR) je vérifie que la valeur reçu est supérieure à zéro
                (EN) I check that the value received is greater than zero */
                if($_GET['page']> 0 ){

                    $this->page = round($_GET['page']);
                }

            }
        }

        /*(FR) Si la variable $_POST existe ou n'est pas vide
        (EN) If the variable $ _POST exists or is not empty */
        if(!empty($_POST)){
            /* (FR) Je transforme data en class
            (EN) I transform data into class */
            $this->data = new stdClass();

            /* (FR) Puis je parcoure ma variable $_POST pour injecter dans mon nouvel objet data
            (EN) Then I browse my $ _POST variable to inject into my new data object */
            foreach($_POST as $_key=>$_value){

                $this->data->$_key=$_value;
            }
        }
    }
}
