<?php

namespace Mamad\CurrencyApp;

use Jenssegers\Blade\Blade;


class HomeController {

    public $blade;

    public function __construct()
    {
        $this->blade = new Blade('views', 'cache');
    }

    public function home()
    {
        session_start();
        if (isset($_SESSION["user_id"])) {
            $id = $_SESSION['user_id'];
            $db = new DBController();
            $sql = "SELECT name FROM users WHERE id = {$id}";
            $result = pg_query($db->con, $sql);
            $user = pg_fetch_assoc($result);
            echo $this->blade->render('home', ['user' => $user['name']]);
            } 
            else {
                echo $this->blade->render('home');
            }
    }

    public function profile () 
    {
        $db = new DBController();
        $sql = "SELECT name, unit, rate FROM currency";
        $res = pg_query($db->con, $sql);
        $data = pg_fetch_all($res);
        $curs_to_ruble = true;
        echo $this->blade->render('profile', ['data' => $data, 'curs' => $curs_to_ruble]);
    }

   

};