<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SemesterRepository")
 */
class Semester
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $SemName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Subjects", mappedBy="sem", orphanRemoval=true)
     */
    private $subjects;

    public function __construct()
    {
        $this->subjects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSemName(): ?string
    {
        return $this->SemName;
    }

    public function setSemName(string $SemName): self
    {
        $this->SemName = $SemName;

        return $this;
    }

    /**
     * @return Collection|Subjects[]
     */
    public function getSubjects(): Collection
    {
        return $this->subjects;
    }

    public function addSubject(Subjects $subject): self
    {
        if (!$this->subjects->contains($subject)) {
            $this->subjects[] = $subject;
            $subject->setSem($this);
        }

        return $this;
    }

    public function removeSubject(Subjects $subject): self
    {
        if ($this->subjects->contains($subject)) {
            $this->subjects->removeElement($subject);
            // set the owning side to null (unless already changed)
            if ($subject->getSem() === $this) {
                $subject->setSem(null);
            }
        }

        return $this;
    }
}
