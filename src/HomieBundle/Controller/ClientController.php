<?php

namespace HomieBundle\Controller;

use HomieBundle\Entity\Checkout;
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

            return $this->redirectToRoute('homie_client_home');
        }

        return $this->render('@Homie/Client/client_signup.html.twig', array(
            'formClient' => $formClient,
        ));
    }

    public function showMealClientAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $checkoutNb = $em->getRepository('HomieBundle:Checkout')->findNbCheckout($user);

        $cooks = $em->getRepository('HomieBundle:User')->findBy(
            array(
                'userGroup'=>2,
                'online'=>1
                ));

        return $this->render('HomieBundle:Client:home_client.html.twig', array(
            'cooks' => $cooks,
            'checkoutNb' => $checkoutNb
        ));

    }

    public function addCheckoutAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $client = $this->getUser();
        $checkout = new Checkout();

        $ids = $request->query->get('ids');
        $ids = explode("-", $ids);

        $cookId = $ids[0];
        $cook = $em->getRepository("HomieBundle:User")->findOneById($cookId);

        $mealId = $ids[1];
        $meal = $em->getRepository("HomieBundle:Meal")->findOneById($mealId);

        $checkout->setClient($client);
        $checkout->setCook($cook);
        $checkout->setMeals($meal);
        $checkout->setQuantity(1);

        $em->persist($checkout);
        $em->flush();

        $response = new Response('Plat ajouté');

        return $response;

    }

    public function checkoutAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $checkoutNb = $em->getRepository('HomieBundle:Checkout')->findNbCheckout($user);
        $checkouts = $em->getRepository('HomieBundle:Checkout')->findCheckouts($user);

        $prices = 0;
        foreach ($checkouts as $checkout) {
            $price = $checkout->getMeals()->getPrice();
            $prices += $price;
        }

        return $this->render('HomieBundle:Client:checkout.html.twig', array(
            'checkouts' => $checkouts,
            'checkoutNb' => $checkoutNb,
            'prices' => $prices
        ));
    }

    public function deleteCheckoutAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $checkoutId = $request->query->get('id');
        $checkout = $em->getRepository('HomieBundle:Checkout')->findOneById($checkoutId);

        $em->remove($checkout);
        $em->flush();

        $response = new Response("Meal canceled");

        return $response;
    }

    public function editClientAction(Request $request) {
        $em= $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $checkoutNb = $em->getRepository('HomieBundle:Checkout')->findNbCheckout($user);


        $formClient = $this->createForm("HomieBundle\Form\ClientType", $user);
        $formClient->handleRequest($request);

        if($formClient->isSubmitted() && $formClient->isValid()) {

            $em->flush();

            return $this->redirectToRoute('homie_client_home');
        }

        return $this->render('@Homie/Client/edit_client.html.twig', array(
            'formClient' => $formClient->createView(),
            'checkoutNb' => $checkoutNb
        ));
    }

    public function purchaseAction() {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $checkoutNb = $em->getRepository('HomieBundle:Checkout')->findNbCheckout($user);

        $checkouts = $em->getRepository('HomieBundle:Checkout')->findCheckouts($user);
        $valid = $em->getRepository('HomieBundle:Confirm')->findOneById(2);
        $date = new \DateTime();

        foreach ($checkouts as $checkout) {
            $checkout->setConfirm($valid);
            $checkout->setDate($date);
        }

        $em->flush();

        return $this->render('@Homie/Client/confirm_checkout.html.twig', array(
            'checkoutNb' => $checkoutNb,
        ));
    }
}