<?php
//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Start the session
session_start();
//var_dump($_SESSION);

// Require the autoload file
require_once ('vendor/autoload.php');
require('model/data-layer.php');

// Create an instance of the Base class
$f3 = Base::instance();

// Define a default route
$f3->route('GET /', function (){
    $view = new Template();
    echo $view->render('views/home.html');
});

// Define a survey route
$f3->route('GET|POST /survey', function ($f3){
    $f3->set('choices', getChoices());

    $view = new Template();
    echo $view->render('views/survey.html');
});

// Run fat-free
$f3->run();