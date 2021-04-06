<?php

namespace App\Twig;

use App\Entity\Game;
use App\Entity\User;
use Twig\Compiler;
use Twig\Node\Expression\Binary\AbstractBinary;

class HasExpression extends AbstractBinary
{
    public static function has(User $user, Game $game)
    {
        return $user->getGames()->contains($game);
    }

    public function compile(Compiler $compiler): void
    {
        $compiler
            ->raw('\App\Twig\HasExpression::has(')
            ->subcompile($this->getNode('left'))
            ->raw(', ')
            ->subcompile($this->getNode('right'))
            ->raw(')');
    }

    public function operator(Compiler $compiler): Compiler
    {
        return $compiler->raw('in');
    }
}
