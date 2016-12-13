<?php

namespace Treffynnon\CommandWrap\Combinators;

use Treffynnon\CommandWrap\Types\RunnableInterface;

class Semicolon extends CombinatorAbstract implements CombinatorInterface, CombinableInterface, RunnableInterface
{
    const SEPARATOR = ';';
}
