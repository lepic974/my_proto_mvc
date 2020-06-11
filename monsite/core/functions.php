<?php
function debug($var)
{
    //si debug est superieure a zero
    if (conf::$debug > 0) {
        
        //je stock les info de la fonction debug_backtrace
        //dans la variable $debug
        $debug = (debug_backtrace());

        //je fait un echo pour afficher les info en html
        //et j'affiche le numero de la ligne a laquelle ma fonction est appellé
        echo '<p>&nbsp;</p>
        <p>
            <a  href="#">
            
                <strong>' . $debug[0]['file'] . '</strong> l.' . $debug[0]['line'] . '
            </a>
        </p>';
        /* j'affiche ici tous les fichier qui fur apeller avant mon debug  */
        echo '<ol >';
        foreach ($debug as $k => $v) {
            if ($k > 0) {
                echo '<li><strong>' . $v['file'] . '</strong>l.' . $v['line'] . '</li>';
            }
        }
        /* puis j'affiche le contenue de ma variable  */
        echo '</ol>';
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
}
