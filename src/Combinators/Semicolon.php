<?php

namespace Treffynnon\CmdWrap\Combinators;

use Treffynnon\CmdWrap\Types\RunnableInterface;

class Semicolon extends CombinatorAbstract implements CombinatorInterface, CombinableInterface, RunnableInterface
{
    const SEPARATOR = ';';
}
