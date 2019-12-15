<?php


namespace wishlist\Vue;

use wishlist\modele\Compte;
use wishlist\modele\Item;
use wishlist\modele\Liste;
use wishlist\modele\Message;


class VueParticipant
{

    private $tableau;

    public function __construct($tab){
        $this->tableau = $tab;
    }

    public function getListePublic(){
        $res = '<div class="table-wrapper">
					<table>
							<thead>
								<tr>
									<th>nom</th>
								</tr>
							</thead>
							<tbody>';
        foreach($this->tableau as $t){
            $res.= '<tr>
                        
						<td>'.$t['titre'].'</td>
						<td><a href="/wishlist/Listepublic/' . $t['token_partage'] .'" class="button">plus d\'info</a></td>
					</tr>';
        }
        $res .= '</tbody>	
				</table>
				</div>';
        return $res;
    }

    private function getListes(){
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
						<td><a href="/wishlist/liste/' . $t['token_partage'] .'" class="button">plus d\'info</a></td>
					</tr>';
        }
        $res .= '</tbody>	
				</table>
				</div>';
        return $res;
    }

    private function afficherListe(){
        $t = $this->tableau;
        $messages = Message::where('id_liste', '=', $t[0]['no'])->orderByDesc('date_mess')->get();
        $res ='<h1 class="major">'. $this->tableau[0]['titre'].'</h1>';
        $res.= '<br> <blockquote>'.$this->tableau[0]['description'].'</blockquote><br><br>';


        $items = Item::where('liste_id','=',$this->tableau[0]['no'])->get();
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
            if ($item->nom_participant == null )
                $nom = "personne";
            else
                $nom = $item->nom_participant;
            $res.= '<tr>
                        
						<td>'. $item->nom.'</td>
						<td>'. $item->tarif.'</td>
						<td>'. $nom.'</td>
						<td><a href="/wishlist/item/' . $item['id'] .'" class="button">Selectioner</a></td>
					</tr>';
        }
        $res .= '</tbody>	
				</table>
				</div>';
        $res .= '<h1 class="major">Message</h1>
                    <form method="post" action="/wishlist/Message/'. $t[0]['token_partage'] .'">
                    <textarea name="message" id="message" rows="5" placeholder="Votre message"></textarea><br>
                    <button type="submit">Envoyer</button>
                    </form>
                    <br><hr>';
        foreach ($messages as $message){
            $res .= '
                    <h3>'. $message['prenom_auteur'] .'</h3>
                    <pre>
                        <code>
                        '. $message['message'] .'
                        </code>
                    </pre>';
        }

        return $res;
    }

    private function afficherListePublic(){
        $t = $this->tableau;
        $messages = Message::where('id_liste', '=', $t[0]['no'])->orderByDesc('date_mess')->get();
        $res ='<h1 class="major">'. $this->tableau[0]['titre'].'</h1>';
        $res.= '<br> <blockquote>'.$this->tableau[0]['description'].'</blockquote><br><br>';


        $items = Item::where('liste_id','=',$this->tableau[0]['no'])->get();
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
            if ($item->nom_participant == null )
                $nom = "personne";
            else
                $nom = $item->nom_participant;
            $res.= '<tr>
                        
						<td>'. $item->nom.'</td>
						<td>'. $item->tarif.'</td>
						<td>'. $nom.'</td>
					</tr>';
        }
        $res .= '</tbody>	
				</table>
				</div>';
        $res .= '<h1 class="major">Message</h1>
                    <form method="post" action="/wishlist/Listepublic/Message/'. $t[0]['token_partage'] .'">
                    <textarea name="message" id="message" rows="5" placeholder="Votre message"></textarea><br>
                    <button type="submit">Envoyer</button>
                    </form>
                    <br><hr>';
        foreach ($messages as $message){
            $res .= '
                    <h3>'. $message['prenom_auteur'] .'</h3>
                    <pre>
                        <code>
                        '. $message['message'] .'
                        </code>
                    </pre>';
        }

        return $res;
    }

    private function afficherItem(){
        $t = $this->tableau;
        if ($t[0]['img'] != "" || $t[0]['img'] != null){
            $i = '<div class="col-4"><span class="image fit">
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

        $iditem = $this->tableau[0]['id'];

        if($this->tableau[0]['id_participant'] == NULL){
            $res .= '<form id="reserver1" method="POST" action="'.$iditem.'">
             <textarea name="message" id="demo-message" placeholder="Votre message" rows="6"></textarea><br>';
            $res.='<button type="submit" name="reserver" value="Reserver_reserve1">Réserver</button></form>';
        }

        return $res;
    }

    public function afficherParticipation(){
        $t = $this->tableau;

        $res = '<div class="table-wrapper">
					<table>
											<thead>
												<tr>
													<th>nom</th>
													<th>tarif</th>
													<th>reservé par</th>
													<th>Nom de la liste</th>
												</tr>
											</thead>
											<tbody>';
        foreach($t as $item){
            if ($item->nom_participant == null )
                $nom = "personne";
            else
                $nom = $item->nom_participant;
            $res.= '<tr>
                        
						<td>'. $item->nom.'</td>
						<td>'. $item->tarif.'</td>
						<td>'. $nom.'</td>
						<td>'. Liste::where("no", '=', $item->liste_id)->first()['titre'] .'</td>
						<td><a href="/wishlist/item/' . $item['id'] .'" class="button">Selectioner</a></td>
					</tr>';
        }
        $res .= '</tbody>	
				</table>
				</div>';

        return $res;
    }

    public function render(int $selecteur) {
        switch ($selecteur) {
            case 0 :
                $content = $this->getListes();
                break;

            case 1 :
                $content = $this->afficherListe();
                break;

            case 2 :
                $content = $this->afficherItem();
                break;
             case 3 :
                $content = $this->getListePublic();
             break;
            case 4:
                $content = $this->afficherListePublic();
                break;
            case 5:
                $content = $this->afficherParticipation();
                break;
        }
        $html = <<<END
        <!DOCTYPE html>
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