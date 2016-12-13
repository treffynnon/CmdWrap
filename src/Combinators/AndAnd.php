<?php

namespace Treffynnon\CommandWrap\Combinators;

use Treffynnon\CommandWrap\Types\RunnableInterface;

class AndAnd extends CombinatorAbstract implements CombinatorInterface, CombinableInterface, RunnableInterface
{
    const SEPARATOR = '&&';
}
