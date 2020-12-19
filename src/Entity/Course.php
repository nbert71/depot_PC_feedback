<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CourseRepository::class)
 */
class Course
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Course::class, inversedBy="children")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Course::class, mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isUE;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isOptionGroup;

    /**
     * @ORM\OneToMany(targetEntity=Feedback::class, mappedBy="course")
     */
    private $feedback;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->feedback = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setCourse($this);
        }

        return $this;
    }

    public function removeChild(self $child): self
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getCourse() === $this) {
                $child->setCourse(null);
            }
        }

        return $this;
    }

    public function getIsUE(): ?bool
    {
        return $this->isUE;
    }

    public function setIsUE(bool $isUE): self
    {
        $this->isUE = $isUE;

        return $this;
    }

    public function getIsOptionGroup(): ?bool
    {
        return $this->isOptionGroup;
    }

    public function setIsOptionGroup(bool $isOptionGroup): self
    {
        $this->isOptionGroup = $isOptionGroup;

        return $this;
    }

    /**
     * @return Collection|Feedback[]
     */
    public function getFeedback(): Collection
    {
        return $this->feedback;
    }

    public function addFeedback(Feedback $feedback): self
    {
        if (!$this->feedback->contains($feedback)) {
            $this->feedback[] = $feedback;
            $feedback->setCourse($this);
        }

        return $this;
    }

    public function removeFeedback(Feedback $feedback): self
    {
        if ($this->feedback->removeElement($feedback)) {
            // set the owning side to null (unless already changed)
            if ($feedback->getCourse() === $this) {
                $feedback->setCourse(null);
            }
        }

        return $this;
    }
}
