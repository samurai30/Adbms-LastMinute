<?php

namespace App\Controller;

use App\Entity\Chapters;
use App\Entity\Questions;
use App\Entity\Subjects;
use App\Entity\Tags;
use App\Form\AddQuestionsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    /**
     * @Route("/teacher/scan", name="scanPaper")
     */
    public function index()
    {
        return $this->render('teacher/index.html.twig', [
            'controller_name' => 'TeacherController',
        ]);
    }

    /**
     * @Route("/teacher/manual", name="manualAdd")
     * @param Request $request
     * @return Response
     */

    public function manual(Request $request){
        $questions = new Questions();
        $form = $this->createForm(AddQuestionsType::class,$questions,['user' => $this->getUser()]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() ){
            $em = $this->getDoctrine()->getManager();
            /*$chapterId = $request->request->get('add_questions')['chapter'];
            $chapter = $em->getRepository(Chapters::class)->find($chapterId);
            $questions->setChapter($chapter);*/
            $jsonText = $request->request->get('chipsData');
            $decodedText = html_entity_decode($jsonText);
            $myArray = json_decode($decodedText, true);
            foreach ($myArray as $item){

               foreach ($item as $value){
                    $tags = new Tags();
                    $tags->setTagName($value);
                    $tags->addQuestion($questions);
                    $em->persist($tags);
               }
            }
            $em->persist($questions);
            $em->flush();

            return $this->json( 'success'  , Response::HTTP_OK);

        }

        return $this->render('teacher/manual.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/test")
     */
    public function test(){
        dump($this->getDoctrine()->getRepository(Subjects::class)->getSubject(5)); die;
    }

}
