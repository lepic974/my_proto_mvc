<?php
class UsersController extends Controller
{


    /**
     * Login
     * 
     */
    function login()
    {
        $this->theme = 'login_and_logout';
        /*(FR) Je verifie si ma variable data n'est pas vide 
        (EN)I check if my data variable is not empty */
        if ($this->request->data) {

            /* (FR)Je récupère les données que ma variable data contient 
             (EN)I get the data that my data variable contains*/
            $data = $this->request->data;

            /*(FR) On encode le mot de passe avec le système de cryptage sha1
            (EN) We encrypt the password with the encryption system*/
            $data->password = sha1($data->password);

            $this->loadModel('User');

            /*(FR) Je cherche l'utilisateur dans la base de données 
            (EN) I'm looking for the user in the database*/
            $user = $this->User->findFirst(array(

                'conditions' => array('login' => $data->login, 'password' => $data->password)
            ));

            /* (FR)Je vérifie que l'utilisateur n'est pas déjà enregistré dans &_SESSION
            (EN) I verify that the user is not already registered in */
            if (!empty($user)) {
                /*(FR) Si il n'est pas enregistré je le rajoute
                (EN) If it is not registered I add it */
                $this->Session->write('User', $user);
            }
            /*(FR) Et je supprime son mot de passe pour plus qu'il ne soit visible
            (EN) And I delete his password so that it is not visible */
            $this->request->data->password = '';
        }
        /*(FR) Si l'utilisateur est connecté
        (EN)If the user is logged in*/
        if ($this->Session->isLogged()) {
            /*(FR) Je vérifie si il a le rôle d'admin
            (EN)I check if he has the role of admin */
            if ($this->Session->user('role') == 'admin') {

                /*(FR)Si il a le rôle d'admin je le redirige vers la page d'administration
                (EN) If he has the role of admin I redirect him to the administration page */
                $this->redirect(conf::$admin_prefixe);
            } else {
                /*(FR) Dans le cas contraire je le redirige vers la page d'accueil 
                (EN) Otherwise I redirect it to the home page */
                $this->redirect('');
            }
        }
    }

    /**
     * Logout
     * 
     */
    function logout()
    {
        $this->theme = 'login_and_logout';
        unset($_SESSION['User']);
        $this->Session->setFlash('Vous éte déconnecté');
        $this->redirect('/');
    }

    /* (FR)Charge la page qui permet de récupèrait sont mot de passe */
    function ForgotPassword()
    {
        $this->theme = 'login_and_logout';
    }
/* (FR)Charge la page qui permet de senregistré*/
    function register()
    {
        $this->theme = 'login_and_logout';
        
    }
    /* (FR)Fonction qui permet de sauvgarder un nouvelle utilisateur */
    function newUser()
    {
        $this->loadModel('User');

        if ($this->request->data) {
            $data = $this->request->data;
            /* (FR)Encodage du mos de passe pour sauvgarde */
            $data->password = sha1($data->password);
            /*(FR)Je definit le role pardefaut des utilisateur */
            $this->request->data->role = 'user';
            
            $this->User->save($this->request->data);

            $this->redirect('users/login');
        }
    }
}
