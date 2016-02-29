<?php

namespace Treffynnon\CmdWrap\Types\CommandLine;

use Treffynnon\CmdWrap\Types\TypeAbstract;

class Flag extends TypeAbstract implements CommandLineInterface, FlagInterface
{
    const PREFIX = '-';
}
