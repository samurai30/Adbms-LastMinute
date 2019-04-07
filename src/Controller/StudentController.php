<?php

namespace App\Controller;

use App\Entity\Questions;
use App\Form\QuestionsFilterType;
use App\Form\StudentFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdater;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{


    /**
     * @var FilterBuilderUpdater
     */
    private $builderUpdater;

    public function __construct(FilterBuilderUpdater $builderUpdater )
    {
        $this->builderUpdater = $builderUpdater;
    }

    /**
     * @Route("/student", name="student")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filterBuilder = $this->getDoctrine()->getRepository(Questions::class)->createQueryBuilder('e');
        $form = $this->createForm(QuestionsFilterType::class,null,['user' => $this->getUser()]);

        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $this->builderUpdater->addFilterConditions($form,$filterBuilder);
            $ques =  $filterBuilder->getQuery()->getResult();
            dump($ques);
        }




        return $this->render('student/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
