<?php

namespace Treffynnon\CommandWrap\Types;

use Treffynnon\CommandWrap\Types\CommandLine\CommandLineInterface;
use Treffynnon\CommandWrap\Utils as U;

class CommandCollection implements CommandCollectionInterface
{
    protected $collection = [];

    public function __construct(CommandLineInterface ...$collection)
    {
        $this->set(...$collection);
    }

    public function push(CommandLineInterface $command)
    {
        $this->collection[] = $command;
    }

    public function get()
    {
        return $this->collection;
    }

    public function set(CommandLineInterface ...$collection)
    {
        $this->collection = $collection;
    }

    public function filter(callable $filter = null)
    {
        if ($filter) {
            return new static(...array_filter($this->get(), $filter));
        }
        return $this;
    }

    public function reduce(callable $map)
    {
        return array_reduce($this->get(), $map);
    }
    
    public function sort(callable $sort = null)
    {
        if ($sort) {
            return new static(...U\arraySort($this->get(), $sort));
        }
        return $this;
    }

    public function reverse()
    {
        return new static(...array_reverse($this->get()));
    }
}
