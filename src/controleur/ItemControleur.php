<?php
namespace wishlist\controleur;

use wishlist\modele\Compte;
use wishlist\modele\Item;
use wishlist\Vue\VueCreateur;
use wishlist\Vue\VueParticipant;

class ItemControleur{

    public function reserver($id){
        $item = Item::find($id);
        $item->id_participant = $_SESSION['user_id'];
        $item->message = $_POST['message'];

        $c = Compte::where("id_compte","=",$_SESSION['user_id'])->first();
        $item->nom_participant = $c->login;
        $item->save();
        $liste = $item->liste->toArray();
        $vue = new VueParticipant([$liste]);
        $vue->render(1);
    }


    public function afficherItem($id){
        $item = Item::find($id)->toArray();
        $vue = new VueParticipant([$item]);
        $vue->render(2);
    }


    public function afficherMonItem($idItem){
        $item = Item::where("id","=",$idItem)->first();
        $vue = new VueCreateur([$item]);
        $vue->render(2);
    }

    public function modifierItem($idItem){
        $util = Item::where("id","=",$idItem)->first();

        if (isset($_POST['nom'])&& $_POST['nom'] != "") {
            $util->nom = $_POST['nom'];
        }
        if (isset($_POST['description'])&& $_POST['description'] != "") {
            $util->descr = $_POST['description'];
        }
        if (isset($_POST['prix'])&& $_POST['prix'] != "") {
            $util->tarif = $_POST['prix'];
        }
        if (isset($_POST['url'])&& $_POST['url'] != "") {
            $util->url = $_POST['url'];
        }
        if (isset($_FILES['photo'])) {
            if ($_FILES['photo']['error'] <= 0) {
                $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
                $extension_upload = strtolower(substr(strrchr($_FILES['photo']['name'], '.'), 1));
                if (in_array($extension_upload, $extensions_valides)) {
                    $resultat = move_uploaded_file($_FILES['photo']['tmp_name'], 'img/' . $_FILES['photo']['name']);
                    if ($resultat) {
                        $util->img = $_FILES['photo']['name'];
                    }
                }
            }
        }

        $util->save();
        $app = \Slim\Slim::getInstance();
        $app->redirect('/wishlist/MonItem/'.$idItem);
    }

    public function suprimerItem($iditem){
        Item::where("id","=",$iditem)->first()->delete();
    }

    public function suprimerImage($iditem){
        $item = Item::where("id","=",$iditem)->first();
        unlink('img/'.$item->img);
        $item->img = NULL;
        $item->save();
    }


    public function ajouterMessageItem($message){}
}
?>