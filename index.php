<?php
//turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//start a session
session_start();


//require the auto load file
require_once ("vendor/autoload.php");

//instantiate the F3 Base class
$f3 = Base::instance();

//default route
$f3->route('GET /', function()
{
/*    echo "<h1>My Pets</h1>";
    echo "<a href='order'>Order a Pet</a>";*/
    $view = new Template();
    echo $view->render('views/pet-home.html');
});

$f3->route('GET|POST /order', function($f3)
{
    // check if the form has been posted
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // validate the data
        if (empty($_POST['pet'])) {
            echo "Please supply a pet type";
        } else {
            // data is valid
            $_SESSION['pet'] = $_POST['pet'];

            // ***add the color to the session
            $_SESSION['color'] = $_POST['color'];

            // redirect to the summary route
            $f3->reroute("summary");
            session_destroy();
        }
    }

    $view = new Template();
    echo $view->render('views/pet-order.html');
});

//summary of pets order
$f3->route('GET /summary', function()
{
    $view = new Template();
    echo $view->render('views/order-summary.html');
    //var_dump($_SESSION);

});

//run f3
$f3->run();

