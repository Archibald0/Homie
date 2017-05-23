<?php

namespace HomieBundle\Controller;

use HomieBundle\Entity\Available;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CookController extends Controller
{
    public function showMealAction() {
        $em =$this->getDoctrine()->getManager();
        $user = $this->getUser();
        $meals = $user->getMeals();
        $mealLists = $em->getRepository('HomieBundle:Meal')->findAll();
        return $this->render('@Homie/Cook/cook_meals.html.twig', array(
            'mealLists' => $mealLists,
            'meals' => $meals,
            'cook' => $user
        ));
    }

    public function addMealAction(Request $request) {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        if($request->isXmlHttpRequest()){
            $mealId = $request->request->get('addMeal')['meals'];
            $meal = $em->getRepository('HomieBundle:Meal')->findOneById($mealId);
            $user->addMeal($meal);

            $em->flush();

            $encoders = array(new JsonEncoder()) ;
            $normalizer = array(new ObjectNormalizer()) ;
            $serializer = new Serializer($normalizer, $encoders);
            $jsonMeal = $serializer->serialize($meal, 'json');
            $response = new response($jsonMeal);

            $response->headers->set('Content-Type', 'application/json');


            return $response;
        }
    }

    public function deleteCookMealAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $mealId = $request->query->get('id');
        $meal = $em->getRepository('HomieBundle:Meal')->findOneById($mealId);

        $user->removeMeal($meal);

        $em->flush();

        $response = new Response("Meal deleted");

        return $response;
    }

    public function availableAction() {
        $em = $this->getDoctrine()->getManager();

        $available = new Available();
        $user = $this->getUser();
        $formAvailable = $this->createForm('HomieBundle\Form\AvailableType', $available);
        $availables = $em->getRepository('HomieBundle:Available')
            ->findBy(
                array(
                    'user' => $user
                ),
                array(
                    'start_date' => 'asc'
                ));

        return $this->render('@Homie/Cook/cook_available.html.twig', array(
            'formAvailable'=>$formAvailable->createView(),
            'availables' => $availables,
            'cook' => $user
        ));
    }

    public function addAvailableAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $available = new Available();

        if($request->isXmlHttpRequest()){

            $dayStr = $request->request->get('date');

            // reformat the materialize's datepicker string to DateTime format
            $day = preg_split("/(, | )/", $dayStr);
            $day_day = $day[0];
            $day_month = $day[1];
            $day_year = $day[2];

            $start_hourStr = $request->request->get('homiebundle_available')['start_date']['time']['hour'];
            $start_minStr = $request->request->get('homiebundle_available')['start_date']['time']['minute'];
            $end_hourStr = $request->request->get('homiebundle_available')['end_date']['time']['hour'];
            $end_minStr = $request->request->get('homiebundle_available')['end_date']['time']['minute'];

            $start_date = $day_year . '-' . $day_month . '-' . $day_day . ' ' . $start_hourStr . ':' . $start_minStr;
            $end_date = $day_year . '-' . $day_month . '-' . $day_day . ' ' . $end_hourStr . ':' . $end_minStr;

            $start_date = new \DateTime($start_date);
            $end_date = new\DateTime($end_date);

            $available->setStartDate($start_date);
            $available->setEndDate($end_date);
            $available->setUser($user);

            $em->persist($available);
            $em->flush();

            $encoders = array(new JsonEncoder()) ;
            $normalizer = array(new ObjectNormalizer()) ;
            $serializer = new Serializer($normalizer, $encoders);
            $jsonAvailable = $serializer->serialize($available, 'json');
            $response = new response($jsonAvailable);

            $response->headers->set('Content-Type', 'application/json');


            return $response;
        }

    }

    public function deleteAvailableAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $availableId = $request->query->get('id');
        $available = $em->getRepository('HomieBundle:Available')->findOneById($availableId);

        $em->remove($available);
        $em->flush();

        $response = new Response("Meal deleted");

        return $response;
    }

    public function passOnlineAction() {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $online = $user->getOnline();

        if($online == 1)
        {
            $user->setOnline(0);
            $response = new Response("You are now Offline!");
        }
        else
        {
            $user->setOnline(1);
            $response = new Response("You are now Online!");
        }

        $em->flush();
        return $response;
    }
}