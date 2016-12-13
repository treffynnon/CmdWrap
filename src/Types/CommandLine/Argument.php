<?php

namespace Treffynnon\CommandWrap\Types\CommandLine;

use Treffynnon\CommandWrap\Types\TypeAbstract;

class Argument extends TypeAbstract implements CommandLineInterface, ArgumentInterface
{
    const PREFIX = '--';
}
