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



    public static function get_especes(){
       return DB::$db->query("SELECT * FROM espece")->fetchAll();
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


}