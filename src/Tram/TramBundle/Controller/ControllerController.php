<?php

namespace Tram\TramBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Tram\TramBundle\Entity\Stop;
use Tram\TramBundle\Entity\Agent;

class ControllerController extends Controller
{
    public function addControllerAction($stop)
    {
        $manager = $this->getDoctrine()->getManager();
        $stop_obj = $manager->getRepository('TramBundle:Stop')->find($stop);

        if($stop_obj) {
            $agent = $stop_obj->getAgent();

            if ($agent) {
            $response = new Response(json_encode(array('id' => $stop_obj->getId(),
                                                        'agent_id' => $agent->getId())));
            } else {
                    $response = new Response(json_encode(array('id' => $stop_obj->getId(),
                                                                'agent_id' => 'No agent')));
            }
        } else {
            $response = new Response(json_encode(array('id' => 'Error')));
        }

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
