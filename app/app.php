<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Place.php";
    session_start();
    if (empty($_SESSION['list_of_places']))
    {
        $_SESSION['list_of_places'] = array();
    }
    $app = new Silex\Application();
    $app->get("/", function()
    {
        $output = "";
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
    });
    $app->post("/places", function()
    {
        $place = new Place($_POST['location']);
        $place->save();
        return "
            <h1>You created a place!</h1>
            <p>" . $place->getLocation() . "</p>
            <p><a href='/'>View your list of places</a></p>
        ";
    });
    $app->post("/delete_places", function()
    {
        Place::deleteAll();
        return "
            <h1>List Cleared!</h1>
            <p><a href='/'>Home</a></p>
        ";
    });
    return $app;
?>
