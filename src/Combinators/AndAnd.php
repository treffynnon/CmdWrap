<?php

namespace Treffynnon\CmdWrap\Combinators;

use Treffynnon\CmdWrap\Types\RunnableInterface;

class AndAnd extends CombinatorAbstract implements CombinatorInterface, CombinableInterface, RunnableInterface
{
    const SEPARATOR = '&&';
}
