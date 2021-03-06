<?php

class Animal{
    public $data;

    /**
     * Renvoie un animal et ses donnée selon un id animal
     * donné
     */
    public static function get_animal_by_id($idanim): Animal
    {
        $animal = new Animal();
        $cnx = DB::$db->prepare("SELECT * FROM animal WHERE a_id = ?");
        $cnx->execute(array($idanim));
        $animal->data = $cnx->fetch();
        return $animal;
    }

    /**
     * Renvoie les données de l'animal avec 
     * les jointures des tables associés
     */
    public function get_all_data(){
        $cnx = DB::$db->prepare("SELECT *, dr.r_id dernier_refuge
                                    FROM animal a 
                                    JOIN espece e ON a.e_id = e.e_id 
                                    LEFT JOIN fourriere f ON f.f_id = a.f_id 
                                    LEFT JOIN refuge r ON r.r_id = a.r_id
                                    LEFT JOIN particulier pa ON pa.pa_id = a.pa_id 
                                    JOIN dernier_refuge dr on a.a_id = dr.a_id
                                    WHERE a.a_id = ?
        ");
        $cnx->execute(array($this->data["a_id"]));
        return $cnx->fetch();
    }

    /**
     * Renvoie le refuge dans lequel 
     * se trouve l'animal
     */
    public function get_refuge(){
        $cnx = DB::$db->prepare("SELECT * FROM dernier_refuge dr JOIN refuge r ON r.r_id = dr.r_id WHERE dr.a_id = ?");
        $cnx->execute(array($this->data["a_id"]));
        return $cnx->fetch();
    }

    /**
     * Renvoie les informations du particulier
     * ayant adopté l'animal
     */
    public function get_adoptant(){
        $cnx = DB::$db->prepare("SELECT pa.* FROM animal a JOIN particulier pa ON a.pa_id = pa.pa_id WHERE a.a_id = ? ");
        $cnx->execute(array($this->data["a_id"]));
        return $cnx->fetch();
    } 

    /**
     * Renvoie tous les particuliers
     */
    public static function get_particuliers(){
        return DB::$db->query("SELECT * FROM particulier ORDER BY pa_nom, pa_adresse");
    }

    
    public static function search_animaux($idr, $anom, $espece, $sexe){
        $cnx = DB::$db->prepare("SELECT * 
                                FROM dernier_refuge dr
                                JOIN animal a ON a.a_id = dr.a_id
                                JOIN espece e ON e.e_id = a.e_id 
                                WHERE a.a_date_deces IS NULL
                                AND a.a_date_adoption IS NULL
                                ".(count($idr) ? "AND dr.r_id IN (".sanitize(implode(",", $idr)).")": "")."
                                ".(count($espece) ? "AND a.e_id IN (".sanitize(implode(",", $espece)).")": "")."
                                AND a.a_sexe LIKE '%' || ? || '%'
                                AND UPPER(a.a_nom) LIKE UPPER(?) || '%'
                                ORDER BY dr.a_nom
        ");
        $cnx->execute(array($sexe, $anom));
        return $cnx->fetchAll();
    }



}