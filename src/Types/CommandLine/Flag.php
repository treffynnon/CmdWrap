<?php

namespace Treffynnon\CommandWrap\Types\CommandLine;

use Treffynnon\CommandWrap\Types\TypeAbstract;

class Flag extends TypeAbstract implements CommandLineInterface, FlagInterface
{
    const PREFIX = '-';
}
