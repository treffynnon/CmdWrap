<?php

namespace Treffynnon\CmdWrap\Types\CommandLine;

use Treffynnon\CmdWrap\Types\TypeAbstract;

class Raw extends TypeAbstract implements CommandLineInterface, RawInterface
{
    public function getValue()
    {
        return $this->getRawValue();
    }

    public function getExtraValue()
    {
        return $this->getRawExtraValue();
    }
}
