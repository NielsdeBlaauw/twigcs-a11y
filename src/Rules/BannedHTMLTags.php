<?php

namespace NdB\TwigCSA11Y\Rules;

use FriendsOfTwig\Twigcs\Rule\AbstractRule;
use FriendsOfTwig\Twigcs\Rule\RuleInterface;
use FriendsOfTwig\Twigcs\TwigPort\Token as TwigToken;
use FriendsOfTwig\Twigcs\TwigPort\TokenStream;

class BannedHTMLTags extends AbstractRule implements RuleInterface
{
    private const BANNED_TAGS = [
        'blink' => '/<\/?blink>/U',
        'marquee' => '/<\/?marquee(.)*>/U'
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
        $violations = [];

        while (!$tokens->isEOF()) {
            $token = $tokens->getCurrent();

            if ($token->getType() === TwigToken::TEXT_TYPE) {
                foreach (self::BANNED_TAGS as $tag => $test) {
                    $matches = [];
                    if (preg_match($test, (string) $token->getValue(), $matches)) {
                        /**
                         * @psalm-suppress InternalMethod
                         * @psalm-suppress UndefinedPropertyFetch
                         */
                        $violations[] = $this->createViolation(
                            (string) $tokens->getSourceContext()->getPath(),
                            $token->getLine(),
                            $token->getColumn(),
                            sprintf('[A11Y.BannedHTMLTags] Invalid tag \'%1$s\'. Found `%2$s`.', $tag, $matches[0])
                        );
                    }
                }
            }

            $tokens->next();
        }
        return $violations;
    }
}
