<?php

namespace Tram\TramBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tram\TramBundle\Entity\Ligne;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        $doctrine = $this->getDoctrine()->getManager();
        $rep = $doctrine->getRepository('TramBundle:Ligne');

        $ligne = new Ligne;
        $ligne->setName('Tram A');
        $ligne->setCode('A');
        $ligne->setLogo('tramA.png');
        $ligne->setDeparture('a');
        $ligne->setArrival('b');

        $doctrine->persist($ligne);



        print_r($rep->find(1));

        $doctrine->flush();

        return $this->render('TramBundle:Tram:index.html.twig', array('name' => $name));
    }
}
