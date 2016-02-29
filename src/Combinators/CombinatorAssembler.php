<?php

namespace Treffynnon\CmdWrap\Combinators;

use Treffynnon\CmdWrap\Assemblers\AssemblerInterface;
use Treffynnon\CmdWrap\Types\CommandCollectionInterface;

class CombinatorAssembler implements AssemblerInterface
{
    protected $separator = '';
    protected $items = [];

    public function get()
    {
        return $this->items;
    }

    public function set(CombinableInterface ...$items)
    {
        $this->items = $items;
    }

    public function setSeperator($separator)
    {
        $this->separator = $separator;
    }

    public function getCommandLine(callable $filter = null)
    {
        return array_map(function ($item) use ($filter) {
            return $item->getCommandAssembler()->getCommandLine($filter);
        }, $this->get());
    }

    public function getCommandString(callable $filter = null)
    {
        return implode(" {$this->separator} ", array_map(function ($item) use ($filter) {
            return $item->getCommandAssembler()->getCommandString($filter);
        }, $this->get()));
    }

    public function __toString()
    {
        return $this->getCommandString();
    }

    public function setCommandLine(CommandCollectionInterface $commandLine)
    {
        // do nothing
    }
}
