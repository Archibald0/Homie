<?php

namespace HomieBundle\Controller;

use HomieBundle\Entity\Meal;
use HomieBundle\Entity\Meal_type;
use HomieBundle\Entity\Photo;
use HomieBundle\Entity\User;
use HomieBundle\Form\MealType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class AdminController
 * @package HomieBundle\Controller
 */
class AdminController extends Controller
{
    // --------- COOKER ADMIN ---------- //

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function indexCookerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $cookers = $em->getRepository('HomieBundle:User')->findBy(
            array('userGroup' => '2'),
            array('username' => 'desc')
            );
        $cooker = new User();
        $cookerType = $em->getRepository('HomieBundle:UserGroup')->findOneByName('cook');

        $formCooker = $this->createForm("HomieBundle\Form\CookerType", $cooker);

        $formCooker->handleRequest($request);

        if($formCooker->isSubmitted() && $formCooker->isValid()) {
            $cooker->setUserGroup($cookerType);
            $cooker->addRole('ROLE_COOKER');
            $cooker->setEnabled(1);
            $cooker->setOnline(0);

            $em->persist($cooker);
            $em->flush();

            return $this->redirectToRoute("homie_admin_cooker");
        }

        return $this->render('HomieBundle:Admin:admin_cooker.html.twig', array(
            'formCooker' => $formCooker->createView(),
            'cookers' => $cookers,
        ));
    }

    /**
     * @param Request $request
     * @return Response
     */
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

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editCookerFormAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $id = $request->query->get('id');
        $cooker = $em->getRepository('HomieBundle:User')->findOneById($id);
        $formCooker = $this->createForm("HomieBundle\Form\CookerType", $cooker);

        $formCooker->handleRequest($request);

        if ($formCooker->isSubmitted() && $formCooker->isValid()) {
            $em->flush();
            return $this->redirectToRoute('homie_admin_cooker');
        }

        return $this->render('HomieBundle:Admin:admin_cooker_edit.html.twig', array(
            'formCooker' => $formCooker->createView(),
            'cooker' => $cooker,
        ));
    }

    // ------------ MEAL ADMIN ------------ //

    /**
     * @param Request $request
     * @return Response
     */
    public function indexMealAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $meals = $em->getRepository('HomieBundle:Meal')->findBy(array(), array('name' => 'asc'));
        $meal = new Meal();
        $mealType = new Meal_type();
        $photo = new Photo();
        $mealTypes = $em->getRepository('HomieBundle:Meal_type')->findAll();

        $formPhoto = $this->createForm("HomieBundle\Form\PhotoType", $photo);
        $formMeal = $this->createForm("HomieBundle\Form\MealType", $meal);
        $formMealType = $this->createForm("HomieBundle\Form\Meal_typeType", $mealType);

        return $this->render('@Homie/Admin/admin_meal.html.twig', array(
            'formMeal' => $formMeal->createView(),
            'formPhoto' => $formPhoto->createView(),
            'formMealType' => $formMealType->createView(),
            'meals' => $meals,
            'mealTypes' => $mealTypes
        ));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function addMealAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $meal = new Meal();
        $formMeal = $this->createForm(MealType::class, $meal);
        $formMeal->handleRequest($request);

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

    /**
     * @param Request $request
     * @return Response
     */
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

    /**
     * @param Request $request
     * @return Response
     */
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

    /**
     * @param Request $request
     * @return Response
     */
    public function editMealAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('id');

        $meal = $em->getRepository('HomieBundle:Meal')->findOneById($id);

        $formMeal = $this->createForm(MealType::class, $meal);
        $formMeal->handleRequest($request);

        if($request->isXmlHttpRequest()) {

            $photoId = $request->request->get('photo_id');

            $photo = $em->getRepository('HomieBundle:Photo')->findOneById($photoId);
            if ($photo !== null) {
                $meal->setPhoto($photo);
            }

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

    /**
     * @param Request $request
     * @return Response
     */
    public function addMealTypeAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $mealType = new Meal_type();

        if($request->isXmlHttpRequest()) {
            $name = $request->request->get('homiebundle_meal_type')['name'];

            $mealType->setName($name);

            $em->persist($mealType);
            $em->flush();

            $mealTypes = $em->getRepository('HomieBundle:Meal_type')->findAll();

            $mealType = $mealTypes[count($mealTypes)-1];

            $encoders = array(new JsonEncoder()) ;
            $normalizer = array(new ObjectNormalizer()) ;
            $serializer = new Serializer($normalizer, $encoders);

            $jsonmealType = $serializer->serialize($mealType, 'json');

            $response = new response($jsonmealType);

            $response->headers->set('Content-Type', 'application/json');


            return $response;
        }
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function deleteMealTypeAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $id = $request->query->get('id');

        $mealType = $em->getRepository('HomieBundle:Meal_type')->findOneById($id);


        $em->remove($mealType);

        $em->flush();

        return new response('Ok');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function showCheckoutAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $valid = $em->getRepository('HomieBundle:Confirm')->findOneById(2);
        $validCook = $em->getRepository('HomieBundle:Confirm')->findOneById(4);

        $checkouts = $em->getRepository('HomieBundle:Checkout')->findByConfirm($valid);
        $checkoutCooks = $em->getRepository('HomieBundle:Checkout')->findByConfirm($validCook);
        $checkoutSorts = [];
        $checkoutCookSorts = [];

        foreach ($checkouts as $checkout) {
            $userId = $checkout->getClient()->getId();
            $checkoutSorts[$userId][] = $checkout;
        }

        foreach ($checkoutCooks as $checkout) {
            $userId = $checkout->getClient()->getId();
            $checkoutCookSorts[$userId][] = $checkout;
        }

        return $this->render('@Homie/Admin/admin_home.html.twig',array(
                'checkoutSorts' => $checkoutSorts,
                'checkoutCookSorts' => $checkoutCookSorts
        ));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function confirmCheckoutAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $userId = $request->query->get('id');
        $valid = $em->getRepository('HomieBundle:Confirm')->findOneById(3);
        $user = $em->getRepository('HomieBundle:User')->findOneById($userId);
        $checkouts = $em->getRepository('HomieBundle:Checkout')->findcheckoutbyConfirmedClient($user);
        $date = new \DateTime();

        foreach ($checkouts as $checkout) {
            $cook = $checkout->getCook();
            $cookName = $cook->getUsername();
            $cookMail = $cook->getEmail();
            $mails[$cookMail] = $cookName;
        }

        /*$message = new \Swift_Message('New purchase !');
        $message
            ->setFrom('homie.homie.contact@gmail.com')
            ->setTo($mails)
            ->setBody(
                $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                    'Emails/adminToCook.html.twig',
                    array(
                    )
                ),
                'text/html'
            )
        ;*/

        foreach ($checkouts as $checkout) {
            $checkout->setConfirm($valid);
            $checkout->setDateConfirmAdmin($date);
        }

        $em->flush();

        /*$this->get('mailer')->send($message);*/

        $response = new Response("commande confirmée");

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function deliveryCheckoutAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $userId = $request->query->get('id');
        $valid = $em->getRepository('HomieBundle:Confirm')->findOneById(5);
        $checkouts = $em->getRepository('HomieBundle:Checkout')->findCheckoutCookConfirmed($userId);
        $date = new \DateTime();

        foreach ($checkouts as $checkout) {
            $checkout->setConfirm($valid);
            $checkout->setDateDelivery($date);
        }

        $em->flush();
        $response = new Response("Delivery Done!");

        return $response;
    }
}
