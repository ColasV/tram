<?php

namespace Tram\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TramUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
