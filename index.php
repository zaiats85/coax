<?php

require __DIR__ . '/vendor/autoload.php';
include './config.php';
use Abraham\TwitterOAuth\TwitterOAuth;

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader, array());

if (isset($_POST['query']) && $_SERVER["REQUEST_METHOD"] == "POST"){
    $query = filter_var($_POST['query'], FILTER_SANITIZE_STRING);

    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

    $tweets = $connection->get('search/tweets', array(
        'q'=>$query
    ));

    echo $twig->render('form.twig', array(
        'tweets'=> $tweets->statuses,
        'errors'=>$tweets->errors,
        'meta'=>$tweets->search_metadata
    ));
} else {
    echo $twig->render('form.twig');
}


