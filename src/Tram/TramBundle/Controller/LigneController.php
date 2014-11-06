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

        if(!$res) {
            throw $this->createNotFoundException('Cette ligne n\'existe pas');
        }

        return $this->render('TramBundle:Tram:ligne.html.twig', array('ligne' => $res));
    }

    public function stopAction($code_stop, $code_ligne = null)
    {
        $doctrine = $this->getDoctrine()->getManager();
        $rep = $doctrine->getRepository('TramBundle:Stop');

        $res = $rep->findOneByCode($code_stop);

        if ($code_ligne) {
            $rep = $doctrine->getRepository('TramBundle:Ligne');
            $ligne = $rep->findOneByCode($code_ligne);
            return $this->render('TramBundle:Tram:stop.html.twig', array('stop' => $res, 'ligne_stop' => $ligne));
        } else {
            return $this->render('TramBundle:Tram:stop_uniq.html.twig', array('stop' => $res));
        }
    }

    public function positionAction()
    {
        return $this->render('TramBundle:Tram:position.html.twig');
    }
}
