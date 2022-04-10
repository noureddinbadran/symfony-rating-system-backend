<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $creator_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $vico_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @var \Vico
     *
     * @ORM\ManyToOne(targetEntity="Vico")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="vico_id", referencedColumnName="id")
     * })
     */
    private $vico;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Member")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="creator_id", referencedColumnName="id")
     * })
     */
    private $creator;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatorId(): ?int
    {
        return $this->creator_id;
    }

    public function setCreatorId(int $creator_id): self
    {
        $this->creator_id = $creator_id;

        return $this;
    }

    public function getVicoId(): ?int
    {
        return $this->vico_id;
    }

    public function setVicoId(int $vico_id): self
    {
        $this->vico_id = $vico_id;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getVico(): ?Vico
    {
        return $this->vico;
    }

    public function setVico(?Vico $vico): self
    {
        $this->vico = $vico;

        return $this;
    }

    public function getCreator(): ?Member
    {
        return $this->creator;
    }

    public function setCreator(?Member $creator): self
    {
        $this->creator = $creator;

        return $this;
    }
}
