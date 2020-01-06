<?php

namespace facebook\controleur;

use facebook\Vue\VueHome;


class ControleurHome
{
    public function afficherHome(){
        $vueC = new VueHome($_SESSION['user_id'] != null);
        $vueC->render();
    }

    public function getScript()
    {
        $vueC = new VueHome($_SESSION['user_id'] != null);
        $vueC->getScript();
    }
}