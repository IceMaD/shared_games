<?php

namespace App\Twig;

use Twig\ExpressionParser;
use Twig\Extension\AbstractExtension;

class TemplateExtension extends AbstractExtension
{
    public function getOperators()
    {
        return [
            [],
            [
                'has' => [
                    'precedence' => 50,
                    'class' => HasExpression::class,
                    'associativity' => ExpressionParser::OPERATOR_LEFT,
                ],
            ],
        ];
    }
}
