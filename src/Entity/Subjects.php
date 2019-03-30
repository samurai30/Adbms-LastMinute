<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubjectsRepository")
 */
class Subjects
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $subName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Courses", inversedBy="subjects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $course;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Semester", inversedBy="subjects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sem;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Questions", mappedBy="subject", orphanRemoval=true)
     */
    private $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubName(): ?string
    {
        return $this->subName;
    }

    public function setSubName(string $subName): self
    {
        $this->subName = $subName;

        return $this;
    }

    public function getCourse(): ?Courses
    {
        return $this->course;
    }

    public function setCourse(?Courses $course): self
    {
        $this->course = $course;

        return $this;
    }

    public function getSem(): ?Semester
    {
        return $this->sem;
    }

    public function setSem(?Semester $sem): self
    {
        $this->sem = $sem;

        return $this;
    }

    /**
     * @return Collection|Questions[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Questions $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setSubject($this);
        }

        return $this;
    }

    public function removeQuestion(Questions $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            // set the owning side to null (unless already changed)
            if ($question->getSubject() === $this) {
                $question->setSubject(null);
            }
        }

        return $this;
    }
}
