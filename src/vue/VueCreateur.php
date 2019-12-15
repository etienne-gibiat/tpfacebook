<?php

namespace wishlist\Vue;
use  wishlist\modele\Item;
use wishlist\modele\Compte;

class VueCreateur
{

    private $tableau;

    public function __construct($tab){
        $this->tableau = $tab;
    }

    public function afficherListesDuCreateur(){

        $res = '<div class="table-wrapper">
					<table>
											<thead>
												<tr>
													<th>nom</th>
													<th>auteur</th>
													<th>date d\'expiration</th>
												</tr>
											</thead>
											<tbody>';
        foreach($this->tableau as $t){
            $res.= '<tr>
                        
						<td>'.$t['titre'].'</td>
						<td>'. Compte::where("id_compte","=",$t['user_id'])->first()['prenom'].'</td>
						<td>'.$t['expiration'].'</td>
						<td><a href="/wishlist/Maliste/' . $t['token'] .'" class="button">modifier</a></td>
					</tr>';
        }
        $res .= '</tbody>	
				</table>
				</div>';


        $res .='<section>';

        $res .='</section>';
        $res .= '<form id="creerListe" method="POST" action="/wishlist/Meslistes">
                    
                    <legend>Creation d une nouvelle liste</legend>
                    <div class="fields">						 
                        <div class="field half">
                            <label for="f1_name">Titre de la nouvelle liste : </label>
                            <input type="text" id="f1_name" name="titreListe" required>
                        </div>
                        <div class="field half">
                            <label for="f2_name">Description :</label>
                            <input type="text" id="f2_name" name="descrListe" required>
                        </div>
                        <div class="field half">
                            <label for="f3_name">Date d expiration :</label>
                            <input type="date" id="f3_name" name="expiration" required>
                        </div>
                        <div class="field half">
                            <br>
                            <input type="checkbox" id="check1" name="public" value="1">
                            <label for="check1">Public</label>
                        </div>
                    </div>
            
                    <button type="submit">Creer la liste</button>
                </form>';


        return $res;
    }

    private function afficherListe(){

        $t = $this->tableau;

        $res ='<h1 class="major">'. $t[0]['titre'].'</h1>';

        $res.= '<br> <blockquote>'.$t[0]['description'].'</blockquote><hr><br>
                <a href="/wishlist/Maliste/Ajouter/'.$t[0]['token'].'" class="button">Ajouter un item</a>
                <a href="/wishlist/Maliste/Modifier/'.$t[0]['token'].'" class="button">Modifier les information</a>
                <a href="/wishlist/Maliste/Suprimer/'.$t[0]['token'].'" class="button">Suprimer la liste</a> <br><br><hr>';


        $items = Item::where('liste_id','=',$t[0]['no'])->get();
        $res .= '<div class="table-wrapper">
					<table>
											<thead>
												<tr>
													<th>nom</th>
													<th>tarif</th>
													<th>reservé par</th>
												</tr>
											</thead>
											<tbody>';
        foreach($items as $item){
            if ($item->nom_participant == 0)
                $nom = "personne";
            else
                $nom = $item->nom_participant;
            $res.= '<tr>
                        
						<td>'. $item->nom.'</td>
						<td>'. $item->tarif.'</td>
						<td>'. $nom.'</td>
						<td><a href="/wishlist/MonItem/' . $item['id'] .'" class="button">Modifier</a></td>
					</tr>';
        }
        $res .= '</tbody>	
				</table>
				</div>';


        $res .= '<h1 class="major">Message</h1>';
        return $res;
    }

    public function afficherModif(){
        $t = $this->tableau;
        if ($t[0]['public'] == 0 ){
            $b = '<input type="checkbox" id="check" name="public" value="1">';
        }else{
            $b = '<input type="checkbox" id="check" name="public" value="1" checked>';
        }

        $res = '<form method="POST" action="/wishlist/Maliste/Public/'. $t[0]['token'].'">
                    <legend>Creation d une nouvelle liste</legend>
                    <div class="fields">						 
                        <div class="field half">
                            <label for="f1_name">Titre de la nouvelle liste : </label>
                            <input type="text" id="f1_name" name="titreListe">
                        </div>
                        <div class="field half">
                            <label for="f2_name">Description :</label>
                            <input type="text" id="f2_name" name="descrListe">
                        </div>
                        <div class="field half">
                            <label for="f3_name">Date d expiration :</label>
                            <input type="date" id="f3_name" name="expiration">
                        </div>
                        <div class="field half">
                            <br>
                            '. $b .'
                            <label for="check">Public</label>
                        </div>
                    </div>
                 <button type="submit">Envoyer</button>
               </form>';

        return $res;
    }

