<?php

namespace App\Form\EditGamePrice;

use App\Entity\Game;

class EditGamePriceObject
{
    private int $price;

    public static function fromGame(Game $game): self
    {
        return (new self())->setPrice($game->getPrice() ?? 10);
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }
}
