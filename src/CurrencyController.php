<?php

namespace Mamad\CurrencyApp;
require 'vendor/autoload.php';

use Cron\CronExpression;
use DateTime;
use React\EventLoop\Loop;
use Jenssegers\Blade\Blade;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

class CurrencyController {

    public $blade;
    public function __construct()
    {
        $this->blade = new Blade('views', 'cache');
    }

    public function get_currency() {

        $url = 'https://cbr.ru/eng/currency_base/daily/';
        

        $client = new Client();
        $crawler = $client->request('GET', $url);
        $myfile = fopen("data.csv", "a");
        $crawler->filter('td')->each(function ($node) use ($myfile){
            $text = $node->text();
            fputcsv($myfile, [$text]); 
        });

        $file = fopen("data.csv","r");
        $cur = array();
        while(! feof($file))
        {
        array_push($cur, fgetcsv($file)[0]);
        }
        array_pop($cur);
        $res = array_chunk($cur, 5);
        fclose($file);
        return $res;
    }

    public function save_currency(){
        $currency = $this->get_currency();
        $db = new DBController();
        for($x = 0; $x < sizeof($currency); $x++) {
            
            $sql = sprintf("INSERT INTO currency (numcode, charcode, unit, name, rate) 
            VALUES (%d, '%s', %d, '%s', %f);", $currency[$x][0],
                                          $currency[$x][1],
                                          $currency[$x][2],
                                          $currency[$x][3],
                                          $currency[$x][4]);
            $res = pg_query($db->con, $sql);
        }
        sizeof($currency);
        
    }

    public function schedule(callable $task, CronExpression $cron): void
    {
        $now = new DateTime();
        // CRON is due, run task asap:
        if ($cron->isDue($now)) {
            Loop::futureTick(function () use ($task) {
                $task();
            });
        }
        // Function that executes the task
        // and adds a timer to the event loop to execute the function again when the task is next due:
        $schedule = function () use (&$schedule, $task, $cron) {
            $task();
            $now = new DateTime();
            $nextDue = $cron->getNextRunDate($now);
            Loop::addTimer($nextDue->getTimestamp() - $now->getTimestamp(), $schedule);
        };
        // Add a timer to the event loop to execute the task when it is next due:
        $nextDue = $cron->getNextRunDate($now);
        Loop::addTimer($nextDue->getTimestamp() - $now->getTimestamp(), $schedule);
    }

}

$a = new CurrencyController();
print_r($a->save_currency());