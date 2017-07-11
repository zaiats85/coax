<?php
/**
 * This PestXML usage example pulls data from the OpenStreetMap API.
 * (see http://wiki.openstreetmap.org/wiki/API_v0.6)
 **/
require __DIR__ . '/vendor/autoload.php';
include './config.php';

use Abraham\TwitterOAuth\TwitterOAuth;

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader, array(
    // Uncomment the line below to cache compiled templates
    // 'cache' => __DIR__.'/../cache',
));

$query = '';

if (isset($_POST['query']) && $_SERVER["REQUEST_METHOD"] == "POST"){
    $query = $_POST['query'];
}

$search_formed = array(
    "q" => $query,
);

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

$tweets = $connection->get('search/tweets', $search_formed);

//$pest = new PestXML('http://api.openstreetmap.org/api/0.6');

// Retrieve map data for the University of Toronto campus
//$map = $pest->get('/map?bbox=-79.39997,43.65827,-79.39344,43.66903');

// Print all of the street names in the map
//$streets = $map->xpath('//way/tag[@k="name"]');


//foreach ($streets as $s) {
//    echo $s['v'] . "\n";
//}

echo $twig->render('form.twig', array(
    'tweets'=> $tweets->statuses,
    'errors'=>$tweets->errors,
    'meta'=>$tweets->search_metadata
));
?>