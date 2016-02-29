<?php

namespace Treffynnon\CmdWrap\Types\CommandLine;

use Treffynnon\CmdWrap\Utils as U;
use Treffynnon\CmdWrap\Types\TypeAbstract;

class Parameter extends TypeAbstract implements CommandLineInterface, ParameterInterface
{
    public function getValue()
    {
        return U\escapeArgument($this->getRawValue());
    }
}
