<?php
namespace Mamad\CurrencyApp;

class DBController
{
    protected $host = 'localhost:5432';
    protected $user = 'postgres';
    protected $password = '';
    protected $database = 'currency';

    public $con = null;
    public function __construct()
    {
        $this->con = pg_connect("host=localhost port=5432 dbname=currency user=postgres password=199069");
        
    }

    public function __destruct()
    {
        $this->closeConnection();
    }

    public function closeConnection(){
        if ($this->con != null){
            pg_close($this->con);
            $this->con = null;
        }
    }
}




