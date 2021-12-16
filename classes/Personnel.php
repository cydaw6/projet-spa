<?php

class Personnel
{
    public $data;
    public $identifiants;
    public static $nom_table = "personnel";

    /**
    * Renvoie true si l'utilisateur (personnel) c'est correctement
    * identifié et stocke l'instance Personnel associé
    * dans une variable session "user"
    */
    public static function connect($login, $mdp): bool
    {
        
        $_SESSION["user"]= null;
        $cnx = DB::$db->prepare("SELECT * FROM personnel NATURAL JOIN identifiant WHERE login = ?");
        $cnx->execute(array($login));
        $personnel = $cnx->fetch();
        if($personnel && password_verify($mdp, $personnel["mdp"])){
            $user = new Personnel();
            $user->data = array_slice($personnel, 0 , -2);
            $user->identifiants = array_slice($personnel, -2);
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION["user"] = $user;
            return true;
        }
        return false;
    }

    /**
     * Renvoie les données d'un personnel
     */
    public static function get_personnel_by_id($idp): Personnel
    {
        $p = new Personnel();
        $cnx = DB::$db->prepare("SELECT * FROM personnel WHERE p_id = ?");
        $cnx->execute(array($idp));
        $p->data = $cnx->fetch();
        return $p;
    }

    /**
    * Renvoie un personnel avec les données en paramètre
    */
    public static function creer($data, $identifiants){
        $personnel = new Personnel();
        $personnel->data = array_combine(DB::db_column_names(Personnel::$nom_table), $data);
        $personnel->identifiants = array_combine(DB::db_column_names("identifiant"), $identifiants);
        return $personnel;
    }

    /**
    * Attention avant d'utiliser
    * Cette fonction (re)chiffre tous les mots de passe de la table identifiant
    */
    private static function hash_all_psswds(){
        
        $cnx = DB::$db->query("SELECT id, mdp FROM identifiant");
        while($row = $cnx->fetch()){
            $hash = hashage($row["mdp"]);
            $query = DB::$db->prepare("UPDATE identifiant SET mdp = :mdp WHERE id = :id");
            $query->execute(array(':mdp' => $hash, ':id' => $row["id"]));
        }
    }

    /**
    * Renvoie les refuges dans lesquels l'utilisateur à une fonction
    */
    public function get_refuges(){
        $cnx = DB::$db->prepare("SELECT DISTINCT r.* FROM exerce e JOIN refuge r ON e.r_id = r.r_id WHERE e.p_id = ?");
        $cnx->execute(array($this->data["p_id"]));
        return $cnx->fetchAll();
    }

    /**
     * Renvoie 
     */
    public static function get_personnel($idref, $nom_complet, $fonctions, $limit = MAX_LIMIT, $offset = 0){
        $cnx = DB::$db->prepare("
                                SELECT DISTINCT p.p_id, p.p_nom, p.p_prenom, p.p_tel
                                FROM exerce e
                                JOIN fonction f ON f.fc_id = e.fc_id
                                JOIN refuge r ON r.r_id = e.r_id
                                JOIN personnel p ON p.p_id = e.p_id
                                WHERE e.r_id = ?
                                AND UPPER(p.p_nom) || ' ' || UPPER(p.p_prenom) LIKE '%' || UPPER(?) || '%'
                                ".(count($fonctions) ? "AND e.fc_id IN (".implode(',', $fonctions).")" : "")."
                                ORDER BY p.p_prenom, p.p_nom
                                LIMIT ? OFFSET ?
                             ");
        $cnx->execute(array($idref, $nom_complet, $limit, $offset));
        //echo $cnx->debugDumpParams();
        return $cnx->fetchAll();
    }

    public static function get_fonctions(){
        return DB::$db->query("SELECT * FROM fonction ")->fetchAll();
    }

    public function get_personnel_fonctions(){
        $cnx = DB::$db->prepare("SELECT * FROM exerce f JOIN refuge r ON r.r_id = f.r_id  NATURAL JOIN fonction WHERE f.p_id = ?");
        $cnx->execute(array($this->data["p_id"]));
        return $cnx->fetchAll();
    }

    public function exerce_in_refuge($idref): bool
    {

        $params = array_filter($this->get_refuges(), function($v, $k) use ($idref) {
            return ($v["r_id"] == $idref);
        }, ARRAY_FILTER_USE_BOTH);
        return (bool) $params;
    }

    public static function verif_exist_personnel($nom, $prenom, $num_secu, $tel){
        $cnx = DB::$db->prepare("
                                SELECT
                                p_id
                                FROM personnel
                                WHERE (p_tel = ? AND p_nom = ? AND p_prenom = ?)
                                OR p_num_secu = ?
        ");
        $cnx->execute(array($tel, $nom, $prenom, $num_secu));
        return $cnx->fetchAll();
    }

    public static function add_personnel($nom, $prenom, $num_secu, $tel, $adresse, $localite, $codep, $login){
        $cnx = DB::$db->prepare("INSERT INTO personnel
            VALUES(DEFAULT, ?, ?, ?, ?, ?, ?, ?, ?) RETURNING p_id
        ");
        $cnx->execute(array($nom, $prenom, $adresse, $localite, $codep, $num_secu, $tel, $login));
        return $cnx->fetch()["p_id"];
    }

    public static function create_logins($nom, $prenom){
        $login = substr($prenom, 0, 3);
        $login .= substr($nom, 0, 1);
        $login .= rand(0, 9).rand(0, 9).rand(0, 9);
        $mdp = generateRandomString();
        $mdp_hash = hashage($mdp);
        $cnx = DB::$db->prepare("INSERT INTO identifiant VALUES(DEFAULT, ?, ?) RETURNING id, login, mdp");
        $cnx->execute(array($login, $mdp_hash));
        $cnx = $cnx->fetch();
        $cnx["mdp"] = $mdp;
        return $cnx;
    }

}
