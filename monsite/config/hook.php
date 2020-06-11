<?php
/* (FR) Change le Theme si on arrive sur une page admin */
/* (EN) Change the theme for the admin page */
if ($this->request->prefix == 'admin') {
    $this->theme = 'admin';

    /*(FR) Redirige toute demande vers une page admin sur le systeme de Connection
    Si la personne n'est pas Connecter
    
    (EN)Redirect any request to an admin page on the Connection system 
    If the user is not already logged in  */
    if (!$this->Session->isLogged() && $this->Session->user('role') != 'admin') {
        $this->redirect('users/login');
    }
}
