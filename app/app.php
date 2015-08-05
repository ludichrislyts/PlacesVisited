<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Place.php";

    session_start();

    if (empty($_SESSION['list_of_places']))
    {
        $_SESSION['list_of_places'] = array();
    }
    $app = new Silex\Application();

    //Add line to access twig templates
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    // modify route to 'use ($app)'
    $app->get("/", function() use ($app)
    {
        //change former output to reference twig template file
        return $app['twig']->render('places.html.twig', array('places' => Place::getAll()));
    });

    $app->post("/places", function() use ($app)
    {
        $place = new Place($_POST['location']);
        $place->save();
        return $app['twig']->render('create_place.html.twig', array('new_place' => $place));
    });

    $app->post("/delete_places", function() use ($app)
    {
        Place::deleteAll();
        return $app['twig']->render('delete_places.html.twig');

    });
    return $app;
?>
