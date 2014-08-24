<?php

namespace Tram\TramBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tram\TramBundle\Entity\Ligne;

class LigneController extends Controller
{
    public function indexAction()
    {
        $doctrine = $this->getDoctrine()->getManager();
        $rep = $doctrine->getRepository('TramBundle:Ligne');

        $res = $rep->findAll();


        return $this->render('TramBundle:Tram:index.html.twig', array('lignes' => $res));
    }

    public function ligneAction($code)
    {
        $doctrine = $this->getDoctrine()->getManager();
        $rep = $doctrine->getRepository('TramBundle:Ligne');

        $res = $rep->findOneByCode($code);

        $accidents = $res->getAccidents();

        return $this->render('TramBundle:Tram:ligne.html.twig', array('ligne' => $res));
    }
}
