<?php

namespace App\Form\EditTagEmoji;

use App\Entity\Tag;
use App\Form\EmojiObject;

class EditEmojiObject
{
    public ?EmojiObject $emoji;

    public static function fromTag(Tag $tag): self
    {
        $emojiObject = new EmojiObject();
        $emojiObject->emoji = $tag->getEmoji() ?? '❌';

        $editEmojiObject = new self();
        $editEmojiObject->emoji = $emojiObject;

        return $editEmojiObject;
    }
}
