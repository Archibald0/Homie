<?php

namespace HomieBundle\Controller;

use HomieBundle\Entity\Meal;
use HomieBundle\Entity\Photo;
use HomieBundle\Entity\User;
use HomieBundle\Form\MealType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class AdminController extends Controller
{
    // --------- COOKER ADMIN ---------- //
    public function indexCookerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $cookers = $em->getRepository('HomieBundle:User')->findBy(
            array('userGroup' => '2'),
            array('username' => 'desc')
            );
        $cooker = new User();
        $photo = new Photo();

        $formPhoto = $this->createForm("HomieBundle\Form\PhotoType", $photo);
        $formCooker = $this->createForm("HomieBundle\Form\CookerType", $cooker);

        $formCooker->handleRequest($request);

        if($formCooker->isSubmitted() && $formCooker->isValid()) {
            $photoId = $request->request->get('app_user_registration_photo_id');
            $photo = $em->getRepository('HomieBundle:Photo')->findOneById($photoId);
            $cooker->setPhoto($photo);

            $em->persist($cooker);
            $em->flush();

            return $this->redirectToRoute("homie_admin_cooker");
        }

        return $this->render('HomieBundle:Admin:admin_cooker.html.twig', array(
            'formPhoto' => $formPhoto->createView(),
            'formCooker' => $formCooker->createView(),
            'cookers' => $cookers,
        ));
    }

    public function addCookerAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $cooker = new User();
        $cookerType = $em->getRepository('HomieBundle:UserGroup')->findOneByName('cook');
        $cooker->setUserGroup($cookerType);
        $cooker->addRole('ROLE_COOKER');
        $cooker->setEnabled(1);
        $cooker->setOnline(0);

        if($request->isXmlHttpRequest()) {
            $address1 = $request->request->get('homiebundle_user')['address1'];
            $phone = $request->request->get('homiebundle_user')['phone'];
            $email = $request->request->get('homiebundle_user')['email'];
            $description = $request->request->get('homiebundle_user')['description'];
            $photoId = $request->request->get('photo_id');

            $photo = $em->getRepository('HomieBundle:Photo')->findOneById($photoId);

            $cooker->setAddress1($address1);
            $cooker->setPhone($phone);
            $cooker->setEmail($email);
            $cooker->setDescription($description);
            $cooker->setUserGroup($cookerType);
            $cooker->setPhoto($photo);
            $cooker->setOnline(1);
            $em->persist($cooker);
            $em->flush();

            $cookers = $em->getRepository('HomieBundle:User')->findByUserGroup(2);

            $cooker = $cookers[count($cookers)-1];

            $encoders = array(new JsonEncoder()) ;
            $normalizer = array(new ObjectNormalizer()) ;
            $serializer = new Serializer($normalizer, $encoders);

            $jsonCooker = $serializer->serialize($cooker, 'json');

            $response = new response($jsonCooker);

            $response->headers->set('Content-Type', 'application/json');


            return $response;
        }
    }

    public function deleteCookerAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $id = $request->query->get('id');

        $cooker = $em->getRepository('HomieBundle:User')->findOneById($id);
        $idPhoto = $cooker->getPhoto()->getId();
        $photo = $em->getRepository('HomieBundle:Photo')->findOneById($idPhoto);
        $url = $photo->getUrl();

        $path = $this->getParameter('photo_directory')."/".$url;

        unlink($path);

        $em->remove($cooker);
        $em->remove($photo);

        $em->flush();

        return new response('La vignette a bien été supprimer');
    }

    public function editCookerFormAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $id = $request->query->get('id');
        $cooker = $em->getRepository('HomieBundle:User')->findOneById($id);
        $formCooker = $this->createForm("HomieBundle\Form\CookerType", $cooker);
        $photo = $cooker->getPhoto();
        $formPhoto = $this->createForm("HomieBundle\Form\PhotoType", $photo);

        return $this->render('HomieBundle:Admin:admin_cooker_edit.html.twig', array(
            'formCooker' => $formCooker->createView(),
            'formPhoto' => $formPhoto->createView(),
            'cooker' => $cooker,
        ));
    }

    public function editCookerAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('homiebundle_user')['id'];
        $cooker = $em->getRepository('HomieBundle:User')->findOneById($id);

        if($request->isXmlHttpRequest()) {

            $address1 = $request->request->get('homiebundle_user')['address1'];
            $phone = $request->request->get('homiebundle_user')['phone'];
            $email = $request->request->get('homiebundle_user')['email'];
            $description = $request->request->get('homiebundle_user')['description'];
            $photoId = $request->request->get('photo_id');

            $cooker->setAddress1($address1);
            $cooker->setPhone($phone);
            $cooker->setEmail($email);
            $cooker->setDescription($description);

            if($photoId !== null) {
                $photo = $em->getRepository('HomieBundle:Photo')->findOneById($photoId);
                $cooker->setPhoto($photo);
            }

            $em->persist($cooker);
            $em->flush();

            $cookers = $em->getRepository('HomieBundle:User')->findByUserGroup(2);

            $cooker = $cookers[count($cookers)-1];

            $encoders = array(new JsonEncoder()) ;
            $normalizer = array(new ObjectNormalizer()) ;
            $serializer = new Serializer($normalizer, $encoders);

            $jsonCooker = $serializer->serialize($cooker, 'json');

            $response = new response($jsonCooker);

            $response->headers->set('Content-Type', 'application/json');


            return $response;
        }
    }

    // ------------ MEAL ADMIN ------------ //

    public function indexMealAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $meals = $em->getRepository('HomieBundle:Meal')->findBy(array(), array('name' => 'asc'));
        $meal = new Meal();
        $photo = new Photo();

        $formPhoto = $this->createForm("HomieBundle\Form\PhotoType", $photo);
        $formMeal = $this->createForm("HomieBundle\Form\MealType", $meal);

        return $this->render('@Homie/Admin/admin_meal.html.twig', array(
            'formMeal' => $formMeal->createView(),
            'formPhoto' => $formPhoto->createView(),
            'meals' => $meals,
        ));
    }

    public function addMealAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $meal = new Meal();

        if($request->isXmlHttpRequest()) {
            $name = $request->request->get('homiebundle_meal')['name'];
            $description = $request->request->get('homiebundle_meal')['description'];
            $delay = $request->request->get('homiebundle_meal')['delay'];
            $price = $request->request->get('homiebundle_meal')['price'];
            $mealTypeId = $request->request->get('homiebundle_meal')['meal_type'];
            $mealType = $em->getRepository('HomieBundle:Meal_type')->findOneById($mealTypeId);
            $photoId = $request->request->get('photo_id');

            $photo = $em->getRepository('HomieBundle:Photo')->findOneById($photoId);

            $meal->setName($name);
            $meal->setDescription($description);
            $meal->setDelay($delay);
            $meal->setMealType($mealType);
            $meal->setPhoto($photo);
            $meal->setPrice($price);


            $em->persist($meal);
            $em->flush();

            $meals = $em->getRepository('HomieBundle:Meal')->findAll();

            $meal = $meals[count($meals)-1];

            $encoders = array(new JsonEncoder()) ;
            $normalizer = array(new ObjectNormalizer()) ;
            $serializer = new Serializer($normalizer, $encoders);

            $jsonmeal = $serializer->serialize($meal, 'json');

            $response = new response($jsonmeal);

            $response->headers->set('Content-Type', 'application/json');


            return $response;
        }
    }

    public function deleteMealAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $id = $request->query->get('id');

        $meal = $em->getRepository('HomieBundle:Meal')->findOneById($id);

        $idPhoto = $meal->getPhoto()->getId();
        $photo = $em->getRepository('HomieBundle:Photo')->findOneById($idPhoto);
        $url = $photo->getUrl();

        $path = $this->getParameter('photo_directory')."/".$url;
        if ($path !== null) {
            unlink($path);
        }

        $em->remove($meal);
        $em->remove($photo);

        $em->flush();

        return new response('La vignette a bien été supprimer');
    }

    public function editMealFormAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $id = $request->query->get('id');
        $meal = $em->getRepository('HomieBundle:Meal')->findOneById($id);
        $formMeal = $this->createForm("HomieBundle\Form\MealType", $meal);
        $photo = $meal->getPhoto();
        $formPhoto = $this->createForm("HomieBundle\Form\PhotoType", $photo);

        return $this->render('HomieBundle:Admin:admin_meal_edit.html.twig', array(
            'formMeal' => $formMeal->createView(),
            'formPhoto' => $formPhoto->createView(),
            'meal' => $meal,
        ));
    }

    public function editMealAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('homiebundle_meal')['id'];
        $meal = $em->getRepository('HomieBundle:Meal')->findOneById($id);

        if($request->isXmlHttpRequest()) {
            $name = $request->request->get('homiebundle_meal')['name'];
            $description = $request->request->get('homiebundle_meal')['description'];
            $delay = $request->request->get('homiebundle_meal')['delay'];
            $price = $request->request->get('homiebundle_meal')['price'];
            $mealTypeId = $request->request->get('homiebundle_meal')['meal_type'];
            $mealType = $em->getRepository('HomieBundle:Meal_type')->findOneById($mealTypeId);
            $photoId = $request->request->get('photo_id');

            $photo = $em->getRepository('HomieBundle:Photo')->findOneById($photoId);
            if ($photo !== null) {
                $meal->setPhoto($photo);
            }
            $meal->setName($name);
            $meal->setDescription($description);
            $meal->setDelay($delay);
            $meal->setMealType($mealType);
            $meal->setPrice($price);


            $em->persist($meal);
            $em->flush();

            $meals = $em->getRepository('HomieBundle:Meal')->findAll();

            $meal = $meals[count($meals)-1];

            $encoders = array(new JsonEncoder()) ;
            $normalizer = array(new ObjectNormalizer()) ;
            $serializer = new Serializer($normalizer, $encoders);

            $jsonmeal = $serializer->serialize($meal, 'json');

            $response = new response($jsonmeal);

            $response->headers->set('Content-Type', 'application/json');


            return $response;
        }
    }

    public function showCheckoutAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $valid = $em->getRepository('HomieBundle:Confirm')->findOneById(2);

        $checkouts = $em->getRepository('HomieBundle:Checkout')->findByConfirm($valid);
        $checkoutSorts = [];
        foreach ($checkouts as $checkout) {
            $userId = $checkout->getClient()->getId();
            $checkoutSorts[$userId][] = $checkout;
        }

        return $this->render('@Homie/Admin/admin_home.html.twig',array(
                'checkoutSorts' => $checkoutSorts
        ));
    }

    public function confirmCheckoutAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $userId = $request->query->get('id');
        $valid = $em->getRepository('HomieBundle:Confirm')->findOneById(3);
        $user = $em->getRepository('HomieBundle:User')->findOneById($userId);
        $checkouts = $em->getRepository('HomieBundle:Checkout')->findByClient($user);

        foreach ($checkouts as $checkout) {
            $checkout->setConfirm($valid);
        }
        $em->flush();
        $response = new Response("commande confirmée");
        return $response;
    }
}
