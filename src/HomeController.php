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
        echo $this->blade->render('home');
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

    public function calculate()
    {
        echo "no";
    }

};