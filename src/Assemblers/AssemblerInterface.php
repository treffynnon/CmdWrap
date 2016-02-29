<?php

namespace Treffynnon\CmdWrap\Assemblers;

use Treffynnon\CmdWrap\Types\CommandCollectionInterface;

interface AssemblerInterface
{
    public function setCommandLine(CommandCollectionInterface $commandLine);
    public function getCommandLine(callable $filter = null);
    public function getCommandString(callable $filter = null);
    public function __toString();
}
