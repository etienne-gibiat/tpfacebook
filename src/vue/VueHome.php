<?php

namespace facebook\Vue;


class VueHome{

    private $estConnecte;

    public function __construct(bool $connect){
        $this->estConnecte = $connect;
    }

    public function menuConnexion(){
        $res = '
        <div class="collapse navbar-collapse" id="navbar">
                    <ul class="navbar-nav ml-auto">
                      <li class="nav-item">
                        <a class="nav-link" href="/facebook/authentification">
                          <i class="material-icons">cloud_download</i>Se connecter</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="/facebook/compte">
                          <i class="material-icons">cloud_download</i>S\'inscrire</a>
                      </li>
                    </ul>
                  </div>
        ';
        return $res;
    }

    public  function menuConnecte(){
        $id = $_SESSION['user_id'];
        $res = '
        <div class="collapse navbar-collapse" id="navbar">
                    <ul class="navbar-nav ml-auto">
                    
                      <form class="form-inline ml-auto" method="post" action="/facebook/recherche">
                          <div class="form-group has-white">
                            <input type="text" name="recherche" class="form-control" placeholder="Search">
                          </div>
                          <button type="submit" class="btn btn-white btn-just-icon btn-round">
                              <i class="material-icons">search</i>
                          </button>
                      </form>
                      <li class="nav-item">
                        <a class="nav-link" href="/facebook/Amis">
                          <i class="material-icons">cloud_download</i>Amis</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="/facebook/Moncompte/'.$id.'">
                          <i class="material-icons">cloud_download</i>Mon compte</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="/facebook/deconnexion">
                          <i class="material-icons">cloud_download</i>se déconnecter</a>
                      </li>
                    </ul>
                  </div>
        ';

        return $res;
    }

    public function getScript(){
        $html = <<<END
 <!doctype html>
        <html>
            <head></head>
            <body>

                <script src="/facebook/assets/js/core/jquery.min.js"></script>
                <script src="/facebook/assets/js/material-kit.min.js"></script>
                <script src="/facebook/assets/js/core/popper.min.js"></script>
                <script src="/facebook/assets/js/core/bootstrap-material-design.min.js"></script>
                <script src="/facebook/assets/js/plugins/moment.min.js"></script>
                <script src="/facebook/assets/js/plugins/bootstrap-datetimepicker.js"></script>
                <script src="/facebook/assets/js/plugins/nouislider.min.js"></script>
            </body>
<html>
END;
        echo $html;

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

        if(isset($_SESSION['demandeAmi'])){
            if($_SESSION['demandeAmi'] == -1){
                $alert = '
<div class="mt-5 pt-5 alert"><div class="alert alert-danger">
                            <div class="container">
                              <div class="alert-icon">
                                <i class="material-icons">error_outline</i>
                              </div>
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="material-icons">clear</i></span>
                              </button>
                              vous avez deja envoyé cette demande d\'ami
                            </div>
                          </div></div>';
                $_SESSION['demandeAmi'] = 0;
            }else if($_SESSION['demandeAmi'] == 1){
                $alert = '
<div class="mt-5 pt-5 alert"><div class="alert alert-success">
                            <div class="container">
                              <div class="alert-icon">
                                <i class="material-icons">check</i>
                              </div>
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="material-icons">clear</i></span>
                              </button>
                                Demande d\'ami envoyer
                            </div>
                          </div></div>';
                $_SESSION['demandeAmi'] = 0;
            }else{
                $alert = "";
            }
        }
        $html = <<<END
        <!doctype html>
        <html class="">
            <head>
                <meta charset="utf-8" />
		        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons">
		        <link rel="stylesheet" type="text/css" href="/facebook/assets/css/material-kit.min.css?v=2.0.6"" />
            </head>
            <body class=" sidebar-collapse">
            <nav class="navbar navbar-color-on-scroll fixed-top navbar-expand-lg bg-info" color-on-scroll="100" id="sectionsNav">
                <div class="container">
                  <div class="navbar-translate">
                    <a class="navbar-brand" href="/facebook/">Facebook </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="true" aria-label="Toggle navigation">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="navbar-toggler-icon"></span>
                      <span class="navbar-toggler-icon"></span>
                      <span class="navbar-toggler-icon"></span>
                    </button>
                  </div>
                    $content
                </div>
            </nav>
            
            $alert
          
            <script>
                setTimeout(fade_out, 5000);
                
                function fade_out() {
                  $(".alert").fadeOut().empty();
                }
            </script>
            </body>
        <html>
END;
        echo $html;
    }

}