<?php

namespace Treffynnon\CommandWrap\Types\CommandLine;

use Treffynnon\CommandWrap\Utils as U;
use Treffynnon\CommandWrap\Types\TypeAbstract;

class Parameter extends TypeAbstract implements CommandLineInterface, ParameterInterface
{
    public function getValue()
    {
        return U\escapeArgument($this->getRawValue());
    }
}
