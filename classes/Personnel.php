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

    public static function get_personnel_by_id($idp){
        $res = DB::$db->prepare("SELECT * FROM personnel WHERE p_id = ?");
        $res->execute(array($idp));
        return $res->fetch();
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

    public function get_refuges(){
        $res = DB::$db->prepare("SELECT * FROM exerce e JOIN refuge r ON e.r_id = r.r_id WHERE e.p_id = ?");
        $res->execute(array($this->data["p_id"]));
        return $res->fetchAll();
    }

    public static function get_personnel($idref, $nom_complet, $fonctions, $limit = MAX_LIMIT, $offset = 0){
        $res = DB::$db->prepare("
                                SELECT DISTINCT p.p_nom, p.p_prenom, p.p_tel
                                FROM exerce e
                                JOIN fonction f ON f.fc_id = e.fc_id
                                JOIN refuge r ON r.r_id = e.r_id
                                JOIN personnel p ON p.p_id = e.p_id
                                WHERE e.r_id = ?
                                AND p.p_nom || ' ' || p.p_prenom LIKE '%' || ? || '%'
                                ".(count($fonctions) ? "AND e.fc_id IN (".implode(',', $fonctions).")" : "")."
                                ORDER BY p.p_prenom, p.p_nom
                                LIMIT ? OFFSET ?
                             ");
        $res->execute(array($idref, $nom_complet, $limit, $offset));
        //echo $res->debugDumpParams();
        return $res->fetchAll();
    }

    public static function get_fonctions(){
        return DB::$db->query("SELECT * FROM fonction;")->fetchAll();
    }

    public function exerce_in_refuge($idref): bool
    {

        $params = array_filter($this->get_refuges(), function($v, $k) use ($idref) {
            return ($v["r_id"] == $idref);
        }, ARRAY_FILTER_USE_BOTH);
        return (bool) $params;
    }

    public static function verif_exist_personnel($nom, $prenom, $num_secu, $tel){
        $res = DB::$db->prepare("
                                SELECT
                                p_id
                                FROM personnel
                                WHERE (p_tel = ? AND p_nom = ? AND p_prenom = ?)
                                OR p_num_secu = ?
        ");
        $res->execute(array($tel, $nom, $prenom, $num_secu));
        return $res->fetchAll();
    }

    public static function add_personnel($nom, $prenom, $num_secu, $tel, $adresse, $localite, $codep, $login){
        $res = DB::$db->prepare("INSERT INTO personnel
            VALUES(DEFAULT, ?, ?, ?, ?, ?, ?, ?, ?) RETURNING p_id
        ");
        $res->execute(array($nom, $prenom, $adresse, $localite, $codep, $num_secu, $tel, $login));
        return $res->fetch()["p_id"];
    }

    public static function create_logins($nom, $prenom){
        $login = substr($prenom, 0, 3);
        $login .= substr($nom, 0, 1);
        $login .= rand(0, 9).rand(0, 9).rand(0, 9);
        $mdp = hashage(generateRandomString());
        $res = DB::$db->prepare("INSERT INTO identifiant VALUES(DEFAULT, ?, ?) RETURNING id");
        $res->execute(array($login, $mdp));
        return $res->fetch()["id"];
    }

}
