<?php
/* Je vais crée une classe qui va me permettre de generait mais Formulaire 
function input ($non Renvoyer en Variable ,$le nom afficher sur la page en label ,$une table contenant toute les ouption voulus pour le chanps) */
class Form
{
    /* je stock le controller de la page qui apelle Form */
    public $controller;
    /* je stock les erreur Renvoyer par le Controller pour dire
     a l'utilisateur quelle Champs est mal remplie */
    public $errors;

    /* ho moment d'initialiser la class Form je demande le Controller */
    public function __construct($controller)
    {
        $this->controller = $controller;
    }
    /* Ma fonction qui va recuperait mes demand de Formulaire */
    public function input($name, $label, $options = array())
    {
        /* je crér des variable pour  gerer les erreur 
         et je leur donne une valeur par default */
        $error = false;
        $classError = '';
        /* je verifie si des erreur qui porte le nom de chanps est retourner  */
        if (isset($this->errors[$name])) {
            /* si oui de la passe a la variable $error */
            $error = $this->errors[$name];
            /* et je defini une class a ma variable */
            $classError = 'bg-danger';
        }
        /*si ma variable $name dans mon Controller est vie ou n'existe pas  */
        if (!isset($this->controller->request->data->$name)) {
            /* je defini une valeur vide a mon Champs */
            $value = '';
        } else {
            /* si non je lui donne la valeur contenue dans la Variable du Controlleur */
            $value = $this->controller->request->data->$name;
        }

        /* si le label est defini comme non visible */
        if ($label == 'hidden') {
            /* je retourne un champs non visible a la page */
            return '<input type="hidden" name="' . $name . '" value="' . $value . '">';
        }

        /* si le label est visible je la defini en lui passant tout les parametres néccessaire 
        et je la Stock dans une variable que je nome $html */
        $html = '<div class="clearfix' . $classError . '">
                    <label for="input' . $name . '">' . $label . '</label>
                <div class="input">';

        /* je crée une variable qui va contenir le String de toute mes option de champs */
        $attr = '';
        /* je parcours mon tableau d'options */
        foreach ($options as $k => $v) {
            /* si ma key est diferente de 'type */
            if ($k != 'type') {
                /* je le rajoute a ma variable $attr */
                $attr .= "$k=\"$v\"";
            }
        }
        /* si le type est vide */
        if (!isset($options['type'])) {
            /* se sera par default un champs de type texte */
            $html .= '<input type="text" id="input' . $name . '" name="' . $name . '" value="' . $value . '"' . $attr . '>';
            /* ci ces de type textarea */
        } elseif ($options['type'] == 'textarea') {
            /* Je crée un champ de type textarea */
            $html .= '<textarea id="input' . $name . '"name="' . $name . '" ' . $attr . '>' . $value . '</textarea>';
        
        } elseif ($options['type'] == 'checkbox') {

            $html .= '<input type="hidden" name="' . $name . '" value ="0"><input type="checkbox" name="' . $name . '" value="1" ' . (empty($value) ? '' : 'checked') . '>';
        
        } elseif ($options['type'] == 'password') {

            $html .= '<input type="password" name="' . $name . '" value ="0"><input type="checkbox" name="' . $name . '" value="1" ' . (empty($value) ? '' : 'checked') . '>';
        }
        /* si la variable erreur n'est pas vide */
        if ($error) {
            /* je créer une span pour afficher les erreur */
            $html .= '<span class="help-inline">' . $error . '</span>';
        }
        /* je ferme le contenue de ma variable $html par une balise div */
        $html .= ' </div>
        </div>';
        /* et je la retourne a la vue  */
        return $html;
    }
}
