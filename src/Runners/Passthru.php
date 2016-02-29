<?php

namespace Treffynnon\CmdWrap\Runners;

use Treffynnon\CmdWrap\BuilderInterface;
use Treffynnon\CmdWrap\Types\RunnableInterface;

class Passthru extends RunnerAbstract implements RunnerInterface
{
    /**
     * Passes through result of the command so no output is set
     * @link http://php.net/passthru
     * @param RunnableInterface $command
     */
    public function run(RunnableInterface $command, callable $func = null)
    {
        if ($func) {
            throw new \Exception('You cannot process passthru with a callable. Use another Runner instead.');
        }

        $this->lastCommand = (string) $command->getCommandAssembler();
        passthru($this->lastCommand, $this->status);
        $this->output = '';
    }
}
