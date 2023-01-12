<?php

require 'vendor/autoload.php';

$url = 'https://cbr.ru/eng/currency_base/daily/';
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

$client = new Client();

// // Go to the symfony.com website
$crawler = $client->request('GET', $url);
$myfile = fopen("data.csv", "a");
$crawler->filter('td')->each(function ($node) use ($myfile){
    $text = $node->text();
    fputcsv($myfile, [$text]); 
 });

