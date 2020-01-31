<?php
/**
 * @author Shayna Jamieson, Bridget Black
 * @version 1.0
 * URL: http://sjamieson.greenriverdev.com/328/pets2/index.php
 * Date: January 24, 2020
 */

// start a session - ONLY ever need to put this in our controller (all other pages get by transference)
session_start();


// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

require("vendor/autoload.php");
require_once ('model/validations.php');
// instantiate F3
$f3 = Base::instance(); // invoke static
//set the debug level
$f3->set('DEBUG',3);
$f3->set('colors',array('pink','green','blue'));

// define a default route
// when the user navigates to the route directory of the project
// this is what they should see
$f3->route('GET /', function() {

    echo "<h1>My Pets</h1>";
    echo "<a href='order'>Order a Pet</a>";

    // create a new view object by instantiating the fat-free templating class
    //$view = new Template();

    // on the object template we render the home page through this route
   // echo $view->render('views/home.html');
});


//define a route accepts animal type parameter
$f3->route('GET /@item', function($f3, $params) {
    $item = $params['item'];
    //use a switch to reroute user OR give them an informed error
    switch ($item){
        case 'chicken':
            echo "<p>Cluck!</p>";
            break;
        case 'dog':
            echo "<p>Woof!</p>";
            break;
        case 'cat':
            echo "<p>Meow!</p>";
            break;
        case 'Goat':
            echo "<p>WHOAAAAAAAAA</p>";
            break;
        case 'Lion':
            echo "<p>Roar</p>";
            break;
        default:
            //no route to send them to, give error
            $f3->error(404);
    }
});

// route to our first page of our order form
// define another route called order that displays a form
$f3->route('GET|POST /order', function($f3) {
    $_SESSION=array();//clear the session
    if(isset($_POST['animal']))
    {
        $animal = $_POST['animal'];
        if(validAnimal($animal))
        {
            $_SESSION['animal']=$animal;
            $f3->reroute('/order2');
        }
        else{
            $f3->set("errors['animal']","Please enter an animal.");
        }
    }
    $view = new Template();
    echo $view->render('views/form1.html');
});

// route to our second page of our order form
// define another route called order that displays a form
$f3->route('GET|POST /order2', function($f3) {
    if(isset($_POST['color']))
    {
        $color = $_POST['color'];
        if(validColor($color))
        {
            $_SESSION['color']=$color;
            $f3->reroute('/results');
        }
        else{
            $f3->set("errors['color']","Please enter an color.");
        }
    }

//    $_SESSION['animal'] = $_POST['animal'];
    $view = new Template();
    echo $view->render('views/form2.html');
});

// route to our results page of our order form
// define another route called order that displays a form
$f3->route('GET|POST /results', function() {
//    $_SESSION['color'] = $_POST['color'];
    $view = new Template();
    echo $view->render('views/results.html');
});

// fun Fat-Free
$f3->run();