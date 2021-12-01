<?php

class Personnel
{
    private $id;
    private $nom;
    private $prenom;
    private $adresse;
    private $localite;
    private $code_postal;
    private $num_secu;
    private $tel;
    // --
    private $identifiant;
    private $mdp;
    // --


    private static function db_column_names(){
        try{
            $res = DB::$db->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'personnel' ORDER BY ORDINAL_POSITION ");
            return array_column($res->fetchAll(), "column_name");
        }catch (PDOException $e){
            echo $e;
        }
        return null;
    }

    public function connect($identifiant, $mdp){
        $liste_personnel = DB::$db->query("SELECT * FROM personnel NATURAL JOIN identifiant WHERE login = \'$identifiant \';");

        if(password_verify($mdp, $liste_personnel->fetch()["mdp"])){
            echo "ok";
        }

        $_SESSION["personnel"] = $this;
        return $this;
    }

    public function hash_all_psswds_in_db(){
        echo "ok";
    }

    public function toArray(){
      $colonnes = Personnel::db_column_names();
      $valeurs = array(
          $this->id,
          $this->nom,
          $this->prenom,
          $this->adresse,
          $this->localite,
          $this->code_postal,
          $this->num_secu,
          $this->tel,
          $this->id
      );
      return array_combine($colonnes, $valeurs);
    }

    //$mdp = password_hash($_POST["pass1"], PASSWORD_DEFAULT); // hash du nouveau mdp

}