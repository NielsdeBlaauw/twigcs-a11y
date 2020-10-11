# twigcs-a11y
This is a [TwigCS](https://github.com/friendsoftwig/twigcs) accessibility ruleset. It statically checks twig templates for 
known accessibility issues. 

The ruleset is inspired by [Deque's Axe Linter](https://axe-linter.deque.com/)

**Note:** *Automated tests do not guarantee your site is accessible. Manual testing is the 
only way to make sure.*

Want to learn more about creating accessible websites? Check out [The A11Y Collective](https://a11y-collective.com/).

## Installation
`composer require --dev nielsdeblaauw/twigcs-a11y`

## Use
`vendor/bin/twigcs --ruleset \\NdB\\TwigCSA11Y\\Ruleset`


**Example Output**
```
./tests/test.twig
l.2 c.0 : ERROR [A11Y.TabIndex] Invalid 'tabindex'. Tabindex must be 0 or -1. Found `tabindex=1>.`
l.12 c.20 : ERROR [A11Y.TabIndex] Invalid 'tabindex'. Tabindex must be 0 or -1. Found `tabindex=test.`
l.12 c.53 : ERROR [A11Y.TabIndex] Invalid 'tabindex'. Tabindex must be 0 or -1. Found `tabindex='test'.`
l.16 c.0 : ERROR [A11Y.BannedHTMLTags] Tag 'marquee' is dissallowed. Found `<marquee>`.
l.18 c.0 : ERROR [A11Y.BannedHTMLTags] Tag 'blink' is dissallowed. Found `<blink>`.
5 violation(s) found
```

For additional options read the [TwigCS documentation](https://github.com/friendsoftwig/twigcs).

## Rules
The following rules are implemented as part of this ruleset.

### TabIndex
**[Axe Tabindex rule description.](https://dequeuniversity.com/rules/axe/3.5/tabindex)**

Using a non `0` or `-1` value for tabindex results in unexpected behaviour for keyboard users. Variables in the tabindex property of an element are considered invalid.

### BannedHTMLTags

**[Axe Blink rule description.](https://dequeuniversity.com/rules/axe/3.5/blink)**

**[Axe Marquee rule description.](https://dequeuniversity.com/rules/axe/3.5/marquee)**

The `blink` and `marquee` tags are disallowed from use. These elements can cause issues for users with cognitive disabilities.

### AriaRoles

**[Axe aria-roles rule description.](https://dequeuniversity.com/rules/axe/3.5/aria-roles)**

Catches invalid Aria role values. Typo's, non-standard and dynamic roles are not allowed.

Invalid roles can not be correctly interpreted by assistive technology.

## Roadmap
The idea is to implement as many rules as possible from the [Axe Linter](https://axe-linter.deque.com/docs/ruleset/) ruleset.
