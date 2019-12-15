<?php

namespace wishlist\controleur;

use  wishlist\modele\Liste;
use  wishlist\Vue\VueCreateur;
use  wishlist\modele\Item;


class ListeCreateurControleur{

    public function creerListe(){

        $nvListe = new Liste();
        $nvListe->user_id = $_SESSION['user_id'];
        $nvListe->titre = $_POST['titreListe'];
        $nvListe->description = $_POST['descrListe'];
        $nvListe->expiration = $_POST['expiration'];
        $nvListe->token = bin2hex(openssl_random_pseudo_bytes(32));
        $nvListe->token_partage = bin2hex(openssl_random_pseudo_bytes(32));
        if (isset($_POST['public']))
        $nvListe->public = $_POST['public'];
        $nvListe->save();

        $liste = Liste::where("user_id","=",$_SESSION['user_id'])->get()->toArray();
        $vue = new VueCreateur($liste);
        $vue->render(0);

    }

    public function afficherSesListes(){
        $liste = Liste::where("user_id","=",$_SESSION['user_id'])->get()->toArray();
        $vue = new VueCreateur($liste);
        $vue->render(0);
    }

    public function ajouterItem($token){
        $liste = Liste::where("token","=",$token)->first();

        if($liste->user_id == $_SESSION['user_id']){
            $item = new Item();
            $item->liste_id = $liste->no;
            $item->nom = $_POST['nom'];
            $item->descr = $_POST['description'];
            $item->tarif = $_POST['prix'];
            if ($_FILES['photo']['error'] <= 0){
                $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
                $extension_upload = strtolower(  substr(  strrchr($_FILES['photo']['name'], '.')  ,1)  );
                if ( in_array($extension_upload,$extensions_valides)){
                    $resultat = move_uploaded_file($_FILES['photo']['tmp_name'],'img/' . $_FILES['photo']['name']);
                    if ($resultat){
                        $item->img = $_FILES['photo']['name'];
                    }
                }
            }
            $item->save();
        }

        $liste = Liste::where("token","=",$token)->first();
        $vue = new VueCreateur([$liste]);
        $vue->render(1);

    }

    public function afficherListe($token){
        $liste = Liste::where("token","=",$token)->first();
        $vue = new VueCreateur([$liste]);
        $vue->render(1);
    }


    public function modifierPublic($token){
        $liste = Liste::where('token', '=', $token)->first();
        if (isset($_POST['public']) && $_POST['public'] == 1){
            $liste['public'] = 1;
        }else{
            $liste['public'] = 0;
        }
        $liste->save();
    }
    public function afficherModif($token){
        $liste = Liste::where('token', '=', $token)->first();
        $vue = new VueCreateur([$liste]);
        $vue->render(3);
    }

    public function afficherAjout($token){
        $liste = Liste::where('token', '=', $token)->first();
        $vue = new VueCreateur([$liste]);
        $vue->render(4);
    }

    public function suprimerListe($token){
        Liste::where("token","=",$token)->first()->delete();
    }
//
//    public function afficherListeHorsValidite($num_liste){}

}
?>