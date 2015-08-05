<?php
class Place
{
    private $location;
    //private $length_of_stay;
    //public $scenery;

    function __construct($location)
    {
        $this->location = $location;
    }

    function setLocation($new_location)
    {
        $this->location = (string) $new_location;
    }

    function getLocation()
    {
        return $this->location;
    }

    function setLengthOfStay($length)
    {
        $this->length_of_stay = $length;
    }

    function getLengthOfStay()
    {
        return $this->length_of_stay;
    }

    function save()
    {
        array_push($_SESSION['list_of_places'], $this);
    }

    static function getAll()
    {
        return $_SESSION['list_of_places'];
    }

    static function deleteAll()
    {
        $_SESSION['list_of_places'] = array();
    }
}

?>
