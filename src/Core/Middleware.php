<?php
namespace App\Core;

class Middleware {

    public static function handle(): bool {
        return isset($_SESSION['user_id']);
    }  

}