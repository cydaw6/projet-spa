<?php

class Animal{
    public $data;

    public static function get_animal_by_id($idanim){
        $animal = new Animal();
        $animal->data = DB::$db->prepare("SELECT * FROM animal WHERE a_id = ?")->execute(array($idanim))->fetch();
        return $animal;
    }

    public static function get_animals_from_refuge_id($idref){
        $res = DB::$db->prepare("
        WITH transferts as (      
                select          
                t_id         
                , a_id         
                , a_nom        
                 , r_id_dest r_id         
                 , t_date date_inscription         
                 FROM animal a         
                 NATURAL JOIN transfert t         
                 WHERE a_date_adoption IS NULL AND a_date_deces IS NULL         
                 ORDER BY date_inscription DESC, t DESC 
                 
            ), dernier_refuge as (          
                SELECT         
                    h.a_id         
                    , a_nom         
                    , h.r_id         
                    , h.date_inscription         
                    FROM transferts h         
                    WHERE h.t_id = (SELECT 
                                        t_id                          
                                        FROM transferts h1                          
                                        WHERE h1.a_id = h.a_id                          
                                        LIMIT 1
                                    )     
                UNION     
                SELECT         
                    a_id         
                    , a_nom         
                    , r_id         
                    , a_date_inscription date_inscription         
                    FROM animal         
                    WHERE a_date_adoption IS NULL AND a_date_deces IS NULL         
                    AND a_id NOT IN (SELECT DISTINCT a_id FROM transfert)         
                    ORDER BY a_id , date_inscription DESC 
            ) 
            
            SELECT dernier_refuge.* , r_nom FROM dernier_refuge NATURAL JOIN refuge WHERE r_id = ? ORDER BY a_id
        
        ");
        $res->execute(array($idref));
        return $res;
    }


}