<?php
//je crée une class que je nome Router
class Router
{
    //je crée une table routes qui va contenir les different informations 
    //sur les routes que je vais utiliser 
    static $routes = array();

    /* Variables qui va contenir tous les prefixe que peut gerer mon router */
    static $prefixes = array();

    static function prefix($url, $prefix)
    {
        /*je stock dans $prefixes a la key qui aura le nom que l'url entrée le $prefix */
        self::$prefixes[$url] = $prefix;
    }


    /* je declare cette function en static pour pouvoir l'appeller de n'importe ou sans avoir a l'initialiser  */
    /**
     * Permet de passer une url
     * @param $url Url a passer
     * @param la requette url
     * @return une table contenant les paramétres
     **/
    static function parse($url, $request)
    {
        /* je retire "/"  au debut et a la fin l'url grace a la function trim() */
        $url = trim($url, '/');

        /*je verifie si l'url est vide*/
        if (empty($url)) {
            /*si elle est vide je lui donne l'url original presente dans la variable  $routes du Router*/
            $url = Router::$routes[0]['url'];
        } else {/*si elle n'est pas vide*/
            $match = false;
            /*je parcours la variable $routes */
            foreach (Router::$routes as $v) {
                /*je verifie si mon url correspont a une de mes regle contenue dans mon catcher de ma variable $routes*/


                if (!$match && preg_match($v['redirreg'], $url, $match)) {

                    $url = $v['origin'];

                    foreach ($match as $k => $v) {
                        /*je recupère la key contenue dans $v  */
                        $url = str_replace(':' . $k . ':', $v, $url);
                    }

                    $match = true;
                }
            }
        }


        /*Partie executer seulement si l'url est vide */




        //je fais un explode pour séparer les element de mon url separer par l'anti slach
        $params = explode('/', $url);

        /*Partie qui va verifier si il y'a un prefix dans l'url */

        /*je verifie que la valeur de l'élement zero de la table $params a le meme nom
        que la key contenu dans mes prefixes */
        if (in_array($params[0], array_keys(self::$prefixes))) {

            /*si elle a le meme non  je dit que le prefix contenu dans $request est egale
            au prefixe contenu dans $prefixes a key du meme non contenu
            dans la valeur zero de notre table parametres */
            $request->prefix = self::$prefixes[$params[0]];
            //j'utilise la function array_shift pour caller mon tableau d'un cran
            array_shift($params);
        }

        /* je crée dans request une variable controller ,action & parametres pour contenir les different info de mon url  */
        $request->controller = $params[0];
        //je fait un terre mais pour definir l'action car sa peux arriver que notre url ne renvoi pas de seconde paramettre
        $request->action = isset($params[1]) ? $params[1] : 'index';
        foreach (self::$prefixes as $k => $v) {
            if (strpos($request->action, $v . '_') === 0) {
                $request->prefix = $v;
                $request->action = str_replace($v . '_', '', $request->action);
            }
        }

        /*je vais crée une entrée que je vais nomer "params" et stocker
        le reste de l'url en sortent les deux premier element grace a la fonction "array_slice" */

        $request->params = array_slice($params, 2);
        /* si il y'a minimum un parametre d'entrée dans l'url*/
        if (count($request->params) >= 1) {
            /* je definit une table qui sera une table */
            $params = array();
            /* je parcours la table params qui se trouve dans request */
            foreach ($request->params as $k => $v) {
                /* je recupère les elements qui se trouve avant ou après ':' */
                $t = explode(':', $request->params[$k]);
                /* et je les stock dans ma table $param */
                $params[$t[0]] = $t[1];
            }
            /* puis je refinit ma table params de request avec ces info trié et structurai */
            $request->params = $params;
        }


        return true;
    }

    /**
     * Connect
     * @param la redirection
     * @param l'url de base
     **/
    static function connect($redir, $url)
    {
        $r = array();
        $r['params'] = array();
        $r['url'] = $url;


        $r['originreg'] = preg_replace('/([a-z0-9]+):([^\/]+)/', '${1}:(?P<${1}>${2})', $url); /* ok */
        $r['originreg'] = str_replace('/*', '(?P<args>/?.*)', $r['originreg']);
        $r['originreg'] = '/^' . str_replace('/', '\/', $r['originreg']) . '$/';
        /* MODIF */
        $r['origin'] = preg_replace('/([a-z0-9]+):([^\/]+)/', '${1}:', $url);
        $r['origin'] = str_replace('/*', ':args:', $r['origin']);

        $params = explode('/', $url);
        foreach ($params as $k => $v) {
            if (strpos($v, ':')) {
                $p = explode(':', $v);
                $r['params'][$p[0]] = $p[1];
            }
        }

        $r['redirreg'] = $redir;
        $r['redirreg'] = str_replace('/*', '(?P<args>/?.*)', $r['redirreg']);

        foreach ($r['params'] as $k => $v) {
            $r['redirreg'] = str_replace(":$k", "(?P<$k>$v)", $r['redirreg']);
        }
        $r['redirreg'] = '/^' . str_replace('/', '\/', $r['redirreg']) . '$/';
        $r['redir'] = preg_replace('/:([a-z0-9]+)/', '${1}:', $redir);
        $r['redir'] = str_replace('/*', ':args:', $r['redir']);
        self::$routes[] = $r;
    }

    /**
     * Permet de générer une url a partir d'une url originale
     * controller/action(/:param/:param/:param...)
     **/
    static function url($url = '')
    {

        trim($url, '/');
        //je parcours mes routes
        foreach (self::$routes as $v) {
            //je verfie quand dans mes routes il y'a une expression reguliere
         
            //qui match a url entrée et je le stock dans la table $match
            if (preg_match($v['originreg'], $url,  $match)) {
                $url = $v['redir'];
                //je parcours les valeur renvoyer par preg_match
                foreach ($match as $k => $w) {
                    $url = str_replace(":$k:", $w, $url);
                }
            }
        }
        //permet de remplacer le prefixe dans l'url
        foreach (self::$prefixes as $k => $v) {
            if (strpos($url, $v) === 0) {

                $url = str_replace($v, $k, $url);
            }
        }

        return (BASE_URL . '/' . $url);
    }
    static function webroot($url)
    {
        trim($url, '/');
        return BASE_URL . '/' . $url;
    }
}
