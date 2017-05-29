<?php

namespace HomieBundle\Controller;

use HomieBundle\Entity\Checkout;
use HomieBundle\Entity\User;
use HomieBundle\Form\CheckoutType;
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

    public function showMealClientAction() {
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
        $confirm = $em->getRepository('HomieBundle:Confirm')->findOneById(1);

        $ids = $request->request->get('ids');
        $ids = explode("-", $ids);

        $quantity = $request->request->get('quantity');

        $cookId = $ids[0];
        $cook = $em->getRepository("HomieBundle:User")->findOneById($cookId);

        $mealId = $ids[1];
        $meal = $em->getRepository("HomieBundle:Meal")->findOneById($mealId);

        $checkout->setClient($client);
        $checkout->setCook($cook);
        $checkout->setMeals($meal);
        $checkout->setQuantity($quantity);
        $checkout->setConfirm($confirm);

        $em->persist($checkout);
        $em->flush();

        $checkoutNb = $em->getRepository('HomieBundle:Checkout')->findNbCheckout($client);
        $msg = 'Meal Added';
        $response = new Response(json_encode(array('msg' => $msg, 'checkoutNb' => $checkoutNb)));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    public function checkoutAction() {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $checkoutNb = $em->getRepository('HomieBundle:Checkout')->findNbCheckout($user);
        $checkouts = $em->getRepository('HomieBundle:Checkout')->findCheckouts($user);

        $prices = 0;
        foreach ($checkouts as $checkout) {
            $price = $checkout->getMeals()->getPrice();
            $quantity = $checkout->getQuantity();
            $prices += ($price * $quantity);
        }

        return $this->render('HomieBundle:Client:checkout.html.twig', array(
            'checkouts' => $checkouts,
            'checkoutNb' => $checkoutNb,
            'prices' => $prices
        ));
    }

    public function deleteCheckoutAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $client = $this->getUser();

        $checkoutId = $request->query->get('id');
        $checkout = $em->getRepository('HomieBundle:Checkout')->findOneById($checkoutId);

        $em->remove($checkout);
        $em->flush();
        $checkouts = $em->getRepository('HomieBundle:Checkout')->findCheckouts($client);

        $prices = 0;
        foreach ($checkouts as $checkout) {
            $price = $checkout->getMeals()->getPrice();
            $quantity = $checkout->getQuantity();
            $prices += ($price * $quantity);
        }

        $checkoutNb = $em->getRepository('HomieBundle:Checkout')->findNbCheckout($client);
        $msg = 'Meal Canceled';
        $response = new Response(json_encode(array('msg' => $msg, 'checkoutNb' => $checkoutNb, 'totalPrice' => $prices)));
        $response->headers->set('Content-Type', 'application/json');


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

        return $this->render('@Homie/Client/confirm_checkout.html.twig', array(
            'checkoutNb' => $checkoutNb,
        ));
    }

    public function purchaseAddressAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $checkout = new Checkout();
        $formCheckout = $this->createForm("HomieBundle\Form\CheckoutType", $checkout);
        $checkoutNb = $em->getRepository('HomieBundle:Checkout')->findNbCheckout($user);

        $checkouts = $em->getRepository('HomieBundle:Checkout')->findCheckouts($user);

        return $this->render('@Homie/Client/address_checkout.html.twig', array(
            'formCheckout' => $formCheckout->createView(),
            'user' => $user,
            'checkouts' => $checkouts,
            'checkoutNb' => $checkoutNb
        ));


    }

    public function purchaseAddressSendAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $address = $request->query->get('address');
        $client = $this->getUser();
        $checkouts = $em->getRepository('HomieBundle:Checkout')->findCheckouts($client);
        $valid = $em->getRepository('HomieBundle:Confirm')->findOneById(2);
        $date = new \DateTime();

        if($address == 'address1') {
            $street = $client->getStreet();
            $zipCode = $client->getZipCode();
            $town = $client->getTown();
            $digicode = $client->getDigicode();
            $complement = $client->getComplement();

            $response = new Response('ok');
        }
        elseif ($address == 'address2') {
            $street = $client->getStreet2();
            $zipCode = $client->getZipCode2();
            $town = $client->getTown2();
            $digicode = $client->getDigicode2();
            $complement = $client->getComplement2();

            $response = new Response('ok');
        }
        else {
            $formData = $request->request->get('homiebundle_checkout');
            $street = $formData['street'];
            $zipCode = $formData['zip_code'];
            $town = $formData['town'];
            $digicode = $formData['digicode'];
            $complement = $formData['complement'];

            $response = new Response('ok');
        }

        foreach ($checkouts as $checkout) {
            $checkout->setStreet($street);
            $checkout->setZipCode($zipCode);
            $checkout->setTown($town);
            $checkout->setDigicode($digicode);
            $checkout->setComplement($complement);
            $checkout->setConfirm($valid);
            $checkout->setDateSend($date);
        }

        $em->flush();

        return $response;
    }
}