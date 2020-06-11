<?php
//je crée une class que je nome Request
class Request
{
    public $url; //URL appelé par l'utilisateur
    public $page = 1;
    public $prefix = false; /*je définit mon prefixe sur false par default */
    public $data = false;

    function __construct()
    {
        /*je recupère url trappée par l'utilisateur dans la super variable
         "_SERVER" dans la section "PATH_INFO" * si elle et pas disponible je remplace par un '/'/*/
        $this->url = isset($_SERVER['PATH_INFO'])? $_SERVER['PATH_INFO']:'/';
        
        /* PAGINATION j'ai mis sa ici mais ces passure que sa il reste permet de 
        recuperait les entrée que donne les lines de la pagination quand on clic dessus  */
        if (isset($_GET['page'])) {
            //par securité je verifie bien que ces une valeur numérique
            if (is_numeric($_GET['page'])) {
                //je verifie que la valeur reçu est superieure a zero
                if($_GET['page']> 0 ){
                    /*je fais une requete avec ces argument si tous est ok
                    je fais un petit Round par securité pour etre sur que je n'envoi pas de float   */
                    $this->page = round($_GET['page']);
                }

            }
        }
        if(!empty($_POST)){
            $this->data = new stdClass();
            foreach($_POST as $k=>$v){
                $this->data->$k=$v;
            }
        }
    }
}
