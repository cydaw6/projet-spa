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
                                    r_nom, 
                                    t_date 
                                    FROM transfert 
                                        NATURAL JOIN animal  
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

}
