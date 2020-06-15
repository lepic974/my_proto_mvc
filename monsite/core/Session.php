<?php

class Session
{
    function __construct()
    {
        /* si la variable ssesion n'est pas encore initialiser  */
        if (!isset($_SESSION)) {
            /* je demarre une session  */
            session_start();
        }
    }
    /**
     * Permet definir des info pour ensuite les afficher sur la vue pour 
     * recuperait dune info de session ou d'une action en cours ou une erreur
     * @param string message
     * @param string type (non obligatoire) 
     */
    function setFlash($message, $type = 'bg-success')
    {
        $_SESSION['flash'] = array(
            'message' => $message,
            'type' => $type
        );
    }

/* *
*Fonction a placer dans sa vu pour voir les message de type flach
 */
    public function flash()
    {

        if (isset($_SESSION['flash']['message'])) {
            $html = '<div class="alert-message ' . $_SESSION['flash']['type'] . ' text-white "><p>' . $_SESSION['flash']['message'] . '</p></div>';
            $_SESSION['flash'] = array();
            return $html;
        }
    }
    /* Permet de sotker un user et ces info dans la variable $_SESSION */
    public function write($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    /* permet de recuperait les info dun utilisateur ou le contenu de la variable
    $_SESSION */
    public function read($key = null)
    {
        if ($key) {
            if (isset($_SESSION[$key])) {
                return $_SESSION;
            } else {
                return false;
            }
        } else {
            return $_SESSION;
        }

    }
    /* si l'utilisateur est deja connecter permet de recuperait son role */
    public function isLogged()
    {
        return isset($_SESSION['User']->role);
    }
    /**
     * @param string User
     * @return bool
     *   permet de savoir si un utilisateur et connecter si n'est pas connecter renvoi false 
     * */
    public function user($key)
    {
        if ($this->read('User')) {

            $user_key = $this->read('User');

            if (isset($user_key[$key])) {

                return$user_key[$key];

            }else{

                return false;
            }
        }
        return false;
    }
}
