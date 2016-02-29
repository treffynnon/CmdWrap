<?php

namespace Treffynnon\CmdWrap\Assemblers;

use Treffynnon\CmdWrap\Types\CommandCollectionInterface;
use Treffynnon\CmdWrap\Utils as U;

class ChronoAssembler extends AssemblerAbstract
{
    public function getCommandString(callable $filter = null)
    {
        return trim($this->getCommandLine($filter)->reduce(function ($carry, $item) {
            return $carry .= U\padOrNone($item->getString());
        }));
    }
}
