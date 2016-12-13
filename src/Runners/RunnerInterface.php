<?php

namespace Treffynnon\CommandWrap\Runners;

use Treffynnon\CommandWrap\Types\RunnableInterface;

interface RunnerInterface
{
    public function run(RunnableInterface $command, callable $func = null);
}
