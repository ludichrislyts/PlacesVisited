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
        'twig.path' => __DIR__.'/../view'
    ));

    // modify route to 'use ($app)'
    $app->get("/", function() use ($app)
    {
        //change former output to reference twig template file
        return $app['twig']->render('places.html.twig', array('places' => Place::getAll()));
    });
        /*$output = "";
        $all_places = Place::getALL();
        if(!empty($all_places))
        {
            $output .= "
                <h1>Places You've Been</h1>
                <p>Here are all your places:</p>
                ";
            foreach (Place::getAll() as $place)
            {
                $output .= "<p>" . $place->getLocation() . "</p>";
            }
        }
        $output .= "</ul>
            <form action='/places' method='post'>
                <label for='location'>Place Location</label>
                <input id='location' name='location' type='text'>
                <button type='submit'>Add place</button>
            </form>
        ";
        $output .= "
            <form action='/delete_places' method='post'>
                <button type='submit'>delete</button>
            </form>
        ";
        return $output;
    });*/
    $app->post("/places", function() use ($app)
    {
        $place = new Place($_POST['location']);
        $place->save();
        return $app['twig']->render('create_place.html.twig', array('new_place' => $place));
    });

    $app->post("/delete_places", function()
    {
        Place::deleteAll();
        return $app['twig']->render('delete_places.html.twig');

    });
    return $app;
?>
