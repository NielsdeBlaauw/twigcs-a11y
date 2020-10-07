<?php

namespace NdB\TwigCSA11Y;

use Allocine\Twigcs\Ruleset\RulesetInterface;
use Allocine\Twigcs\Validator\Violation;
use NdB\TwigCSA11Y\Rules\BannedHTMLTags;

class Ruleset implements RulesetInterface
{
    public function getRules()
    {
        return [
           new BannedHTMLTags(Violation::SEVERITY_ERROR)
        ];
    }
}
