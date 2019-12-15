<?php

namespace wishlist\controleur;

use wishlist\modele\Compte;
use wishlist\Vue\VueCompte;

class CompteControleur{

    public function creerCompteControl(){
        $util = new Compte();

        $login=$_POST['Login'];
        $mdp=$_POST['MotdePasse'];
        $hash=password_hash($mdp, PASSWORD_DEFAULT, ['cost'=> 12] );
        $util->login=$login;
        $util->mdp=$hash;
        $util->nom=$_POST['nom'];
        $util->prenom=$_POST['prenom'];
        $util->email=$_POST['email'];
        $util->save();

    }

    public function authentifierCompte(){

        $login=$_POST['Login'];

        $util = Compte::where("login","=",$login)->first();
        if ($util != NULL) {
            $mdp = $_POST['MotdePasse'];
            if (password_verify($mdp, $util->mdp)) {
                $_SESSION = ['user_id' => $util->id_compte];
                $app = \Slim\Slim::getInstance();
                $app->redirect('/wishlist/');
            }else{
                $_SESSION['erreurLogin'] = 'erreur';
                $app = \Slim\Slim::getInstance();
                $app->redirect('/wishlist/authentification');
            }
        }else{
            $_SESSION['erreurLogin'] = 'erreur';
            $app = \Slim\Slim::getInstance();
            $app->redirect('/wishlist/authentification');
        }
    }

    public  function seDeconnecter(){
        session_destroy();
    }

    public function afficherInfo($idcompte){

        $tab = Compte::where("id_compte","=",$idcompte)->first();
        $vueC = new VueCompte($tab);
        $vueC->render(0);
    }

    public function formulaireConnexion(){
        $tab=[''];
        $vueC = new VueCompte($tab);
        $vueC->render(2);
    }

    public function formulaireInscription(){
        $tab=[''];
        $vueC = new VueCompte($tab);
        $vueC->render(3);

    }

    public function modifierInfo($idcompte){
        $util = Compte::where("id_compte","=",$idcompte)->first();
        if (isset($_POST['MotdePasse']) && $_POST['MotdePasse'] != "") {
            $mdp = $_POST['MotdePasse'];
            $hash=password_hash($mdp, PASSWORD_DEFAULT, ['cost'=> 12] );
            $util->mdp = $hash;
        }

        if (isset($_POST['login'])&& $_POST['login'] != "") {
            $util->login = $_POST['login'];
        }
        if (isset($_POST['nom'])&& $_POST['nom'] != "") {
            $util->nom = $_POST['nom'];
        }
        if (isset($_POST['prenom'])&& $_POST['prenom'] != "") {
            $util->prenom = $_POST['prenom'];
        }
        if (isset($_POST['email'])&& $_POST['email'] != "") {
            $util->email = $_POST['email'];
        }

        $util->save();

        $tab = Compte::where("id_compte","=",$idcompte)->first();;
        $vueC = new VueCompte($tab);
        $vueC->render(0);
    }
    public function afficherButtonInscription(){
        $tab=[''];
        $vueC = new VueCompte($tab);
        $vueC->render(1);
    }

    public function suprimer($idCompte){
        Compte::where("id_compte","=",$idCompte)->first()->delete();
        session_destroy();
    }


}