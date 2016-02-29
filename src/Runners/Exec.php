<?php

namespace Treffynnon\CmdWrap\Runners;

use Treffynnon\CmdWrap\BuilderInterface;
use Treffynnon\CmdWrap\Types\RunnableInterface;

class Exec extends RunnerAbstract implements RunnerInterface
{
    /**
     * @link http://php.net/manual/en/function.exec.php
     * @param RunnableInterface $command
     * @return string
     */
    public function run(RunnableInterface $command, callable $func = null)
    {
        $this->lastCommand = (string) $command->getCommandAssembler();
        $return = exec($this->lastCommand, $this->output, $this->status);
        if ($func) {
            $t = '';
            foreach ($this->output as $line) {
                $t .= call_user_func($func, $line);
            }
            $this->output = $t;
        }
        return $return;
    }
}
