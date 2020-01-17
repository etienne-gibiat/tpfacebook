<?php


namespace facebook\controleur;


use facebook\modele\Compte;
use facebook\modele\Lien;
use facebook\vue\VueAmis;
use facebook\Vue\VueCompte;

class ControleurAmis
{

    public function rechercheAmis(){
        if (isset($_POST['recherche'])&& $_POST['recherche'] != "") {
            $recherche = $_POST['recherche'];
        }
        $tab = Compte::where("prenomnom","like","%" . $recherche . "%")->get();
        $vueA = new VueAmis($tab);
        $vueA->render(0);
    }

    public function demandeDami($id)
    {
       $selfId = $_SESSION['user_id'];

       $existe = Lien::where("idUtilisateur1", "=", "$id")->where("idUtilisateur2", "=", "$selfId")->first();
       if($existe == null){
           $existe = Lien::where("idUtilisateur2", "=", "$id")->where("idUtilisateur1", "=", "$selfId")->first();
       }
       if($selfId != $id && $existe == null){
            $newLien = new Lien();
            $newLien->idUtilisateur1 = $selfId;
            $newLien->idUtilisateur2 =$id;
            $newLien->etat = "attente";
            $newLien->save();
           $_SESSION['demandeAmi'] = 1;
       }else{
           $_SESSION['demandeAmi'] = -1;
       }
    }

    public function listeAmis()
    {
        $id = $_SESSION['user_id'];
        $listeLienAmis = Lien::where(function ($query) use ($id) {
            $query->where("idUtilisateur1", "=", "$id")->where("etat", "=", "ami");
        })->orWhere(function ($query) use ($id) {
            $query->where("idUtilisateur2", "=", "$id")->where("etat", "=", "ami");
        })->get();

        $listeAmis = array();
        $listeDemandes = array();
        $listeSesDemandes = array();

        foreach ($listeLienAmis as $t){
            if($id == $t->idUtilisateur1){
                $listeAmis = Compte::where("id_compte", "=", "$t->idUtilisateur2")->get();
            }else{
                $listeAmis = Compte::where("id_compte", "=", "$t->idUtilisateur1")->get();
            }
        }

        $listeLienDemandes = Lien::where("idUtilisateur2", "=", "$id")->where("etat", "=", "attente")->get();

        foreach ($listeLienDemandes as $t){
                $listeDemandes = Compte::where("id_compte", "=", "$t->idUtilisateur1")->get();
        }

        $listeLienSesDemandes = Lien::where("idUtilisateur1", "=", "$id")->where("etat", "=", "attente")->get();

        foreach ($listeLienSesDemandes as $t){
                $listeSesDemandes = Compte::where("id_compte", "=", "$t->idUtilisateur2")->get();
        }

        $vueA = new VueAmis([$listeAmis, $listeDemandes, $listeSesDemandes]);
        $vueA->render(1);

    }

    public function accepterAmi($id){
        $selfId = $_SESSION['user_id'];
        $lien = Lien::where("idUtilisateur1", "=", "$id")->where("idUtilisateur2", "=", "$selfId")->first();
        $lien->etat = "ami";
        $lien->save();
    }

}