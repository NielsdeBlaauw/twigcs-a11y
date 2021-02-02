<?php

namespace NdB\TwigCSA11Y;

use FriendsOfTwig\Twigcs\Ruleset\RulesetInterface;
use FriendsOfTwig\Twigcs\Validator\Violation;
use NdB\TwigCSA11Y\Rules\AriaRoles;
use NdB\TwigCSA11Y\Rules\BannedHTMLTags;
use NdB\TwigCSA11Y\Rules\TabIndex;

class Ruleset implements RulesetInterface
{
    public function __construct(int $twigMajorVersion)
    {

    }

    public function getRules()
    {
        return [
            new BannedHTMLTags(Violation::SEVERITY_ERROR),
            new TabIndex(Violation::SEVERITY_ERROR),
            new AriaRoles(Violation::SEVERITY_ERROR)
        ];
    }
}
