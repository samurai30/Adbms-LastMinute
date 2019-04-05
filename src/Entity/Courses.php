<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CoursesRepository")
 * @UniqueEntity(fields="courseName", message="This course is already there")\
 */
class Courses
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
    private $courseName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Subjects", mappedBy="course", orphanRemoval=true)
     */
    private $subjects;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Students", mappedBy="course", orphanRemoval=true)
     */
    private $students;

    public function __construct()
    {
        $this->subjects = new ArrayCollection();
        $this->students = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourseName(): ?string
    {
        return $this->courseName;
    }

    public function setCourseName(string $courseName): self
    {
        $this->courseName = $courseName;

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
            $subject->setCourse($this);
        }

        return $this;
    }

    public function removeSubject(Subjects $subject): self
    {
        if ($this->subjects->contains($subject)) {
            $this->subjects->removeElement($subject);
            // set the owning side to null (unless already changed)
            if ($subject->getCourse() === $this) {
                $subject->setCourse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Students[]
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Students $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
            $student->setCourse($this);
        }

        return $this;
    }

    public function removeStudent(Students $student): self
    {
        if ($this->students->contains($student)) {
            $this->students->removeElement($student);
            // set the owning side to null (unless already changed)
            if ($student->getCourse() === $this) {
                $student->setCourse(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->courseName;
    }
}
