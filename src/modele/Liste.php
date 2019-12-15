<?php
namespace wishlist\modele;
require 'vendor/autoload.php';

/**
 * Class Liste
 * @package wishlist\modele
 */
class Liste extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'liste';
    protected $primaryKey = 'no';
    public $timestamps = false;

    /**
     * @return mixed
     */
    public function items(){
        return $this->hasMany('wishlist\modele\Item','liste_id');
    }

    public function message(){
        return $this->hasMany('wishlist\modele\Item','liste_id');
    }
}

?>