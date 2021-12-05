<?php

class Refuge{

    public $data;

    public static $nom_table = "refuge";

    public static function get_refuge_data_by_id($idref)
    {
        $refuge = new Refuge();
        $res = DB::$db->prepare("SELECT * FROM refuge WHERE r_id = ?");
        $res->execute(array($idref));
        $refuge->data = $res->fetch();
        return $refuge;
    }

    public static function creer($data, $identifiants){
        /**
         * Renvoie un personnel avec les données en paramètre
         */
        $personnel = new Personnel();
        $personnel->data = array_combine(DB::db_column_names(Refuge::$nom_table), $data);
        $personnel->identifiants = array_combine(DB::db_column_names("identifiant"), $identifiants);
        return $personnel;
    }

    public function get_transferts($limit = MAX_LIMIT, $offset = 0, $date_ord = "ASC", $refuge_ord = "ASC"){
        $res = DB::$db->prepare("SELECT 
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
        $res->execute(array($this->data["r_id"], $limit, $offset));
        return $res->fetchAll();
    }

    public static function get_type_soins(){
        $res = DB::$db->query("SELECT * from type_soin");
        $res->execute();
        return $res->fetchAll();
}

    public function get_soins($nom_animal, $type_s, $limit = MAX_LIMIT, $offset = 0, $date_ord = "ASC"){

        $res = DB::$db->prepare("
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

        $res->execute(array($this->data["r_id"], $nom_animal, $limit, $offset));
        return $res->fetchAll();
    }

    public function get_animals($nom, $espece, $limit = MAX_LIMIT, $offset = 0, $deces = false, $adopte = false){

        $q = " ";
        $q .= ($deces) ? "a.a_date_deces IS NOT NULL": "a.a_date_deces IS NULL";
        $q .= ($deces && $adopte) ? " OR ": " AND ";
        $q .= ($adopte) ? "a.a_date_adoption IS NOT NULL": "a.a_date_adoption IS NULL";
        $q_espece = ($espece === "all") ? " ": "AND e.e_id = ".$espece;

        // vue contenant tous les animaux et le dernier refuge associé
        $res = DB::$db->prepare("
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

        $res->execute(array($this->data["r_id"], $nom, $limit, $offset));
        //echo $res->debugDumpParams();
        return $res->fetchAll();
    }

}
