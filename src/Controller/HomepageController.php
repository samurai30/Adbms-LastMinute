<?php

namespace App\Controller;

use App\Entity\Students;
use App\Form\StudentFormType;
use App\Form\StudentsType;
use NlpTools\Similarity\CosineSimilarity;
use NlpTools\Similarity\Euclidean;
use NlpTools\Tokenizers\WhitespaceTokenizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Route("/test", name="trying")
     * @param Request $request
     * @return void
     */
    public function test(Request $request){

        $cos = new CosineSimilarity();
        $tk1 = new WhitespaceTokenizer();
        $stn1 = 'what is the meaning of semantics';
        $stn2 = 'define semantics';
        $tk = $tk1->tokenize($stn1);
        $tk2 = $tk1->tokenize($stn2);

        dump($cos->similarity($tk,$tk2));
         die;
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

            return $this->redirectToRoute('studentLogin');


        }

        return $this->render('Register/student.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
