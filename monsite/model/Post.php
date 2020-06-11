<?php
class Post extends Model
{
    public $table = 'posts';
    
/* regle de validation des post  */
    var $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'message' => 'Vous devez préciser un titre'
        ),
        'slug' => array(
            'rule' => '([a-z0-9\-]+)',
            'message' => "Le slug n'est pas valide"
        )
    );
}
