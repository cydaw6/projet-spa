<?php

class Animal{
    public $data;

    public static function get_animal_by_id($idanim){
        $animal = new Animal();
        $animal->data = DB::$db->prepare("SELECT * FROM animal WHERE a_id = ?")->execute(array($idanim))->fetch();
        return $animal;
    }

    public static function get_animals($idref, $nom, $espece, $limit, $offset, $deces = false, $adopte = false){



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

        $res->execute(array($idref, $nom, $limit, $offset));
        //echo $res->debugDumpParams();
        return $res->fetchAll();
    }

    public static function get_especes(){
       return DB::$db->query("SELECT * FROM espece")->fetchAll();
    }


}