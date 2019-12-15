<?php

namespace wishlist\Vue;

class VueCompte{

    private $tableau;

    public function __construct($tab){
        $this->tableau = $tab;
    }


    public function formulaireCompte(){
        $res = '
    <form id="f1" method="POST" action="/wishlist/compte">
      <legend> Création de compte</legend>
        <div class="fields">						 
							<div class="field half">
								<label for="name">login</label>
								<input type="text" name="Login" placeholder="Login" >
							</div>
							<div class="field half">
								<label for="message">Mot de Passe</label>
								<input type="password" name="MotdePasse" placeholder="Mot de passe" minlength="8">
							</div>
							<div class="field half">
								<label for="email">nom</label>
								<input type="text" name="nom" placeholder="nom" >
							</div>
							<div class="field half">
								<label for="message">prenom</label>
								<input type="text" name="prenom" placeholder="prenom" >
							</div>
							<div class="field half">
								<label for="message">email</label>
								<input type="email" name="email" placeholder="email" >
							</div>
		</div>

        <button type="submit">valider</button>
      
    </form>';

        return $res;
    }

    public function authentificationCompte(){
        if ($_SESSION['erreurLogin'] == 'erreur'){
            $mdp = '<h3>Mauvais mot de passe / login</h3>';
            $_SESSION['erreurLogin'] = NULL;
        }else{
            $mdp = '';
        }

        $res = '
        <form id="f1" method="POST" action="/wishlist/authentification">
            <legend>  Authentification </legend>
            <div class="fields">						 
				<div class="field half">
					<label for="log">login</label>
                    <input type="text" id="log" name="Login" placeholder="Login" >
                 </div>
                <div class="field half">
                    <label for="mdp">Mot de passe</label>
                    <input type="password" id="mdp" name="MotdePasse" placeholder="Mot de passe" minlength="8">
                </div>
        </div>

        <button type="submit">valider</button>
      
    </form>'. $mdp;
        return $res;
    }


    public function afficherCompte(){
        $t = $this->tableau;
        $res = '
            <div class="split style1-alt">
                <section>
					<ul class="contact">
						<li>
							<h3>login</h3>
							<span>'.$t->login.'</span>
						</li>
						<li>
							<h3>nom</h3>
							<span>'.$t->nom.'</span>
						</li>
						<li>
							<h3>prenom</h3>
							<span>'.$t->prenom.'</span>
						</li>
						<li>
							<h3>email</h3>	
							<span>'.$t->email.'</span>									
						</li>
					</ul>
				</section> '.'
				<section>
					<form method="post" action="/wishlist/Moncompte/' . $t->id_compte .'">
					    <legend> modifier les info du compte </legend>
						<div class="fields">						 
							<div class="field half">
								<label for="name">login</label>
								<input type="text" name="Login" placeholder="Login" >
							</div>
							<div class="field half">
								<label for="message">Mot de Passe</label>
								<input type="password" name="MotdePasse" placeholder="Mot de passe" minlength="8">
							</div>
							<div class="field half">
								<label for="email">nom</label>
								<input type="text" name="nom" placeholder="nom" >
							</div>
							<div class="field half">
								<label for="message">prenom</label>
								<input type="text" name="prenom" placeholder="prenom" >
							</div>
							<div class="field half">
								<label for="message">email</label>
								<input type="email" name="email" placeholder="email" >
							</div>
						</div>
						<button type="submit">modifier</button>
						<a href="/wishlist/Moncompte/Suprimer/' . $t->id_compte .'"class="button">Suprimer mon compte</a>
					</form>
				</section>
			</div>';
        return $res;
    }
    public function buttonInscription(){
        return '<form id="f1" method="get" action="/wishlist/compte"><input type="submit" value="S\'inscrire" name="sumbit"></form>';
    }

    public function render(int $selecteur) {
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
        }
        $html = <<<END
        <!DOCTYPE html>
        <html>
            <head>  </head>
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