    public function afficherAjout(){
        $t = $this->tableau;

        $res = '<form id="creeritem" method="POST" action="/wishlist/Maliste/'. $t[0]['token'].'" enctype="multipart/form-data">
                    <legend>ajouter item</legend>
                    <div class="fields">
                        <div class="field half">
                            <label for="f1_name">nom de l\'item : </label>
                            <input type="text" id="f1_name" name="nom" required>
                        </div>
						<div class="field half">
                            <label for="f2_name">Description :</label>
                            <input type="text" id="f2_name" name="description" required>
                        </div>
						<div class="field half">
                            <label for="f3_name">prix :</label>
                            <input type="number" id="f3_name" name="prix" required>
                        </div>
					    <div class="field half">
                            <label for="f3_name">url</label>
                            <input type="url" id="f3_name" name="url">
                        </div>
                        <div class="field half">
                            <label for="photo">Photo :</label>
                            <input type="file" name="photo" id="photo" />
                        </div>
                    </div>
                        <button type="submit">ajouter item</button>
                   </form>';

        return $res;
    }

    public function afficherItem(){
        $t = $this->tableau;
        if ($t[0]['img'] != "" || $t[0]['img'] != null){
            $sup = '<a href="/wishlist/MonItem/' . $t[0]['id'] .'/suppimage" class="button">Suprimer l\'image</a>';
            $i = '<div class="col-8"><span class="image fit">
						    <img src="/wishlist/img/'. $t[0]['img'] .'">
						</div>
						<div class="col-8"><span class="image fit">
						    <blockquote>
						        <br>'.$t[0]['descr'].'<br>
						        <hr>
            prix : '.$t[0]['tarif'].'<br>
						        <hr>
            url : '.$t[0]['url'].'
            </blockquote>
						</div>';
        }else{
            $sup='';
            $i = '<div class="col-12"><span class="image fit">
						    <blockquote>
						        <br>'.$t[0]['descr'].'<br>
						        <hr>
						        prix : '.$t[0]['tarif'].'<br>
						        <hr>
						        url : '.$t[0]['url'].'
						    </blockquote>
						</div>';
        }
        $res = '<h1 class="major">'. $t[0]['nom'].'</h1>
                <div class="box alt">
					<div class="row gtr-uniform">
						'. $i .'
					</div>
			    </div>';


        $res .= '<form id="Modifieritem" method="POST" action="/wishlist/MonItem/'. $t[0]['id'].'" enctype="multipart/form-data">
                  <legend>Modifier item</legend>
                  <div class="fields">						 
                                    <div class="field half">
                                        <label for="f1_name">nom de l\'item : </label>
                                        <input type="text" id="f1_name" name="nom">
                                    </div>			 
                                    <div class="field half">
                                        <label for="f2_name">Description :</label>
                                        <input type="text" id="f2_name" name="description">
                                    </div>					 
                                    <div class="field half">       
                                        <label for="f3_name">prix :</label>
                                        <input type="number" id="f3_name" name="prix">
                                    </div>				 
                                    <div class="field half">       
                                        <label for="f3_name">url</label>
                                        <input type="url" id="f3_name" name="url">
                                    </div>
                                    <div class="field half">
                                        <label for="photo">Photo :</label>
                                        <input type="file" name="photo" id="photo" />
                                    </div>
                                
                                </div>
            
                    <button type="submit">modifier item</button>
                    <a href="/wishlist/MonItem/' . $t[0]['id'] .'/supp" class="button">Suprimer l\'item</a>
                    '.$sup.'</form>';
        return $res;
    }


    public function render(int $selecteur) {
        switch ($selecteur) {
            case 0 :
                $content = $this->afficherListesDuCreateur();
                break;
            case 1:
                $content = $this->afficherListe();
                break;
            case 2:
                $content = $this->afficherItem();
                break;
            case 3:
                $content = $this->afficherModif();
                break;
            case 4:
                $content = $this->afficherAjout();
                break;
        }
        $html =<<<END
        <!doctype html>
        <html>
            <head></head>
            <body>
               <div id="wrapper">
                <section id="main" class="wrapper">
                <div class="inner">
                 $content
                </div>
                </section>
                </div>
            </body>
        <html>
END;
        echo $html;
    }


}