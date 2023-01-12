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

};