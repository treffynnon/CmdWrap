<?php

namespace Treffynnon\CommandWrap\Types;

use Treffynnon\CommandWrap\Types\CommandLine\CommandLineInterface;

interface CommandCollectionInterface
{
    public function __construct(CommandLineInterface ...$collection);
    public function push(CommandLineInterface $command);
    public function get();
    public function set(CommandLineInterface ...$collection);
    public function filter(callable $filter = null);
    public function reduce(callable $map);
    public function sort(callable $sort = null);
    public function reverse();
}
