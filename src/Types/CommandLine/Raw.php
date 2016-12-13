<?php

namespace Treffynnon\CommandWrap\Types\CommandLine;

use Treffynnon\CommandWrap\Types\TypeAbstract;

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
