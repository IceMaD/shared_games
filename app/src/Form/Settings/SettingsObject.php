<?php

namespace App\Form\Settings;

use App\Entity\User;

class SettingsObject
{
    public string $pseudo;

    public function __construct(string $pseudo = '')
    {
        $this->pseudo = $pseudo;
    }

    public static function fromUser(User $user): self
    {
        return new self($user->getPseudo());
    }
}
