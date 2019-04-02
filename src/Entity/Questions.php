<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionsRepository")
 */
class Questions
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $question;


    /**
     * @ORM\Column(type="float")
     */
    private $marks;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tags", mappedBy="questions")
     */
    private $tags;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Chapters", inversedBy="questions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $chapter;

    /**
     * @ORM\Column(type="text")
     */
    private $answers;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }
    

    public function getMarks(): ?float
    {
        return $this->marks;
    }

    public function setMarks(float $marks): self
    {
        $this->marks = $marks;

        return $this;
    }

    /**
     * @return Collection|Tags[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tags $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addQuestion($this);
        }

        return $this;
    }

    public function removeTag(Tags $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
            $tag->removeQuestion($this);
        }

        return $this;
    }

    public function getChapter(): ?Chapters
    {
        return $this->chapter;
    }

    public function setChapter(?Chapters $chapter): self
    {
        $this->chapter = $chapter;

        return $this;
    }

    public function getAnswers(): ?string
    {
        return $this->answers;
    }

    public function setAnswers(string $answers): self
    {
        $this->answers = $answers;

        return $this;
    }


}
