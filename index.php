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

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $_SESSION['fname'] = $_POST['fname'];
        $_SESSION['choices'] = $_POST['choices'];

        // If condiments were selected
        if(isset($_POST['choices'])){
            $_SESSION['choices'] = implode(", ",$_POST['choices']);
        }
        // Redirect the user to next page
        $f3->reroute('summary');
    }

    $view = new Template();
    echo $view->render('views/survey.html');
});

// Define a summary route
$f3->route('GET /summary', function (){
    $view = new Template();
    echo $view->render('views/summary.html');

    // Clear the session data
    session_destroy();
});

// Run fat-free
$f3->run();