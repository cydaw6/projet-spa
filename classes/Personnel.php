<?php

class Personnel
{
    public $data;
    public $identifiants;
    public static $nom_table = "personnel";

    public static function connect($login, $mdp): bool
    {
        /**
         * Renvoie true si l'utilisateur (personnel) c'est correctement
         * identifié et stocke l'instance Personnel associé
         * dans une variable session "user"
         */
        $_SESSION["user"]= null;
        $res = DB::$db->prepare("SELECT * FROM personnel NATURAL JOIN identifiant WHERE login = ?");
        $res->execute(array($login));
        $personnel = $res->fetch();
        if($personnel && password_verify($mdp, $personnel["mdp"])){
            $user = new Personnel();
            $user->data = array_slice($personnel, 0 , -2);
            $user->identifiants = array_slice($personnel, -2);
            session_start();
            $_SESSION["user"] = $user;
            return true;
        }
        return false;
    }

    public static function creer($data, $identifiants){
        /**
         * Renvoie un personnel avec les données en paramètre
         */
        $personnel = new Personnel();
        $personnel->data = array_combine(DB::db_column_names(Personnel::$nom_table), $data);
        $personnel->identifiants = array_combine(DB::db_column_names("identifiant"), $identifiants);
        return $personnel;
    }

    private static function hash_all_psswds_in_db(){
        /**
         * Attention avant d'utiliser
         * Entre conscient de ce que ça fait.
         * Cette fonction hash tous les mots de passe de la table identifiant
         */
        $res = DB::$db->query("SELECT id, mdp FROM identifiant");
        while($row = $res->fetch()){
            $hash = hashage($row["mdp"]);
            $query = DB::$db->prepare("UPDATE identifiant SET mdp = :mdp WHERE id = :id");
            $query->execute(array(':mdp' => $hash, ':id' => $row["id"]));
        }
    }





}
