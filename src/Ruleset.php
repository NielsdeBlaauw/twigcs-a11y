<?php

namespace NdB\TwigCSA11Y;

use Allocine\Twigcs\Ruleset\RulesetInterface;
use Allocine\Twigcs\Validator\Violation;
use NdB\TwigCSA11Y\Rules\BannedHTMLTags;
use NdB\TwigCSA11Y\Rules\TabIndex;

class Ruleset implements RulesetInterface
{
    public function getRules()
    {
        return [
            new BannedHTMLTags(Violation::SEVERITY_ERROR),
            new TabIndex(Violation::SEVERITY_ERROR)
        ];
    }
}
