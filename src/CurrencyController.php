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
        $cron = new CronExpression('0 0 */3 * *');
        $currency = $this->save_currency();
        $this->schedule($currency, $cron);
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
        unlink('data.csv');
        return $res;
    }

    public function save_currency(){
        $currencies = $this->get_currency();
        $db = new DBController();
        pg_query($db->con, "DELETE FROM currency");
        foreach($currencies as $currency) {
            
            $sql = sprintf("INSERT INTO currency (numcode, charcode, unit, name, rate) 
            VALUES (%d, '%s', %d, '%s', %f);", $currency[0],
                                          $currency[1],
                                          $currency[2],
                                          $currency[3],
                                          $currency[4]);
            $res = pg_query($db->con, $sql);
        }
        
    }

    public function schedule($task, CronExpression $cron)
    {
        $now = new DateTime();
        
        if ($cron->isDue($now)) {
            Loop::futureTick(function () use ($task) {
                $task();
            });
        }
        
        $schedule = function () use (&$schedule, $task, $cron) {
            $task();
            $now = new DateTime();
            $nextDue = $cron->getNextRunDate($now);
            Loop::addTimer($nextDue->getTimestamp() - $now->getTimestamp(), $schedule);
        };
        
        $nextDue = $cron->getNextRunDate($now);
        Loop::addTimer($nextDue->getTimestamp() - $now->getTimestamp(), $schedule);
    }

}
$cur = new CurrencyController();

