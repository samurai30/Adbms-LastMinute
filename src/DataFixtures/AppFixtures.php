<?php

namespace App\DataFixtures;

use App\Entity\Chapters;
use App\Entity\Courses;
use App\Entity\Questions;
use App\Entity\Semester;
use App\Entity\Subjects;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    private const questions=[
        ['ques'=> 'hello?',
            'mark' => 2,
            'ans' => 'bello'],
        ['ques'=> 'kello?',
            'mark' => 4,
            'ans' => 'na'],
        ['ques'=> 'korta?',
            'mark' => 5,
            'ans' => 'hoi'],
        ['ques'=> 'palo?',
            'mark' => 3,
            'ans' => 'coffee'],
        ['ques'=> 'toffee?',
            'mark' => 3,
            'ans' => 'NO']
    ];

    private const course = ['MCA','MSC-IT','BCA','MBA'];
    private const chapter = ['Dinchak','Pinchak'];
    private const Subject = ['DBMS','NLP','DATA-MINING'];
    private const Sem = ['sem-I','sem-II','sem-III'];
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->loadCourse($manager);
        $this->loadSem($manager);
        $this->loadSubject($manager);
        $this->loadChapters($manager);
        $this->loadQues($manager);
        $manager->flush();
    }

    private function loadCourse(ObjectManager $manager){
        foreach (self::course as $item){
            $course = new Courses();
            $course->setCourseName($item);
            $this->addReference($item,$course);
            $manager->persist($course);
        }
    }

    private function loadSem(ObjectManager $manager){

        foreach (self::Sem as $item){
            $sem = new Semester();
            $sem->setSemName($item);
            $this->addReference($item,$sem);
            $manager->persist($sem);

        }
    }

    private function loadSubject(ObjectManager $manager){

        foreach (self::Subject as $item){

            $sub = new Subjects();
            $sub->setSubName($item);
            $sub->setSem($this->getReference(self::Sem[rand(0,count(self::Sem)-1)]));
            $sub->setCourse($this->getReference(self::course[rand(0,count(self::course)-1)]));

            $this->addReference($item,$sub);
            $manager->persist($sub);

        }

    }

    private function loadChapters(ObjectManager $manager){

        foreach (self::chapter as $item){
            $chap = new Chapters();
            $chap->setChapterName($item);
            $chap->setSubject($this->getReference(self::Subject[rand(0,count(self::Subject)-1)]));
            $this->addReference($item,$chap);
            $manager->persist($chap);
        }


    }


    private function loadQues(ObjectManager $manager){
        foreach (self::questions as $question){
            $AddQues = new Questions();
            $AddQues->setQuestion($question['ques']);
            $AddQues->setAnswers($question['ans']);
            $AddQues->setMarks($question['mark']);
            $AddQues->setChapter($this->getReference(self::chapter[rand(0,count(self::chapter)-1)]));
            $manager->persist($AddQues);
        }
    }
}
