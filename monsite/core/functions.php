<?php
function debug($var)
{
   /* (FR)La fonction debug peut être appelé de n'importe où dans le projet
   (EN) The debug function can be called from anywhere in the project */
    if (conf::$debug > 0) {
        
       /* (FR)Je stock les info de la fonction debug_backtrace
       (EN) I store the info of the debug_backtrace function */
        $debug = (debug_backtrace());

      /* (FR)J'affiche en HTML le numéro de la ligne et le nom du fichier de ou l'appel a été fait
      (EN) I display in HTML the line number and the name of the file where the call was made */
        echo '<p>&nbsp;</p>
        <p>
            <a  href="#">
            
                <strong>' . $debug[0]['file'] . '</strong> l.' . $debug[0]['line'] . '
            </a>
        </p>';
        /*(FR) J'affiche par où est passé mon appel avant d'arriver à mon debug
        (EN) I post where my call went before arriving at my debug */
        echo '<ol >';
        foreach ($debug as $k => $v) {
            if ($k > 0) {
                echo '<li><strong>' . $v['file'] . '</strong>l.' . $v['line'] . '</li>';
            }
        }
        /*(FR)Pour finir on affiche le compte de la variable
        (EN) Finally we display the account of the variable */
        echo '</ol>';
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
}
