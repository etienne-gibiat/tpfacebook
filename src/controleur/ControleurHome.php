<?php

namespace wishlist\controleur;

use wishlist\Vue\VueHome;


class ControleurHome
{
    public function afficherHome(){
        $vueC = new VueHome($_SESSION['user_id'] != null);
        $vueC->render();
    }
}