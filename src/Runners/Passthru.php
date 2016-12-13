<?php

namespace Treffynnon\CommandWrap\Runners;

use Treffynnon\CommandWrap\BuilderInterface;
use Treffynnon\CommandWrap\Types\RunnableInterface;

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

        $command = (string) $command->getCommandAssembler();
        passthru($command, $status);
        return $this->getResponseClass($command, $status, '');
    }
}
