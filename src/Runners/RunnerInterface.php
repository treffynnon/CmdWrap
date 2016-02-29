<?php

namespace Treffynnon\CmdWrap\Runners;

use Treffynnon\CmdWrap\Types\RunnableInterface;

interface RunnerInterface
{
    public function run(RunnableInterface $command, callable $func = null);
    public function getLastCommand();
    public function getOutput();
    public function getStatus();
}
