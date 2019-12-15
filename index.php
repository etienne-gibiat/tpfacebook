<?php
require_once __DIR__ . '/vendor/autoload.php';
use wishlist\controleur\CompteControleur;
use wishlist\controleur\ControleurHome;
use wishlist\controleur\ListeParticipationControleur;
use wishlist\controleur\ItemControleur;
use wishlist\controleur\ListeCreateurControleur;
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

//$app->get('/*', function(){
// $c = new ControleurHome();
// $c->afficherHome();
//});
//
//$app->post('/*', function(){
// $c = new ControleurHome();
// $c->afficherHome();
//});

$app->get('/',function(){
 $c = new ControleurHome();
 $c->afficherHome();
});

$app->post('/compte', function(){
 $c = new ControleurHome();
 $c->afficherHome();
 $c = new CompteControleur();
 $c->creerCompteControl();
 $app = \Slim\Slim::getInstance();
 $app->redirect('./');
});

$app->get('/compte', function(){
 $c = new ControleurHome();
 $c->afficherHome();
 $c = new CompteControleur();
 $c->formulaireInscription();
});

$app->get('/authentification',function(){
 $c = new ControleurHome();
 $c->afficherHome();
 $c = new CompteControleur();
 $c->formulaireConnexion();
});

$app->post('/authentification',function(){
 $c = new ControleurHome();
 $c->afficherHome();
 $c = new CompteControleur();
 $c->authentifierCompte();

});

$app->get('/deconnexion', function(){
 $c = new CompteControleur();
 $c->seDeconnecter();
 $app = \Slim\Slim::getInstance();
 $app->redirect('./');
});

$app->post('/Meslistes',function(){
 $c = new ControleurHome();
 $c->afficherHome();
 $c2 = new ListeCreateurControleur();
 $c2->creerListe();

});

$app->get('/Meslistes',function(){
 $c = new ControleurHome();
 $c->afficherHome();
 $c2 = new ListeCreateurControleur();
 $c2->afficherSesListes();

});


$app->get('/Maliste/:token', function($token){
 $c = new ControleurHome();
 $c->afficherHome();
 $c = new ListeCreateurControleur();
 $c->afficherListe($token);
});

$app->post('/Maliste/:token', function($token){
 $c = new ControleurHome();
 $c->afficherHome();
 $c = new ListeCreateurControleur();
 $c->ajouterItem($token);
});

$app->get('/listes',function(){
 $c = new ControleurHome();
 $c->afficherHome();
 $c2 = new ListeParticipationControleur();
 $c2->getListes();

});

$app->get('/listes',function(){
 $c = new ControleurHome();
 $c->afficherHome();
 $c2 = new ListeParticipationControleur();
 $c2->getListes();

});

$app->get('/liste/:token',function($token){
 $c = new ControleurHome();
 $c->afficherHome();
 $c = new ListeParticipationControleur();
 $c->afficherListe($token);
});

$app->get('/item/:iditem', function ($iditem){
 $c = new ControleurHome();
 $c->afficherHome();
 $c = new ItemControleur();
 $c->afficherItem($iditem);
});

$app->post('/item/:iditem', function ($iditem){
 $c = new ControleurHome();
 $c->afficherHome();
 $c = new ItemControleur();
 $c->reserver($iditem);
});

$app->get('/MonItem/:iditem', function ($iditem){
 $c = new ControleurHome();
 $c->afficherHome();
 $c = new ItemControleur();
 $c->afficherMonItem($iditem);
});

$app->post('/MonItem/:iditem', function ($iditem){
 $c = new ControleurHome();
 $c->afficherHome();
 $c = new ItemControleur();
 $c->modifierItem($iditem);
});

$app->get('/MonItem/:iditem/supp', function ($iditem){
 $c = new ControleurHome();
 $c->afficherHome();
 $c = new ItemControleur();
 $c->suprimerItem($iditem);
 $app = \Slim\Slim::getInstance();
 $app->redirect('/wishlist/Meslistes');
});

$app->get('/Moncompte/:idCompte',function($idCompte){
 $c = new ControleurHome();
 $c->afficherHome();
 $c2 = new CompteControleur();
 $c2->afficherInfo($idCompte);

});

$app->post('/Moncompte/:idCompte',function($idCompte){
 $c = new ControleurHome();
 $c->afficherHome();
 $c2 = new CompteControleur();
 $c2->modifierInfo($idCompte);

});

$app->post('/Message/:token', function ($token){
 $c = new ControleurHome();
 $c->afficherHome();
 $c2 = new ListeParticipationControleur();
 $c2->ajouterMessage($token);
 $app = \Slim\Slim::getInstance();
 $app->redirect('/wishlist/liste/'. $token .'');
});

$app->get('/publicListes', function (){
 $c = new ControleurHome();
 $c->afficherHome();
 $c2 = new ListeParticipationControleur();
 $c2->getListePublic();
});

$app->get('/Listepublic/:token', function ($token){
 $c = new ControleurHome();
 $c->afficherHome();
 $c2 = new ListeParticipationControleur();
 $c2->afficherListePublic($token);
});

$app->post('/Listepublic/Message/:token', function ($token){
 $c = new ControleurHome();
 $c->afficherHome();
 $c2 = new ListeParticipationControleur();
 $c2->ajouterMessagePublic($token);
 $app = \Slim\Slim::getInstance();
 $app->redirect('/wishlist/Listepublic/'. $token .'');
});

$app->post('/Maliste/Public/:token', function ($token){
 $c = new ControleurHome();
 $c->afficherHome();
 $c2 = new ListeCreateurControleur();
 $c2->modifierPublic($token);
 $app = \Slim\Slim::getInstance();
 $app->redirect('/wishlist/Maliste/'. $token .'');
});

$app->get('/Maliste/Ajouter/:token', function($token){
 $c = new ControleurHome();
 $c->afficherHome();
 $c = new ListeCreateurControleur();
 $c->afficherAjout($token);
});

$app->get('/Maliste/Modifier/:token', function($token){
 $c = new ControleurHome();
 $c->afficherHome();
 $c = new ListeCreateurControleur();
 $c->afficherModif($token);
});

$app->get('/Maliste/Suprimer/:token', function($token){
 $c = new ControleurHome();
 $c->afficherHome();
 $c = new ListeCreateurControleur();
 $c->suprimerListe($token);
 $app = \Slim\Slim::getInstance();
 $app->redirect('/wishlist/Meslistes');
});

$app->get('/MonItem/:iditem/suppimage', function ($iditem){
 $c = new ControleurHome();
 $c->afficherHome();
 $c = new ItemControleur();
 $c->suprimerImage($iditem);
 $app = \Slim\Slim::getInstance();
 $app->redirect('/wishlist/MonItem/'.$iditem);
});

$app->get('/Moncompte/Suprimer/:idCompte', function ($idCompte){
 $c = new ControleurHome();
 $c->afficherHome();
 $c = new CompteControleur();
 $c->suprimer($idCompte);
 $app = \Slim\Slim::getInstance();
 $app->redirect('/wishlist');
});

$app->get('/Mesparticipation/:idcompte',function($idcompte){
 $c = new ControleurHome();
 $c->afficherHome();
 $c = new ListeParticipationControleur();
 $c->afficherParticipation($idcompte);
});


$app->run();



?>
