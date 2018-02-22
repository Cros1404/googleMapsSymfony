<?php
namespace App\Controller;

class MapController
{
    public function geocode($address)
    {
        $address = str_replace(" ", "+", $address);
        $geocode = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyDvyzNY3VdjhPeZaFdgGfYnZ0gFfVMxeg4");
        $geocode = json_decode($geocode);
        return $geocode->results[0]->geometry->location;
    }
}