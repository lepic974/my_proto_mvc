<?php
class pagesController extends Controller
{
    /*(FR)Cette fonction apelle la vue view et prend en parametre une $id 
    (EN)Function Call view and take is parameter $id*/
    function view($id)
    {
        $this->loadModel('Post');

        /*(FR) Je crée une variable $d a qui je donne un index page qui aura comme valeur 
        une table qui contiendra le resultat renvoyer par la fonction findFirst */
        /* (EN) I create a variable $d to which I give a page index which will have as value
        a table which will contain the result returned by the findFirst function */
        $d['page'] = $this->Post->findFirst(array(
            'conditions' => array('online'=>1,'id'=>$id,'type'=>'page')
        ));

        /*(FR) Si sa return une valeur vide je precise que la page est introuvable
          (EN)  If return an empty value I specify the page cannot be found */
        if(empty($d['page']))
        {
            //(FR)J'appelle la page d'erreur dans laquelle je passe un message
            /* (EN)And I call the error page in which I pass message */
            $this->e404('page introuvable');
        }
        //(FR)J'envoie le contenu de la variable à la vue
        /*(EN) send the contents of the variable to the view */
        $this->set($d);


    }
 
    /* (FR)Permet de récupérer les pages dans la base donné pour les afficher dans le menu 
        (EN)Allows you to retrieve the pages from the given database to display them in the menu*/
        
    function getMenu()
    {
        /*(FR) Je charge le modèle 
        (EN) I load the model*/
        $this->loadModel('Post');
        /* (FR)Je récupère les pages
            (EN)I recover the pages */
        return $this->Post->find(array(
            'conditions'=>array('online'=>1,'type'=>'page')
        ));

    }
}
