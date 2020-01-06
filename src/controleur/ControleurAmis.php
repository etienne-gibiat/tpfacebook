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
        $listeAmis = Lien::where(function ($query) use ($id) {
            $query->where("idUtilisateur1", "=", "$id")->where("etat", "=", "amitié");
        })->orWhere(function ($query) use ($id) {
            $query->where("idUtilisateur2", "=", "$id")->where("etat", "=", "amitié");
        })->get();

        $listeDemandes = Lien::where("idUtilisateur2", "=", "$id")->where("etat", "=", "attente");

        $vueA = new VueAmis([$listeAmis, $listeDemandes]);
        $vueA->render(1);

    }

}