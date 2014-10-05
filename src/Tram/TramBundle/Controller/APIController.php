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
        $destinations = [];
        foreach($ligne->getDestinations() as $destination) {
          array_push($destinations, $destination->getName());
        }
        
        $accidents = [];
        foreach($ligne->getAccidents() as $accident) {
          $a = array('name' => $accident->getName(),
                     'date' => $accident->getDate(),
                     'description' => $accident->getDescription());
          
          array_push($accidents, $a);
        }
        
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
          $response = new Response(json_encode(array('error' => '404',
                                                      'data' => print_r($res))));
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
        foreach($ligne->getDestinations() as $destination) {
          array_push($destinations, $destination->getName());
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
}
