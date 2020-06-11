<?php
class Model
{
    //va stoker ma connection a la base de donées
    static $connections = array();

    /* je crée une variable qui va me permettre de selectionné ma base de donner */
    public $conf = 'default';
    public $table = false;
    public $db;
    public $primaryKey = 'id';
    public $id;
    public $errors = array();
    public $form;
    public function __construct()
    {
        //j'initialise quelque variables
        if ($this->table === false) {
            $this->table = strtolower(get_class($this)) . 's';
        }

        /* je stock les info de connextion a ma base de donner
        dans une variable "&conf" */
        $conf = conf::$databasses[$this->conf];

        //je verifie si je suis deja connecter  je return
        if (isset(Model::$connections[$this->conf])) {
            $this->db = Model::$connections[$this->conf];
            return true;
        }

        try { //je demmare ma connection 

            /* je me connecte a ma base de donnée */

            $pdo = new PDO('mysql:host =' . $conf['host'] . ';dbname=' . $conf['database'] .
                ';', $conf['login'], $conf['password'], array((PDO::MYSQL_ATTR_INIT_COMMAND) => 'SET NAMES utf8'));

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            //je stock ma connections pdo 
            Model::$connections[$this->conf] = $pdo;
            $this->db = $pdo;
        } catch (PDOException $e) { //je renvoie les erreurs

            if (conf::$debug >= 1) {

                die($e->getMessage());
            } else {

                die('impossible de se Connecter a la base de donnée');
            }
        }
    }
    /* permert de chercher et recupère plusieurs entrée dans la base de donnée */
    public function find($req)
    {
        $sql = 'SELECT ';

        if (isset($req['fields'])) {
            if (is_array($req['fields'])) {
                $sql .= implode(', ', $$req['fields']);
            } else {
                $sql .= $req['fields'];
            }
        } else {
            $sql .= '*';
        }
        $sql .= ' FROM ' . $this->table . ' as ' . get_class($this) . ' ';
        //construction de la condition
        if (isset($req['conditions'])) {
            $sql .= 'WHERE ';
            if (!is_array($req['conditions'])) {
                $sql .= $req['conditions'];
            } else {
                $cond = array();
                foreach ($req['conditions'] as $k => $v) {
                    /* permet de se proteger de certaine injection html et & mysql/miramdb
                    je verifie que ces pas un chiffre */
                    if (!is_numeric($v)) {

                        /* si ces pas un chiffre mes du texte 
                        je rajoute des guilmet a la valeur de champs */
                        $v = $this->db->quote($v);
                    }

                    $cond[] = "$k=$v";
                }
                $sql .= implode(' AND ', $cond);
            }
        }
        if (isset($req['limit'])) {
            $sql .= 'LIMIT ' . $req['limit'];
        }

        $pre = $this->db->prepare($sql);
        $pre->execute();
        return $pre->fetchAll(PDO::FETCH_OBJ);
    }

    /* permet de recuperait une entrée precise dans la base de donnée */
    public function findFirst($req)
    {
        return current($this->find($req));
    }

    //cette fonction renvoit le nombre d'entrée qui aura les info demander parametre
    public function findCount($conditions)
    {
        $res = $this->findFirst(array(
            'fields' => 'COUNT(' . $this->primaryKey . ') as count',
            'conditions' => $conditions
        ));
        return $res->count;
    }
    /* Permet de supprimer des entrée dans la base de donnée */
    public function delete($id)
    {

        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} =$id";
        $this->db->query($sql);
    }

    /* Permet de sauvegarder des nouvelles entrée ou des
     modif dentée dans la base de donnée */
    public function save($data)
    {

        $key = $this->primaryKey;
        $fields = array();
        $d = array();
        if (isset($data->$key) &&  $data->$key == '') {

            unset($data->$key);
        }
        foreach ($data as $k => $v) {
            $fields[] = "$k=:$k";
            $d[":$k"] = $v;
        }

        if (isset($data->$key) && !empty($data->$key) && $data->$key != '') {
            $sql = 'UPDATE ' . $this->table . ' SET ' . implode(',', $fields) . ' WHERE ' . $key . '=:' . $key;

            $this->id = $data->$key;
            $action = 'update';
        } else {


            $sql = 'INSERT INTO ' . $this->table . ' SET ' . implode(',', $fields);
            $action = 'insert';
        }

        $pre = $this->db->prepare($sql);
        $pre->execute($d);
        if ($action == 'insert') {
            $this->id = $this->db->lastInsertId();
        }
    }
    /* Sert a valider les formulaire */
    function validates($data, $regleValidate)
    {
        $errors = array();
        foreach ($regleValidate as $k => $v) {

            if (!isset($data->$k)) {
                $errors[$k] = $v['message'];
            } else {
                if ($k == 'name' && $v['rule'] == 'notEmpty' && empty($data->$k)) {

                    $errors[$k] = $v['message'];
                } elseif ($k == 'slug' && !preg_match('/' . $v['rule'] . '$/', $data->$k)) {

                    $errors[$k] = $v['message'];
                }
            }
        }
        $this->errors = $errors;
        /* si ma variable Form est vide */
        if (isset($this->Form)) {
            /* je lui injecte les errors */
            $this->Form->errors = $errors;
        }
        if (empty($errors)) {
            return true;
        }
        return false;
    }
}
