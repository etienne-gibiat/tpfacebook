<?php
/**
 * Created by PhpStorm.
 * User: Pouyoupy
 * Date: 15/01/2019
 * Time: 14:25
 */

namespace wishlist\modele;
require 'vendor/autoload.php';


class Message extends \Illuminate\Database\Eloquent\Model{
    protected $table = 'message';
    protected $primaryKey = 'id';
    public $timestamps = false;


    public function message(){
        return $this->BelongTo('wishlist\modele\List','liste_id');
    }
}