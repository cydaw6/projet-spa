<?php

class Refuge{

    public $data;
    public $animaux;
    public $personnel;
    public $transferts;
    public $soins;

    public static $nom_table = "refuge";

    public static function get_refuge_data_by_id($idref)
    {
        $refuge = new Refuge();
        $res = DB::$db->prepare("SELECT * FROM refuge WHERE r_id = ?");
        $res->execute(array($idref));
        $refuge->data = $res->fetch();
        return $refuge;
    }

    public static function creer($data){
        /**
         * Renvoie un personnel avec les données en paramètre
         */
        $personnel = new Personnel();
        $personnel->data = array_combine(DB::db_column_names(Refuge::$nom_table), $data);
        $personnel->identifiants = array_combine(DB::db_column_names("identifiant"), $identifiants);
        return $personnel;
    }



}
