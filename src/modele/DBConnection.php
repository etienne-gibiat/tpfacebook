<?php

require_once 'vendor/autoloader.php';
use Illuminate\Database\Capsule\Manager as DB;

class DBConnection {
    

    private static $instance;
    private $connection;
    

    private function __construct () {
        $conf = parse_ini_file('src\conf\conf.ini');
        $db = new DB();
        $db->addConnection(conf);
        $db->setAsGlobal();
        $db->bootEloquent();

    }
    
    public static function getInstance() {
        if ($instance == null) $instance = new DBConnection();
        return $instance;
    }

    public function getConnection(){
        return $connection;
    }

}

?>