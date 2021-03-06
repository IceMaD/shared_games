<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
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
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private ?string $emoji;

    /**
     * @ORM\ManyToMany(targetEntity=Game::class, mappedBy="tags")
     */
    private Collection $games;

    public function __construct(string $name)
    {
        $this->games = new ArrayCollection();
        $this->name = $name;
        $this->id = null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmoji(): ?string
    {
        return $this->emoji;
    }

    public function setEmoji(string $emoji): void
    {
        $this->emoji = $emoji;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getGames(): Collection
    {
        return $this->games;
    }

    public function removeGame(Game $game): self
    {
        $this->games->removeElement($game);

        return $this;
    }
}
