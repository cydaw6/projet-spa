<?php

class Refuge{

    public $data;

    public static $nom_table = "refuge";

    /** Renvoie une objet Refuge correspondant à  l'id donné
     * @param $idref
     * @return Refuge
     */
    public static function get_refuge_data_by_id($idref): Refuge
    {
        $refuge = new Refuge();
        $cnx = DB::$db->prepare("SELECT * FROM refuge WHERE r_id = ?");
        $cnx->execute(array($idref));
        $refuge->data = $cnx->fetch();
        return $refuge;
    }

    /**
     * Renvoie un personnel avec les données en paramètre
     */
    /*public static function creer($data, $identifiants){

        $personnel = new Personnel();
        $personnel->data = array_combine(DB::db_column_names(Refuge::$nom_table), $data);
        $personnel->identifiants = array_combine(DB::db_column_names("identifiant"), $identifiants);
        return $personnel;
    }*/

    /** Renvoie la liste de tous les transferts effectués depuis le refuge
     * sous forme de tableau
     * @param int $limit
     * @param int $offset
     * @param string $date_ord
     * @param string $refuge_ord
     * @return mixed
     */
    public function get_transferts(int $limit = MAX_LIMIT, int $offset = 0, string $date_ord = "ASC", string $refuge_ord = "ASC"){
        $cnx = DB::$db->prepare("SELECT 
                                    animal.*,
                                    e.e_nom,
                                    r_nom, 
                                    t_date 
                                    FROM transfert 
                                        NATURAL JOIN animal     
                                        JOIN espece e ON animal.e_id = e.e_id
                                        
                                        JOIN refuge r ON r.r_id = transfert.r_id_dest
                                    WHERE r_id_orig = ?
                                    ORDER BY t_date ".$date_ord.",
                                             r.r_nom ".$refuge_ord.",
                                             a_nom  
                                    LIMIT ? OFFSET ?
        ");
        $cnx->execute(array($this->data["r_id"], $limit, $offset));
        return $cnx->fetchAll();
    }

    /**
     * Renvoie les types de soins sous forme de tableau
     * @return mixed
     */
    public static function get_type_soins(){
        return DB::$db->query("SELECT * from type_soin")->fetchAll();
    }

    /**
     * Renvoie la liste des soins effectués dans le refuge
     * sous forme de tableau en fonction de différents paramètres de tri
     * @param $nom_animal
     * @param $type_s
     * @param int $limit
     * @param int $offset
     * @param string $date_ord
     * @return mixed
     */
    public function get_soins($nom_animal, $type_s, int $limit = MAX_LIMIT, int $offset = 0, string $date_ord = "ASC"){

        $cnx = DB::$db->prepare("
                                WITH histo_transfert as (
                                    SELECT
                                    a_id
                                    , t_date date_inscription
                                    , r_id_dest r_id
                                    FROM transfert
                                    
                                    UNION
                                    
                                    SELECT
                                    a_id
                                    , a_date_inscription date_inscription
                                    , r_id
                                    FROM animal
                                    ORDER BY date_inscription DESC
                                )
                                
                                SELECT
                                    s.*
                                    , a.a_nom
                                    , ts.ts_libelle
                                    FROM soin s
                                    JOIN animal a ON s.a_id = a.a_id
                                    JOIN type_soin ts ON s.ts_id = ts.ts_id
                                    WHERE  ? = (
                                        SELECT ht.r_id
                                            FROM histo_transfert ht
                                            WHERE  ht.a_id = s.a_id
                                            AND ht.date_inscription <= s.s_date
                                            ORDER BY date_inscription DESC
                                        LIMIT 1
                                    )
                                    AND a.a_nom LIKE '%' || ? || '%'
                                    ".((count($type_s) ? "AND ts.ts_id IN (".implode(",",$type_s).")" : ""))."
                                    ORDER BY s.s_date ".$date_ord.", a.a_nom
                                    LIMIT ? OFFSET ?
            ");

        $cnx->execute(array($this->data["r_id"], $nom_animal, $limit, $offset));
        return $cnx->fetchAll();
    }

    public function get_animals($nom, $espece, $limit = MAX_LIMIT, $offset = 0, $deces = false, $adopte = false){

        $q = " ";
        $q .= ($deces) ? "a.a_date_deces IS NOT NULL": "a.a_date_deces IS NULL";
        $q .= ($deces && $adopte) ? " OR ": " AND ";
        $q .= ($adopte) ? "a.a_date_adoption IS NOT NULL": "a.a_date_adoption IS NULL";
        $q_espece = ($espece === "all") ? " ": "AND e.e_id = ".$espece;

        // vue contenant tous les animaux et le dernier refuge associé
        $cnx = DB::$db->prepare("
                                SELECT a.*, e.*
                                FROM dernier_refuge dr 
                                JOIN ANIMAL a ON dr.a_id = a.a_id
                                JOIN espece e ON a.e_id = e.e_id
                                WHERE dr.r_id = ? 
                                AND a.a_nom LIKE '%' || ? || '%'
                                ".$q_espece."
                                AND (".$q.")
                                ORDER BY a.a_nom, e.e_nom
                                LIMIT ? OFFSET ?
                                ");

        $cnx->execute(array($this->data["r_id"], $nom, $limit, $offset));
        //echo $cnx->debugDumpParams();
        return $cnx->fetchAll();
    }

    public function add_soin($p_id, $a_id, $ts_id, $v_id, $comm){
        $cnx = DB::$db->prepare("
            INSERT INTO soin VALUES(DEFAULT, DATE_TRUNC('second', NOW()), ?, ?, ?, ?, ?)
        ");
        return $cnx->execute(array($comm, $p_id, $a_id, $v_id, $ts_id));
    }

    public static function get_all_personnel(){
        return DB::$db->query("SELECT * FROM personnel ORDER BY p_prenom, p_nom")->fetchAll();
    }

    public function update_personnel_fonctions($p_id, $fc_ids){
        $cnx = DB::$db->prepare("DELETE FROM exerce WHERE p_id = ? AND r_id = ?");
        $cnx->execute(array($p_id, $this->data["r_id"]));
        foreach($fc_ids as $v){
            $cnx = DB::$db->prepare("INSERT INTO exerce VALUES(?, ?, ?)");
            $cnx->execute(array($p_id, $v, $this->data["r_id"]));
        }

    }

    public static function check_capacite($r_id): int
    {
        $r =  Refuge::get_refuge_data_by_id($r_id);
        $count = count(($r->get_animals("", "all")));
        return $count < $r->data["r_capacite"];
    }

    public static function transferer($id_orig, $id_animal, $id_dest){
        $cnx = DB::$db->prepare("INSERT INTO transfert VALUES(DEFAULT, NOW(), ?, ?, ?)");
        return $cnx->execute(array($id_orig, $id_animal, $id_dest));
    }

    public static function search_refuges($nom, $dep){
        $cnx = DB::$db->prepare("SELECT * 
                                    FROM refuge 
                                    WHERE UPPER(r_nom) LIKE '%' || UPPER(?) || '%' 
                                      AND r_code_postal LIKE ? || '%' 
                                    ORDER BY r_code_postal
        ");
        $cnx->execute(array($nom, $dep));
        return $cnx->fetchAll();
    }

    public static function get_all_refuge(){
        $cnx = DB::$db->query("SELECT * FROM refuge ORDER BY r_nom");
        return $cnx->fetchAll();
    }

    /**
     * Ajoute un animal au refuge
     * @param $nom
     * @param $date_n
     * @param $sexe
     * @param $comm
     * @param $e_id
     * @param $f_id
     * @return mixed
     */
    public function add_animal($nom, $date_n, $sexe, $comm, $e_id, $f_id){
        $cnx = DB::$db->prepare("INSERT INTO animal VALUES(DEFAULT, ?, ?, ?, ?, NULL, NULL, NOW(), ?, NULL, ?, ?)");
        return $cnx->execute(array($nom, $date_n, $sexe, $comm, $e_id, $f_id, $this->data["r_id"]));
    }

    public function liste_rappel_vaccin(){
        $cnx = DB::$db->prepare("SELECT
                                    DISTINCT
                                    a.a_id
                                    , a.a_nom
                                    , a.a_sexe
                                    , e.e_nom
                                    , v.v_nom
                                    FROM dernier_refuge dr
                                    NATURAL JOIN animal a
                                    NATURAL JOIN espece e
                                    JOIN requiere r on e.e_id = r.e_id
                                    JOIN vaccin v on r.v_id = v.v_id
                                    WHERE dr.r_id = ?
                                        AND a.a_date_deces IS NULL
                                        AND a.a_date_adoption IS NULL
                                        AND v.v_rappel IS NOT NULL
                                        AND NOT EXISTS (
                                            SELECT
                                                s.s_id
                                            FROM soin s
                                            WHERE s.v_id = v.v_id
                                                AND s.a_id = a.a_id
                                                AND NOW() - s.s_date  < v.v_rappel
                                            ORDER BY s.s_date DESC
                                            LIMIT 1
                                        )
                                
                                    ORDER BY a.a_nom");
        $cnx->execute(array($this->data["r_id"]));
        return $cnx->fetchAll();
    }

}
