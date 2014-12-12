<?php

namespace Tram\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('TramAdminBundle:Admin:index.html.twig');
    }

    public function statAction()
    {
        $doctrine = $this->getDoctrine()->getManager();
        $rep = $doctrine->getRepository('TramBundle:Ligne');

        $res = $rep->findAll();

        $size_lignes = count($res);

        $rep = $doctrine->getRepository('TramBundle:Stop');
        $size_stops = count($rep->findAll());

        $rep = $doctrine->getRepository('TramBundle:Schedule');
        $size_schedules = count($rep->findAll());

        return $this->render('TramAdminBundle:Admin:stat.html.twig', array('lignes' => $res,
                                                                        'size_lignes' => $size_lignes,
                                                                        'size_stops' => $size_stops,
                                                                        'size_schedules' => $size_schedules));
    }
}
