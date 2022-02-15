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
require('model/validation.php');

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

    // Initialize variables
    $fname = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $fname = $_POST['fname'];

        // Name
        if(validName($fname)) {
            $_SESSION['fname'] = $_POST['fname'];
        } else {
            $f3->set('errors["fname"]', '*Required');
        }

        // Choices
        if (isset($_POST['choices'])) {
            $choices = $_POST['choices'];
            //If choices are valid
            if (validChoices($choices)) {
                $choices = implode(", ", $_POST['choices']);
            }
            else {
                $f3->set("errors['choice']", "*Invalid selection");
            }
        }

        // Redirect user to next page if there are no errors
        if(empty($f3->get('errors'))){
            $_SESSION['choices'] = $choices;
            $f3->reroute('summary');
        }
    }

    $f3->set('fname', $fname);

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