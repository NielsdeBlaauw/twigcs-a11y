<?php

namespace NdB\TwigCSA11Y\Rules;

use FriendsOfTwig\Twigcs\Rule\AbstractRule;
use FriendsOfTwig\Twigcs\Rule\RuleInterface;
use FriendsOfTwig\Twigcs\TwigPort\TokenStream;
use Twig\Token as TwigToken;

class AriaRoles extends AbstractRule implements RuleInterface
{
    const VALID_ROLES = [
        "article", "banner", "complementary", "main", "navigation", "region",
        "search", "contentinfo", "alert", "alertdialog", "application",
        "dialog", "group", "log", "marquee", "menu", "menubar", "menuitem",
        "menuitemcheckbox", "menuitemradio", "progressbar", "separator",
        "slider", "spinbutton", "status", "tab", "tablist", "tabpanel",
        "timer", "toolbar", "tooltip", "tree", "treegrid", "treeitem",
        "button", "button", "checkbox", "columnheader", "combobox",
        "contentinfo", "form", "grid", "gridcell", "heading", "img", "link",
        "listbox", "listitem", "option", "radio", "radiogroup", "row",
        "rowgroup", "rowheader", "scrollbar", "textbox", "document",
        "application", "presentation", "math", "definition", "note", "directory"
    ];

    const ABSTRACT_ROLES = [
        "command", "composite", "input", "landmark", "range", "section",
        "sectionhead", "select", "structure", "widget"
    ];

    /**
     * @var \FriendsOfTwig\Twigcs\Validator\Violation[]
     */
    protected $violations = [];

    /**
     * @param int $severity
     */
    public function __construct($severity)
    {
        parent::__construct($severity);
        $this->violations = [];
    }

    public function check(TokenStream $tokens)
    {
        while (!$tokens->isEOF()) {
            $token = $tokens->getCurrent();

            if ($token->getType() === TwigToken::TEXT_TYPE) {
                $matches = [];
                $textToAnalyse = (string) $token->getValue();
                $terminated  = false;
                $tokenIndex = 1;
                while (!$terminated) {
                    $nextToken = $tokens->look($tokenIndex);
                    if ($nextToken->getType() !== TwigToken::ARROW_TYPE) {
                        $textToAnalyse .= (string) $nextToken->getValue();
                    }
                    if ($nextToken->getType() === TwigToken::TEXT_TYPE
                        || $nextToken->getType() === TwigToken::EOF_TYPE
                    ) {
                        $terminated = true;
                    }
                    $tokenIndex++;
                }
                if (preg_match(
                    "/role=((.)+)([>'\" ]+)/U",
                    $textToAnalyse,
                    $matches
                )
                ) {
                    $value = preg_replace('/[^\da-z]/i', '', $matches[1]);
                    if (! in_array($value, self::VALID_ROLES, true)) {
                        if (in_array($value, self::ABSTRACT_ROLES, true)) {
                            /**
                             * @psalm-suppress InternalMethod
                             * @psalm-suppress UndefinedPropertyFetch
                             */
                            $this->addViolation(
                                (string) $tokens->getSourceContext()->getPath(),
                                $token->getLine(),
                                $token->columnno,
                                sprintf(
                                    '[A11Y.AriaRoles] Invalid abstract \'role\' value. Found `%1$s`.',
                                    trim($matches[0])
                                )
                            );
                        } else {
                            /**
                             * @psalm-suppress InternalMethod
                             * @psalm-suppress UndefinedPropertyFetch
                             */
                            $this->addViolation(
                                (string) $tokens->getSourceContext()->getPath(),
                                $token->getLine(),
                                $token->columnno,
                                sprintf(
                                    '[A11Y.AriaRoles] Invalid \'role\'. Role must have a valid value. Found `%1$s`.',
                                    trim($matches[0])
                                )
                            );
                        }
                    }
                }
            }

            $tokens->next();
        }
        return $this->violations;
    }
}
