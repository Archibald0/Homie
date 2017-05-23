<?php

namespace HomieBundle\Controller;

use HomieBundle\Entity\User;
use HomieBundle\Form\ClientType;
use HomieBundle\HomieBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ClientController extends Controller
{
    public function signUpCientAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $client = new User();
        $client->addRole('ROLE_USER');

        $formClient = $this->createForm("HomieBundle\Form\ClientType", $client);
        $formClient->handleRequest($request);

        if($formClient->isSubmitted() && $formClient->isValid()) {
            $em->persist($client);
            $em->flush();

            return $this->redirectToRoute();
        }

        return $this->render('@Homie/Client/client_signup.html.twig', array(
            'formClient' => $formClient,
        ));
    }

    public function showMealClientAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $cooks = $em->getRepository('HomieBundle:User')->findBy(
            array(
                'userGroup'=>2,
                'online'=>1
                ));



        return $this->render('HomieBundle:Client:home_client.html.twig', array(
            'cooks' => $cooks,
        ));

    }
}