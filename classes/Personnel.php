<?php

class Personnel
{
    private $id;
    private $nom;
    private $prenom;
    private $localite;
    private $code_postal;
    private $num_secu;
    private $tel;
    private $identifiant;
    private $mdp;

    public function connect($identifiant, $mdp){
        $liste_personnel = DB::$db->query("SELECT * FROM personnel NATURAL JOIN identifiant WHERE login = \'$identifiant \';");

        if(password_verify($mdp, $liste_personnel->fetch()["mdp"])){
            echo "ok";
        }

        $_SESSION["personnel"] = $this;
        return $this;
    }
    //$mdp = password_hash($_POST["pass1"], PASSWORD_DEFAULT); // hash du nouveau mdp

}