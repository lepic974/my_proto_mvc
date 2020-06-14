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

 

    function admin_page_index()
    {
  
        $perPage = 10;

        $this->loadModel('Post');

       /* (FR) Je définis mes conditions de recherche dans la base de données
        (EN)I define my search conditions in the database */
        $condition = array('type' => 'page');

        $d['pages'] = $this->Post->find(array(
            'fields' => 'id,name,online',
            'conditions' => $condition,
            'limit' => ($perPage * ($this->request->page - 1)) . ',' . $perPage
        ));
        /*
                            PAGINATION 
                        */
       /*(FR)  Je récupère dans la base de données les nombres d'entrées qui ont le type post
        (EN) I retrieve from the database the number of entries that have the post type */
        $d['total'] = $this->Post->findCount($condition);

        /*(FR) Je fais le calcul du nombre de poste que je répare page
        (EN) I calculate the number of positions I repair page  */
        $d['page'] = ceil($d['total'] / $perPage);

        $this->set($d);
    }

    function admin_page_edit($id = null)
    {
        $this->loadModel('Post');
        $d['id'] = '';
        /*(FR) On vérifie que notre variable objet data n'est pas vide
        (EN) We check that our data object variable is not empty  */
        if ($this->request->data) {
            
            /*(FR) On fait vérifier notre formulaire avant l'envoi dans la base de données
            (EN) We have our form checked before sending it to the database */
            if ($this->Post->validates($this->request->data, $this->Post->validate)) {
                /* PARTIE SAVE */
                $this->request->data->type = 'page' ;
                $this->request->data->created = date('Y-m-d h:i:s');
                $this->Post->save($this->request->data);
                $this->Session->setFlash('Le contenu a bien été modifié');
                $this->redirect('admin/pages/page_index');
            } else {
                /* PARTIE ERREUR VALIDATION DONNEE */
                $this->Session->setFlash('Merci de coriger vos information', 'bg-danger');
            }
        } else {

            if ($id) {
              
                $this->request->data  = $this->Post->findFirst(array(
                    'conditions' => array('id' => $id)
                ));
            }

            $d['id'] = $id;
        }

        $this->set($d);
    }
    /**
     * Permet de supprimer une page
     * @param id De la page à supprimer
     * 
     */
    function admin_delete($id)
    {

        $this->loadModel('Post');
        $this->Post->delete($id);
        $this->Session->setFlash('Le contenu a bien été supprimé');
        $this->redirect('admin/pages/page_index');
    }
    
}
