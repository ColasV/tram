<?php

namespace Tram\TramBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

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
        array_push($json, array('id' => $ligne->getId(),
                                'name' => $ligne->getName(),
                                'code' => $ligne->getCode(),
                                'logo' => $ligne->getLogoURL(),
                                'accidents' => $ligne->getAccidents(),
                                'destinations' => $ligne->getDestinations()));
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
  
  public function ligneAction($code)
  {
        $doctrine = $this->getDoctrine()->getManager();
        $rep = $doctrine->getRepository('TramBundle:Ligne');

        $res = $rep->findOneByCode($code);

        if($res) {
          $ligne = $res;
          $json = [];
          
          foreach($ligne->getStops() as $stop) {
            array_push($json, array('name' => $stop->getName()));
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
      //print_r($stop);
      $json = array('name' => $stop->getName());
      
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
