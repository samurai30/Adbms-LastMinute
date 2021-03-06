<?php

namespace App\Controller;

use App\Entity\Students;
use App\Form\StudentsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomepageController extends AbstractController
{


    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    /**
     * @Route("/",name="homepage")
     */
    public function index(){

        return $this->render('homepage/index.html.twig');

    }


    /**
     * @Route("/register/student", name="studentRegister")
     * @param Request $request
     * @return Response
     */
    public function studentRegister(Request $request)
    {
        $student = new Students();
        $form = $this->createForm(StudentsType::class,$student);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $password = $student->getPlainPassword();

            $student->setPassword($this->encoder->encodePassword($student,$password));
            $student->setRoles(['ROLE_USER']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();

            return $this->redirectToRoute('SecuredLogin');


        }

        return $this->render('Register/student.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
