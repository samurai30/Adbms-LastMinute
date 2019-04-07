<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChaptersRepository")
 */
class Chapters
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Please enter chapter name")
     */
    private $chapterName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Subjects", inversedBy="chapters")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Select a subject")
     */
    private $subject;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Questions", mappedBy="chapter", orphanRemoval=true)
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

    public function getChapterName(): ?string
    {
        return $this->chapterName;
    }

    public function setChapterName(string $chapterName): self
    {
        $this->chapterName = $chapterName;

        return $this;
    }

    public function getSubject(): ?Subjects
    {
        return $this->subject;
    }

    public function setSubject(?Subjects $subject): self
    {
        $this->subject = $subject;

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
            $question->setChapter($this);
        }

        return $this;
    }

    public function removeQuestion(Questions $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            // set the owning side to null (unless already changed)
            if ($question->getChapter() === $this) {
                $question->setChapter(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->chapterName;
    }
}
