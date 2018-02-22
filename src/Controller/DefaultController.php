<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\MapController;

class DefaultController extends Controller
{
    /**
    * @Route("/")
    */
    public function index()
    {
        return $this->render('index.html.twig');
    }

    /**
    * @Route("/geocode")
    */
    public function geocode(Request $request)
    {
        $address = $request->request->get('address');
        if (!$address) 
            return $this->render('geocode_form.html.twig');
        else {
            $geocode = MapController::geocode($address);
            return $this->render('geocode.html.twig', 
                array("lat" => $geocode->lat, "lng" => $geocode->lng));
        }
    }

    /**
    * @Route("/place_marker")
    */
    public function place_marker(Request $request)
    {
        $type = $request->request->get('type');
        $icon = $request->request->get('icon');
        $color = $request->request->get('color');
        $iconOption = $icon ? "img/{$color}/{$icon}"
            : "http://maps.google.com/mapfiles/ms/icons/{$color}-dot.png";
        if (!$type) 
            return $this->render('place_marker_form.html.twig');
        else if ($type == "address") {
            $address = $request->request->get('address');
            $geocode = MapController::geocode($address);
            return $this->render('place_marker.html.twig', 
                array("lat" => $geocode->lat, "lng" => $geocode->lng,
                      "API_KEY" => "AIzaSyA2utCgFATmbG4fvzdHpFXvXErUYSJodwc",
                      "iconOption" => $iconOption));
        } else if ($type == "geocode")
            return $this->render('place_marker.html.twig', 
                array("lat" => $request->request->get('lat'),
                      "lng" => $request->request->get('lng'),
                      "API_KEY" => "AIzaSyA2utCgFATmbG4fvzdHpFXvXErUYSJodwc",
                      "iconOption" => $iconOption));
    }
}