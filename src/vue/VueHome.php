<?php

namespace wishlist\Vue;


class VueHome{

    private $estConnecte;

    public function __construct(bool $connect){
        $this->estConnecte = $connect;
    }

    public function menuConnexion(){
        $res = '
        <li><a href="/wishlist/">Home</a></li>
        <li><a href="/wishlist/publicListes">Liste publique</a></li>
        <li><a href="/wishlist/authentification">Se connecter</a></li>
        <li><a href="/wishlist/compte">S\'inscrire </a ></li>
        ';
        return $res;
    }

    public  function menuConnecte(){
        $id = $_SESSION['user_id'];
        $res = '
        <li><a href="/wishlist/">Home</a></li>
        <li><a href="/wishlist/listes">voir toute les liste</a></li>
        <li><a href="/wishlist/Meslistes">Mes listes</a></li>
        <li><a href="/wishlist/Mesparticipation/'.$id.'">Mes participation</a></li>
        <li><a href="/wishlist/Moncompte/'.$id.'">Mon compte</a></li>
        <li><a href="/wishlist/deconnexion">se déconnecter</a></li>
        ';
        return $res;
    }

    public  function menuStyle(){
        $res = '* {
          box-sizing: border-box;
          font-family: Arial, Helvetica, sans-serif;
        }
        
        body {
          margin: 0;
          font-family: Arial, Helvetica, sans-serif;
        }
        
        /* Style the top navigation bar */
        .topnav {
          overflow: hidden;
          background-color: #333;
        }
        
        /* Style the topnav links */
        .topnav a {
          float: left;
          display: block;
          color: #f2f2f2;
          text-align: center;
          padding: 14px 16px;
          text-decoration: none;
        }
        
        /* Change color on hover */
        .topnav a:hover {
          background-color: #ddd;
          color: black;
        }';
        return $res;
    }


    public function render() {
        switch ($this->estConnecte) {
            case true :
                $content = $this->menuConnecte();
                break;
            case false:
                $content = $this->menuConnexion();
                break;
            case 2 :

                break;
            case 3 :

                break;
        }
        $html = <<<END
        <!doctype html>
        <html>
            <head>
                <meta charset="utf-8" />
		        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		        <link rel="stylesheet" href="/wishlist/assets/css/normalize.css">
		        <link rel="stylesheet" href="/wishlist/assets/css/main.css" />
		        <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
            </head>
            <body>
            
                
                <header id="header">
                    <a href="/wishlist/" class="title">Mywishlist</a>
                    <nav>
                        <ul>
                            $content
                        </ul>
                     </nav>
                </header>
            </body>
        <html>
END;
        echo $html;
    }

}