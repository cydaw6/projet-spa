<?php

class DB
{
    private static $instance;
    public static $db;

    /*     Identifiants         */
    private $host = "***REMOVED***";
    private $db_name = "spa";
    private $user = "***REMOVED***";
    private $pass = "***REMOVED***";

    /*GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public to "***REMOVED***";
    GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public to "***REMOVED***";
    GRANT ALL PRIVILEGES ON ALL FUNCTIONS IN SCHEMA public to "***REMOVED***";*/

   /* private $host = "psql.u-pem.fr";
    private $db_name = "***REMOVED***";
    private $user = "***REMOVED***.***REMOVED***";
    private $pass = "***REMOVED***";*/

    public static function getInstance(): DB
    {
        // Seul moyen d'obtenir l'instance unique (singleton)
        if(self::$instance == NULL){
            self::$instance = new DB();
        }
        return self::$instance;
    }

    /* Constructeur privé empêche autres instanciations.
     *
     */
    private function __construct(){
        try{
            DB::$db = new PDO('pgsql:host='.$this->host.';port=5432;dbname='.$this->db_name, $this->user, $this->pass);
            // On veut l'affichage des erreurs pdt le dev
            DB::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //
            DB::$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }catch (PDOException $e){
            echo "Impossible de se connecter à la base." . $e;
        }
    }

    /**
     * Méthode __clone en privé pour éviter tout clonage.
     *
     * @return void
     */
    private function __clone()
    {
    }

    public static function db_column_names($table = " "){
        /*
         * Renvoie le nom des colonnes de la table correspondante
         */
        try{
            $cnx = DB::$db->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = ? ORDER BY ORDINAL_POSITION ");
            $cnx->execute(array($table));
            return array_column($cnx->fetchAll(), "column_name");
        }catch (PDOException $e){
            echo $e;
        }
        return null;
    }

    /*         Fonctions utiles au projet        */
    /* 

     */

    /**
     * Renvoie toutes les fourrière dans tableau
     * @return mixed
     */
    public static function get_fourrieres()
    {
        return DB::$db->query("SELECT * FROM fourriere ORDER BY f_localite")->fetchAll();
    }

    /**
     * Renvoie tous les vaccins par espece
     */
    public static function get_vaccins_by_espece()
    {
        //return DB::$db->query("SELECT * FROM vaccin natural join espece ORDER BY v_nom, e_nom")->fetchAll();
        return array();
    }

    /**
     * renvoie l'espèce de l'animal
     */
    public static function get_especes()
    {
        return DB::$db->query("SELECT * FROM espece")->fetchAll();
    }

    /**
     * Renvoie tous les vaccins
     */
    public static function get_vaccins()
    {
        return DB::$db->query("SELECT * FROM vaccin ORDER BY v_nom")->fetchAll();
    }

    /*
     * Renvoie les informations d'un soin selon son identifiant
     */
    public static function get_soin_by_id($ids){
        $cnx = DB::$db->prepare("SELECT * 
                                FROM soin s
                                JOIN personnel p ON p.p_id = s.p_id 
                                JOIN type_soin ts ON ts.ts_id = s.ts_id
                                JOIN animal a ON a.a_id = s.a_id
                                LEFT JOIN vaccin v ON v.v_id = s.v_id
                                WHERE s_id = ?
        ");
        $cnx->execute(array($ids));
        return $cnx->fetch();
    }
}

