<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="games")
     */
    private Collection $games;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="games")
     */
    private Collection $users;

    public function __construct()
    {
        $this->games = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getGames(): ArrayCollection
    {
        return $this->games;
    }

    public function getUsers(): ArrayCollection
    {
        return $this->users;
    }
}
