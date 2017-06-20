<?php

namespace HomieBundle\Controller;

use HomieBundle\Entity\Photo;
use HomieBundle\Entity\User;
use HomieBundle\Repository\UserGroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction() {
        return $this->render('@Homie/Default/index.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function signUpClientAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $user->addRole('ROLE_CLIENT');
        $user->setEnabled(1);
        $user->setOnline(0);

        $formUser = $this->createForm('HomieBundle\Form\ClientType', $user);

        $formUser->handleRequest($request);

        if($formUser->isSubmitted() && $formUser->isValid()) {
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('homie_client_home');
        }

        return $this->render('@Homie/Default/client_signup.html.twig', array(
            'formUser' => $formUser->createView(),
        ));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function addPhotoAction(Request $request) {
        $photo = new Photo();

        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();

            //crea
            $file = $request->files->get('homiebundle_photo')['url'];
            $alt = $request->request->get('homiebundle_photo')['alt'];

            $fileName = uniqId() . '.' . $file->guessExtension();

            $file->move($this->getParameter('photo_directory'), $fileName);

            $photo->setUrl($fileName);
            $photo->setAlt($alt);

            $em->persist($photo);
            $em->flush();

            //recup
            $photo = $em->getRepository('HomieBundle:Photo')->findOneByUrl($fileName);

            $encoders = array(new JsonEncoder()) ;
            $normalizer = array(new ObjectNormalizer()) ;
            $serializer = new Serializer($normalizer, $encoders);

            $jsonPhoto = $serializer->serialize($photo, 'json');

            $response = new response($jsonPhoto);

            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }
    }
}
