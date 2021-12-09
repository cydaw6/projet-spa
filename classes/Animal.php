<?php

class Animal{
    public $data;

    public static function get_animal_by_id($idanim): Animal
    {
        $animal = new Animal();
        $cnx = DB::$db->prepare("SELECT * FROM animal WHERE a_id = ?");
        $cnx->execute(array($idanim));
        $animal->data = $cnx->fetch();
        return $animal;
    }

    public function get_all_data(){
        $cnx = DB::$db->prepare("SELECT * 
                                    FROM animal a 
                                    JOIN espece e ON a.e_id = e.e_id 
                                    LEFT JOIN fourriere f ON f.f_id = a.f_id 
                                    LEFT JOIN refuge r ON r.r_id = a.r_id
                                    LEFT JOIN particulier pa ON pa.pa_id = a.pa_id 
                                    WHERE a.a_id = ?
        ");
        $cnx->execute(array($this->data["a_id"]));
        return $cnx->fetch();
    }

    public static function get_especes(){
       return DB::$db->query("SELECT * FROM espece")->fetchAll();
    }

    public function get_refuge(){
        $cnx = DB::$db->prepare("SELECT * FROM dernier_refuge dr JOIN refuge r ON r.r_id = dr.r_id WHERE dr.a_id = ?");
        $cnx->execute(array($this->data["a_id"]));
        return $cnx->fetch();
    }

    public static function get_vaccins()
    {
       return DB::$db->query("SELECT * FROM vaccin ORDER BY v_nom")->fetchAll();
    }

    public static function get_vaccins_by_espece()
    {
        //return DB::$db->query("SELECT * FROM vaccin natural join espece ORDER BY v_nom, e_nom")->fetchAll();
        return array();
    }

    /**
     * Renvoie toutes les fourrière dans tableau
     * @return mixed
     */
    public static function get_fourrieres(){
        return DB::$db->query("SELECT * FROM fourriere ORDER BY f_localite")->fetchAll();
    }

    public function get_adoptant(){
        $cnx = DB::$db->prepare("SELECT pa.* FROM animal a JOIN particulier pa ON a.pa_id = pa.pa_id WHERE a.a_id = ? ");
        $cnx->execute(array($this->data["a_id"]));
        return $cnx->fetch();
    } 

    public static function get_particuliers(){
        return DB::$db->query("SELECT * FROM particulier ORDER BY pa_nom, pa_adresse");
    }

}