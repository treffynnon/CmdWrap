<?php

namespace Treffynnon\CommandWrap\Assemblers;

use Treffynnon\CommandWrap\Types\CommandCollectionInterface;
use Treffynnon\CommandWrap\Utils as U;

class ChronoAssembler extends AssemblerAbstract
{
    public function getCommandString(callable $filter = null)
    {
        return trim($this->getCommandLine($filter)->reduce(function ($carry, $item) {
            return $carry .= U\padOrNone($item->getString());
        }));
    }
}
