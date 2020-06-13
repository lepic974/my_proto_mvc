<?php
/*(FR) Class qui permet de générer des formulaires
(EN) Class that generates forms*/
class Form
{
    /*(FR) Déclaration de variable */
    public $controller;// (FR)Contiendra le contrôleur qui appelle la classe forme (EN) Will contain the controller that calls the form class

    public $errors; //(FR)Contiendra les erreurs envoyer par le contrôleur si le champs est mal rempli 
                    //(EN) Will contain the errors sent by the controller if the field is incorrectly filled

    /**
     * (FR) Le constructeur prend le contrôleur en paramètre
      *(EN)  The construct takes the controller as a parameter
      *@param Controller    */
    public function __construct($controller)
    {
        $this->controller = $controller;
    }
    /**
     * (FR)
     * @param string Nom de l'entrée
     * @param string Texte affiché dans le label
     * @param array Les options volume pour le champs */
    public function input($name, $label, $options = array())
    {
        /* (FR)On donne une valeur par défaut au variable 
       (EN) We give a default value to the variable */
        $error = false;
        $classError = '';

        /* (FR) On vérifie c'est des erreurs ont été retourné par le contrôleur
        (EN)  We check it is errors were returned by the controller */
        if (isset($this->errors[$name])) {

            /*(FR) On récupère les erreurs
            (EN) We recover the errors */
            $error = $this->errors[$name];

            /*(FR) On définit la classe bg-danger Pour notre Input HTML 
            (EN) We define the class bg-danger For our HTML Input */
            $classError = 'bg-danger';
        }
        /* (FR) On vérifie dans notre variable data que la variable name n'est pas vide
        (EN) We check in our data variable that the name variable is not empty */
        if (!isset($this->controller->request->data->$name)) {

            $value = '';//(FR) Si elle est vide la variable value sera vide aussi (EN) If it is empty the value variable will be empty too

        } else {

            $value = $this->controller->request->data->$name;
        }

        /* (FR)Si le label est égal a hidden 
        (EN) If the label is equal to hidden */
        if ($label == 'hidden') {

            /* (FR) Dans ce cas je retourne un champ non visible à ma vue
            (EN) In this case I return a field not visible to my view */
            return '<input type="hidden" name="' . $name . '" value="' . $value . '">';
        }

        /*(FR) On crée un label avec les infos récupérer
        (EN) We create a label with the information to recover */
        $html = '<div class="clearfix' . $classError . '">
                    <label for="input' . $name . '">' . $label . '</label>
                <div class="input">';

        /*(FR) Cette variable va contenir toutes les options de mon champ
        (EN) This variable will contain all the options of my field */
        $attr = '';

        /*(FR) Je parcours le tableau qui contient les options
        (EN) I browse the table which contains the options */
        foreach ($options as $_key => $_value) {
            if ($_key != 'type') {

                $attr .= "$_key=\"$_value\"";
            }
        }
        /*(FR) Si le type n'est pas défini
        (EN) If the type is not defined */
        if (!isset($options['type'])) {

            /* (FR) Ce sera par défaut un champ de type text
            (EN) By default, it will be a text field */
            $html .= '<input type="text" id="input' . $name . '" name="' . $name . '" value="' . $value . '"' . $attr . '>';

     
        } elseif ($options['type'] == 'textarea') {

            $html .= '<textarea id="input' . $name . '"name="' . $name . '" ' . $attr . '>' . $value . '</textarea>';
        
        } elseif ($options['type'] == 'checkbox') {

            $html .= '<input type="hidden" name="' . $name . '" value ="0"><input type="checkbox" name="' . $name . '" value="1" ' . (empty($value) ? '' : 'checked') . '>';
        
        } elseif ($options['type'] == 'password') {

            $html .= '<input type="password" name="' . $name . '" value ="0"><input type="checkbox" name="' . $name . '" value="1" ' . (empty($value) ? '' : 'checked') . '>';
        }
        /* (FR) Si la variable n'est pas vide 
        (EN) If the variable is not empty */
        if ($error) {
        
            /* (FR) On ajoute les erreurs
            (EN) We add the errors */
            $html .= '<span class="help-inline">' . $error . '</span>';
        }
        
        /* (FR) Je ferme les div dans mon texte HTML
        (EN) I close the divs in my HTML text */
        $html .= ' </div>
        </div>';
        
        /* (FR) On retourne le contenu à la vue
        (FR) We return the content to view  */
        return $html;
    }
}
