<?php

namespace Treffynnon\CmdWrap\Types\CommandLine;

use Treffynnon\CmdWrap\Types\TypeAbstract;

class Argument extends TypeAbstract implements CommandLineInterface, ArgumentInterface
{
    const PREFIX = '--';
}
