<?php

namespace facebook\Vue;

use facebook\modele\Compte;

class VueCompte
{

    private $tableau;

    public function __construct($tab)
    {
        $this->tableau = $tab;
    }


    public function formulaireCompte()
    {
        $res = '
                        <form class="form" id="f1" method="POST" action="/facebook/compte" enctype="multipart/form-data">
                          <div class="card-header card-header-info text-center">
                            <h4 class="card-title">Création de compte</h4>
                          </div>
                          <div class="card-body">
                          <span class="bmd-form-group"><div class="input-group">

                                  <h4 class="m-auto">photo</h4>
                                  <img id="output" src="assets/img/emptyProfil.png" alt="Raised Image" class="img-raised rounded-circle img-fluid ml-2 mt-5">

                          </div></span>
                          <span class="bmd-form-group"><div class="input-group">

                              <input type="file" name="photo" class="ml-4 form-control" id="photo" onchange="loadFile(event)" required>
                                    <script>
                                        var loadFile = function(event) {
                                            var image = document.getElementById(\'output\');
                                            image.src = URL.createObjectURL(event.target.files[0]);
                                        };
                                    </script>
                            </div></span>
                            <span class="bmd-form-group"><div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="material-icons">face</i>
                                </span>
                              </div>
                              <input type="text" class="form-control" name="nom" placeholder="nom" required autocomplete="off" style="cursor: auto;">
                              <input type="text" class="form-control ml-3" name="prenom" placeholder="prenom" required autocomplete="off" style="cursor: auto;">
                            </div></span>
                            <span class="bmd-form-group"><div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="material-icons">perm_identity</i>
                                </span>
                              </div>
                              <input type="text" class="form-control" name="Login" placeholder="Login" required autocomplete="off">
                            </div></span>
                            <span class="bmd-form-group"><div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="material-icons">mail</i>
                                </span>
                              </div>
                              <input type="email" class="form-control" name="email" placeholder="email" required autocomplete="off">
                            </div></span>
                            <span class="bmd-form-group"><div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="material-icons">lock_outline</i>
                                </span>
                              </div>
                              <input type="password" class="form-control" placeholder="Mot de Passe" name="MotdePasse" autocomplete="off" minlength="8" required style="cursor: auto;">
                            </div></span>
                          </div>
                          <div class="footer text-center">
                            <button type="submit" class="btn btn-info btn-link btn-wd btn-lg">valider</button>
                          </div>
                        </form>
                      
                ';

        return $res;
    }

    public function authentificationCompte()
    {
        if ($_SESSION['erreurLogin'] == 'erreur') {
            $mdp = '<h3>Mauvais mot de passe / login</h3>';
            $_SESSION['erreurLogin'] = NULL;
        } else {
            $mdp = '';
        }

        $res = '

<form class="form" id="f1" method="POST" action="/facebook/authentification" enctype="multipart/form-data">
                          <div class="card-header card-header-info text-center">
                            <h4 class="card-title">Authentification</h4>
                          </div>
                          <div class="card-body pt-5">
                            <span class="bmd-form-group "><div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="material-icons">face</i>
                                </span>
                              </div>
                              <input type="text" class="form-control" type="text" id="log" name="Login" placeholder="Login" required>
                            </div></span>
                            <span class="bmd-form-group"><div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="material-icons">lock_outline</i>
                                </span>
                              </div>
                              <input type="password" class="form-control" id="mdp" name="MotdePasse" placeholder="Mot de passe" minlength="8" required style="cursor: auto;">
                            </div></span>
                          </div>
                          <div class="footer text-center mt-5">
                            <button type="submit" class="btn btn-info btn-link btn-wd btn-lg">valider</button>
                          </div>
                        </form>' . $mdp;
        return $res;
    }


    public function afficherCompte()
    {
        $t = $this->tableau;
        $res = '
            <div class="page-header header-filter" data-parallax="true" style="background-image: url(\'/facebook/assets/img/city-profile.jpg\');"></div>
            <div class="main main-raised">
            <div class="profile-content">
              <div class="container">
                <div class="row">
                  <div class="col-md-6 ml-auto mr-auto">
                    <div class="profile">
                      <div class="avatar">
                        <img src="/facebook/assets/img/' . $t->avatar . '" alt="Circle Image" class="img-raised rounded-circle img-fluid">
                      </div>
                      <div class="name">
                        <h3 class="title">' . $t->prenom . ' ' . $t->nom . '</h3>
                      
                      </div>
                    </div>
                  </div>
                </div>
                <div class="description text-center">
                  
                  
                </div>
                <div class="row">
                  <div class="col-md-6 ml-auto mr-auto">
                    <div class="profile-tabs">
                      <ul class="nav nav-pills nav-pills-info nav-pills-icons justify-content-center" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link" href="#works" role="tab" data-toggle="tab">
                            <i class="material-icons">palette</i> Profil
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#favorite" role="tab" data-toggle="tab">
                            <i class="material-icons">favorite</i> Modification
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="tab-content tab-space">
                  <div class="tab-pane active text-center gallery" id="studio">
                    
                  </div>
                  <div class="tab-pane text-center gallery" id="works">
                    <h2>Informations personnelles</h2>
                    <br>
                    <h4>Nom: ' . $t->nom . '</h4>
                    <hr>
                    <h4>Prenom: ' . $t->prenom . '</h4>
                    <hr>
                    <h4>Login: ' . $t->login . '</h4>
                    <hr>
                    <h4>Email: ' . $t->email . '</h4>
                    
                  </div>
                  <div class="tab-pane text-center gallery" id="favorite">
                        <form method="post" action="/facebook/Moncompte/' . $t->id_compte . '" enctype="multipart/form-data">
                          <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="Login">Login</label>
							    <input type="text" id="login" class="form-control" name="Login" placeholder="Login" >
                            </div>
                            <div class="form-group col-md-6">
                              <label for="inputPassword4">Mot de passe</label>
                              <input type="password" class="form-control" id="inputPassword4" name="MotdePasse" placeholder="Mot de passe" minlength="8">
                            </div>
                          </div>
                          <div class="form-row">
                              <div class="form-group col-md-6">
                                <label for="inputName">Nom</label>
                                <input type="text" class="form-control" id="inputName" name="nom" placeholder="nom">
                              </div>
                              <div class="form-group col-md-6">
                                <label for="inputPrenom">Prenom</label>
                                <input type="text" class="form-control" id="inputPrenom" name="prenom" placeholder="prenom">
                              </div>
                          </div>
                          
                            <div class="form-group col-md-12">
                              <label for="inputEmail">Email</label>
                              <input type="email" name="email" placeholder="email" class="form-control" id="inputEmail">
                            </div>
                             <div class="form-row">
                            <div class="form-group col-md-6">
                              <div class="">
                                  <img id="output" src="/facebook/assets/img/' . $t->avatar . '" alt="Raised Image" class="img-raised rounded-circle img-fluid " style="max-height: 160px; max-width: 160px">

                          </div>
                          </div>
                          <div class="mt-5">

                              <input type="file" name="photo" class="form-control" id="photo" onchange="loadFile(event)">
                                    <script>
                                        var loadFile = function(event) {
                                            var image = document.getElementById(\'output\');
                                            image.src = URL.createObjectURL(event.target.files[0]);
                                        };
                                    </script>
                            </div>
                            </div>
                              
                           
                         
                          
                            <button type="submit" class="btn btn-success">modifier</button>
    					    <a href="/facebook/Moncompte/Suprimer/' . $t->id_compte . '" class="btn btn-danger">Suprimer mon compte</a>
                        </form>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>';
        return $res;
    }

    private function afficherUnCompte()
    {
        $t = $this->tableau[0];
        $messages = $this->tableau[1];
        $res = '
            <div class="page-header header-filter" data-parallax="true" style="background-image: url(\'/facebook/assets/img/city-profile.jpg\');"></div>
            <div class="main main-raised">
            <div class="profile-content">
              <div class="container">
                <div class="row">
                  <div class="col-12 ml-auto mr-auto">
                    <div class="profile">
                      <div class="avatar">
                        <img src="/facebook/assets/img/' . $t->avatar . '" alt="Circle Image" class="img-raised rounded-circle img-fluid">
                      </div>
                      <div class="name">
                        <h3 class="title">' . $t->prenom . ' ' . $t->nom . '</h3>
                        </div>
                    </div>
                    <hr>
                        <div class="col-6">
                        <form class="form" id="f1" method="POST" action="/facebook/ecrire/' . $t->id_compte .'" enctype="multipart/form-data">
                      <div class="form-group">
                        <textarea type="text" rows="10" class="form-control" name="message" id="message" placeholder="Message" required></textarea>
                      </div>
                      <div id="outputdiv" class="input-group d-none">
                                  <img id="output" src="/facebook/assets/img/emptyProfil.png" alt="Raised Image" class="img-raised rounded img-fluid ml-2 mt-5">

                          </div>
                      <div class="input-group">

                              <input type="file" name="photo" class="ml-4 form-control" id="photo" onchange="loadFile(event)">
                                    <script>
                                        var loadFile = function(event) {
                                            var classs = document.getElementById(\'outputdiv\')
                                            var image = document.getElementById(\'output\');
                                            image.src = URL.createObjectURL(event.target.files[0]);
                                            classs.setAttribute("class", "input-group")
                                        };
                                    </script>
                            </div>
                      <button type="submit" class="btn btn-primary">Envoyer</button>
                    </form>
                      
                      </div>
                      <hr>
                      <div class="col-10">';
                            foreach ($messages as $message){
                                $compte = Compte::where("id_compte", "=", "$message->idAuteur")->first();
                                $res .= '<div class="blockquote">
                                        <h6>de 
                                            <a href="/facebook/unCompte/' . $compte->id_compte .'" >
                                                <button class="btn  btn-link btn-info btn-lg">
                                                    ' . $compte->prenom .' '. $compte->nom .'
                                                    <div class="ripple-container"></div>
                                                </button>
                                            </a>le ' .$message->dateEcrit . '<a href="/facebook/suprimerMessage/' . $message->id .'" >
                                                <button class="btn  btn-link btn-info btn-lg">
                                                    suprimer
                                                    <div class="ripple-container"></div>
                                                </button>
                                            </a>
                                        </h6>
                                        <p>' . $message->contenu . '</p>';
                                        if (!empty($message->image)){
                                            $res .= '<img id="output" src="/facebook/assets/img/' . $message->image . '" alt="Raised Image" class="img-raised rounded img-fluid ml-2 mt-5">';
                                        }

                                        $res .= '</div>
                                        <hr>';
                            }
            $res .= '</div>
                  </div>
                </div>
                </div>
              </div>
            </div>
          </div>';
        return $res;
    }


    public function render(int $selecteur)
    {
        switch ($selecteur) {
            case 0 :
                $content = $this->afficherCompte();
                break;
            case 1:
                $content = $this->afficherModif();
                break;
            case 2 :
                $content = $this->authentificationCompte();
                break;
            case 3 :
                $content = $this->formulaireCompte();
                break;
            case 4:
                $content = $this->afficherUnCompte();
                break;
        }
        switch ($selecteur) {
            case 2:
            case 3:
                $html = <<<END
                <!DOCTYPE html>
                <html>
                    <body>
                    <div class="mt-5 pt-5">
                    <div class="container">
                          <div class="row">
                            <div class="col-lg-4 col-md-6 ml-auto mr-auto">
                              <div class="card card-login">
                        
                            $content
                         </div>
                         </div>
                            </div>
                          </div>
                        </div>
                        
                    </body>
                    
                <html>
END;
                break;
            case 4:
            case 0:
                $html = <<<END
                <!DOCTYPE html>
                <html>
                    <body>
                        <div class="profile-page">
                            $content
                        </div>
                    </body>
                    
                <html>
END;
                break;
        }
        echo $html;
    }


}