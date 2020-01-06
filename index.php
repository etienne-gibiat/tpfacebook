<?php
require_once __DIR__ . '/vendor/autoload.php';
use facebook\controleur\CompteControleur;
use facebook\controleur\ControleurAmis;
use facebook\controleur\ControleurHome;
use facebook\controleur\ListeParticipationControleur;
use facebook\controleur\ItemControleur;
use facebook\controleur\ListeCreateurControleur;
use \Illuminate\Database\Capsule\Manager as DB;

session_start();
if (!isset($_SESSION['user_id'])){
 $_SESSION['user_id'] = null;
}
if (!isset($_SESSION['erreurLogin'])){
 $_SESSION['erreurLogin'] = NULL;
}

$db = new DB();
$db->addConnection(parse_ini_file(join(DIRECTORY_SEPARATOR, ['src', 'conf', 'conf.ini'])));
$db->setAsGlobal();
$db->bootEloquent();


$app =new \Slim\Slim();


$app->get('/',function(){
 $c = new ControleurHome();
 $c->afficherHome();
 $c->getScript();
});

$app->post('/compte', function(){
 $c = new ControleurHome();
 $c->afficherHome();
 $c = new CompteControleur();
 $c->creerCompteControl();
 $app = \Slim\Slim::getInstance();
 $app->redirect('./');
});

$app->get('/demandeAmi/:id', function($id){
 $c = new ControleurHome();
 $c->afficherHome();
 $c = new ControleurAmis();
 $c->demandeDami($id);
 $app = \Slim\Slim::getInstance();
 $app->redirect('/facebook/');
});

$app->get('/compte', function(){
 $ch = new ControleurHome();
 $ch->afficherHome();
 $c = new CompteControleur();
 $c->formulaireInscription();
 $ch->getScript();
});

$app->get('/Amis', function(){
 $ch = new ControleurHome();
 $ch->afficherHome();
 $c = new ControleurAmis();
 $c->listeAmis();
 $ch->getScript();
});

$app->get('/authentification',function(){
 $c = new ControleurHome();
 $c->afficherHome();
 $c2 = new CompteControleur();
 $c2->formulaireConnexion();
 $c->getScript();
});

$app->post('/authentification',function(){
 $c = new ControleurHome();
 $c->afficherHome();
 $c2 = new CompteControleur();
 $c2->authentifierCompte();
 $c->getScript();
});

$app->get('/deconnexion', function(){
 $c = new CompteControleur();
 $c->seDeconnecter();
 $app = \Slim\Slim::getInstance();
 $app->redirect('./');
});

$app->post('/recherche', function (){
 $c = new ControleurHome();
 $c->afficherHome();
 $a = new ControleurAmis();
 $a->rechercheAmis();
 $c->getScript();
});

$app->get('/Moncompte/:idCompte',function($idCompte){
 $c = new ControleurHome();
 $c->afficherHome();
 $c2 = new CompteControleur();
 $c2->afficherInfo($idCompte);
 $c->getScript();

});

$app->post('/Moncompte/:idCompte',function($idCompte){
 $c = new ControleurHome();
 $c->afficherHome();
 $c2 = new CompteControleur();
 $c2->modifierInfo($idCompte);
 $c->getScript();
});

$app->get('/Moncompte/Suprimer/:idCompte', function ($idCompte){
 $c = new ControleurHome();
 $c->afficherHome();
 $c = new CompteControleur();
 $c->suprimer($idCompte);
 $app = \Slim\Slim::getInstance();
 $app->redirect('/facebook');
});

$app->run();



?>
