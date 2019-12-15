<?php

namespace wishlist\controleur;


use Illuminate\Support\Facades\DB;
use wishlist\modele\Compte;
use wishlist\modele\Item;
use wishlist\modele\Liste;
use wishlist\Vue\VueParticipant;
use  wishlist\modele\Message;

class ListeParticipationControleur{


    public function afficherListe($token){
        $liste = Liste::where("token_partage","=",$token)->first();
        $vue = new VueParticipant([$liste]);
        $vue->render(1);
    }

    public function getListePublic(){
        $liste = Liste::where("public","!=", 0)->where("expiration", ">", date("Y-m-d H:i:s"))->orderBy('expiration')->get();

        $vue = new VueParticipant($liste);
        $vue->render(3);
    }

    public function afficherListePublic($token){
        $liste = Liste::where("token_partage","=",$token)->first();
        $vue = new VueParticipant([$liste]);
        $vue->render(4);
    }


    public function getListes(){
        $liste = Liste::all()->toArray();
        $vue = new VueParticipant($liste);
        $vue->render(0);
    }

    public function accèsListe($url){}


    public function ajouterMessage($token){
        $message = new Message();
        $liste = Liste::where("token_partage","=",$token)->first();
        $message->id_liste =$liste->no;
        $message->message = $_POST['message'];
        $message->prenom_auteur = Compte::where("id_compte", "=", $_SESSION['user_id'])->first()->prenom;
        $message->date_mess = date("Y-m-d H:i:s");
        $message->save();
    }

    public function ajouterMessagePublic($token){
        $message = new Message();
        $liste = Liste::where("token_partage","=",$token)->first();
        $message->id_liste =$liste->no;
        $message->message = $_POST['message'];
        $message->prenom_auteur = "Anonyme";
        $message->date_mess = date("Y-m-d H:i:s");
        $message->save();
    }

    public function afficherParticipation($idcompte){
        $item = Item::where('id_participant', '=', $idcompte)->get();
        $vue = new VueParticipant($item);
        $vue->render(5);
    }
}

?>