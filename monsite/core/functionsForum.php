<?php
function findUser($db,int $idUser)
{
   return $db->findFirst(array(
        'conditions'=>array('id'=>$idUser),
        'fields'=>'login,avatar,role'

    ));
    
}
