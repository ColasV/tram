<?php

namespace Tram\TramBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Tram\TramBundle\Entity\Stop;
use Tram\TramBundle\Entity\Agent;

class AgentController extends Controller
{
    public function addAgentAction($stop)
    {
        $manager = $this->getDoctrine()->getManager();
        $stop_obj = $manager->getRepository('TramBundle:Stop')->find($stop);

        if($stop_obj) {
            $agent = $stop_obj->getAgent();

            if ($agent) {
                $agent = $agent->addNumber();
                $agent = $agent->setLastUpdate(new \DateTime());

                $response = new Response(json_encode(array('id' => $stop_obj->getId(),
                                                            'agent' =>
                                                            array('id' => $agent->getId(),
                                                                'number' => $agent->getNumber()))));
                $response->setStatusCode(201);
            } else {
                $agent = new Agent;
                $agent->setNumber(0);
                $agent->setLastUpdate(new \DateTime());
                $manager->persist($agent);
                $stop_obj->setAgent($agent);

                $response = new Response(json_encode(array('id' => $stop_obj->getId(),
                                                            'agent' =>
                                                                array('id' => $agent->getId(),
                                                                        'number' => $agent->getNumber()))));
                $response->setStatusCode(201);
            }
        } else {
            $response = new Response(json_encode(array('status' => '404')));
            $response->setStatusCode(404);
        }

        $response->headers->set('Content-Type', 'application/json');
        $manager->flush();

        return $response;
    }

    public function showAgentAction($stop)
    {
        $manager = $this->getDoctrine()->getManager();
        $stop_obj = $manager->getRepository('TramBundle:Stop')->find($stop);

        if($stop_obj) {
            $agent = $stop_obj->getAgent();

            if ($agent) {
                $response = new Response(json_encode(array('id' => $stop_obj->getId(),
                                                            'agent' =>
                                                            array('id' => $agent->getId(),
                                                                'number' => $agent->getNumber(),
                                                                'last_update' => $agent->getLastUpdate(),
                                                                'presence' => $agent->getPresence()))));
                $response->setStatusCode(200);
            } else {
                $response = new Response(json_encode(array('id' => $stop_obj->getId(),
                                                            'agent' =>
                                                                'null' )));
                $response->setStatusCode(200);
            }
        } else {
            $response = new Response(json_encode(array('status' => '404')));
            $response->setStatusCode(404);
        }

        $response->headers->set('Content-Type', 'application/json');
        $manager->flush();

        return $response;
    }
}
