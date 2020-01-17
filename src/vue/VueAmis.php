<?php


namespace facebook\vue;


class VueAmis
{

    private $tableau;

    public function __construct($tab)
    {
        $this->tableau = $tab;
    }


    private function Recherche()
    {
        $res = '
        <div class="page-header header-filter clear-filter purple-filter" data-parallax="true" style="background-image: url(\'/facebook/assets/img/city-profile.jpg\'); transform: translate3d(0px, 33.3333px, 0px);"></div>
        <div class="main main-raised">
            <div class="section section-basic">
            <h2 class="ml-4 mt-2">Resultat de la recherche</h2>
            <hr>';
            foreach ($this->tableau as $t) {
                $res .= '<div class="row pr-5 pl-5" >
                <div class="profile-photo-small col-3" ><img src = "/facebook/assets/img/'. $t->avatar .'" style = "max-height: 50px" class="rounded-circle img-fluid" ></div >
                <div class="col-6" ><h3 > ' . $t->prenom .' '. $t->nom .' </h3 ></div >
                <div class="align-self-start justify-content-end col-3" ><a class="btn btn-success" href="/facebook/demandeAmi/'. $t->id_compte .'"> ajouter en ami </a ></div >
            </div >
            <hr >';
                }

            $res .= '</div>
        </div>
            
            ';
        return $res;
    }

    private function listAmis()
    {
        $res ='<div class="page-header header-filter clear-filter purple-filter" data-parallax="true" style="background-image: url(\'/facebook/assets/img/city-profile.jpg\'); transform: translate3d(0px, 33.3333px, 0px);"></div>
                <div class="main main-raised">
                <div class="col-md-10 ml-2 mt-2 mb-2">
              <h3>
                <small>Liste d\'amis</small>
              </h3>
              <!-- Tabs with icons on Card -->
              <div class="card card-nav-tabs mb-2">
                <div class="card-header card-header-info">
                  <!-- colors: "header-primary", "header-info", "header-success", "header-warning", "header-danger" -->
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <ul class="nav nav-tabs" data-tabs="tabs">
                        <li class="nav-item">
                          <a class="nav-link active" href="#amis" data-toggle="tab">
                            <i class="material-icons">face</i> Vos amis 
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#attente" data-toggle="tab">
                            <i class="material-icons">chat</i> Amis en attente
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#sattente" data-toggle="tab">
                            <i class="material-icons">chat</i> Vos demandes en attente
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body ">
                  <div class="tab-content text-center">
                    <div class="tab-pane active" id="amis">';
                            foreach ($this->tableau[0] as $t){
                                $res .= '<div class="row pr-5 pl-5" >
                                    <div class="profile-photo-small col-3" ><img src = "/facebook/assets/img/'. $t->avatar .'" style = "max-height: 50px" class="rounded-circle img-fluid" ></div >
                                    <div class="col-6" ><a href="/facebook/unCompte/' . $t->id_compte .'" >
                                    <button class="btn  btn-link btn-info btn-lg">' . $t->prenom .' '. $t->nom .'<div class="ripple-container"></div></button></a ></div >
                                    
                                    </div >
                                    <hr >';
                            }
                      $res .='</div>
                    <div class="tab-pane" id="attente">';
                            foreach ($this->tableau[1] as $t){
                                $res .= '<div class="row pr-5 pl-5" >
                                    <div class="profile-photo-small col-3" ><img src = "/facebook/assets/img/'. $t->avatar .'" style = "max-height: 50px" class="rounded-circle img-fluid" ></div >
                                    <div class="col-6" ><h3 > ' . $t->prenom .' '. $t->nom .' </h3 ></div >
                                    <div class="align-self-start justify-content-end col-3" ><a class="btn btn-success" href="/facebook/accepterAmi/'. $t->id_compte .'"> Accepter en ami </a ></div >
                                    </div >
                                    <hr >';
                            }
            $res .='</div>
                    <div class="tab-pane" id="sattente">';
                        foreach ($this->tableau[2] as $t){
                            $res .= '<div class="row pr-5 pl-5" >
                                    <div class="profile-photo-small col-3" ><img src = "/facebook/assets/img/'. $t->avatar .'" style = "max-height: 50px" class="rounded-circle img-fluid" ></div >
                                    <div class="col-6" ><h3 > ' . $t->prenom .' '. $t->nom .' </h3 ></div >
                                    </div >
                                    <hr >';
                                }
                    $res .='</div>
                  </div>
                </div>
              </div>
              <!-- End Tabs with icons on Card -->
            </div>
                </div>
               </div>';
                            return $res;
    }

    public function render($i) {
        switch ($i) {
            case 0:
                $content = $this->Recherche();
                break;

            case 1:
                $content = $this->listAmis();
                break;
            case 3:

                break;
        }
        $html = <<<END
        <!doctype html>
        <html>
            <body>
             $content
            </body>
        <html>
END;
        echo $html;
    }




}