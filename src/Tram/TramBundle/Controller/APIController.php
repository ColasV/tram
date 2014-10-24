<?php

namespace Tram\TramBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class APIController extends Controller
{
  public function indexAction()
  {
    $doctrine = $this->getDoctrine()->getManager();
    $rep = $doctrine->getRepository('TramBundle:Ligne');
    $res = $rep->findAll();
    if ($res) {
      $json = [];
      foreach($res as $ligne) {
        $destinations = $this->getDestinations($ligne->getDirections());
        $accidents = $this->getAccidents($ligne->getAccidents());
        array_push($json, array('id' => $ligne->getId(),
                                'name' => $ligne->getName(),
                                'code' => $ligne->getCode(),
                                'logo' => $ligne->getLogoURL(),
                                'accidents' => $accidents,
                                'destinations' => $destinations));
      }
      $response = new Response(json_encode($json));
      $response->setStatusCode(200);
    } else {
      $response = new Response(json_encode(array('error' => '404')));
      $response->setStatusCode(404);
    }
    $response->headers->set('Content-Type', 'application/json');
    return $response;
  }

  public function ligneAction($code, Request $request)
  {
        $doctrine = $this->getDoctrine()->getManager();
        $rep = $doctrine->getRepository('TramBundle:Stop');

        $search = $request->query->get('search');

        $res = $rep->findByCodeAndKeyWord($code, $search);

        if($res) {
          $stops = $res;
          $json = [];
          foreach($stops as $stop) {
            array_push($json, array('name' => $stop->getName(),
                                    'code' => $stop->getCode(),
                                    'agent' => $stop->getPresence()));
          }
          $response = new Response(json_encode($json));
          $response->setStatusCode(200);
        } else {
          $response = new Response(json_encode(array('error' => '404')));
          $response->setStatusCode(404);
        }

        $response->headers->set('Content-Type', 'application/json');
        return $response;
  }

  public function stopAction($code_ligne,$code_stop)
  {
    $doctrine = $this->getDoctrine()->getManager();
    $rep = $doctrine->getRepository('TramBundle:Stop');
    $stop = $rep->findOneByCode($code_stop);

    if ($stop) {
      $lignes = [];
      foreach($stop->getLignes() as $ligne) {
        $destinations = [];
        foreach($ligne->getDirections() as $destination) {
          $schedules = $this->getSchedules($ligne->getHoraires($stop, $destination));

          array_push($destinations, array('name' => $destination->getName(),
                                          'schedules' => $schedules));
        }

        $l = array('name' => $ligne->getName(),
                    'destinations' => $destinations);

        array_push($lignes, $l);
      }
      $json = array('name' => $stop->getName(),
                    'code' => $stop->getCode(),
                    'lignes' => $lignes);

      $response = new Response(json_encode($json));
      $response->setStatusCode(200);
    } else {
      $response = new Response(json_encode(array('error' => '404')));
      $response->setStatusCode(404);
    }
    $response->headers->set('Content-Type', 'application/json');
    return $response;
  }

  private function getSchedules($schedules) {
    $s = [];

    foreach($schedules as $schedule) {
      array_push($s, $schedule->getDate());
    }

    return $s;
  }

  private function getAccidents($accidents) {
    $accidents_array = [];
        foreach($accidents as $accident) {
          $a = array('name' => $accident->getName(),
                     'date' => $accident->getDate(),
                     'description' => $accident->getDescription());

          array_push($accidents_array, $a);
        }

    return $accidents_array;
  }

  private function getDestinations($destinations) {
    $d = [];

    foreach($destinations as $destination) {
      array_push($d, array('name' => $destination->getName()));
    }

    return $d;
  }
}
