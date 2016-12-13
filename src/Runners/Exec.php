<?php

namespace Treffynnon\CommandWrap\Runners;

use Treffynnon\CommandWrap\BuilderInterface;
use Treffynnon\CommandWrap\Types\RunnableInterface;

class Exec extends RunnerAbstract implements RunnerInterface
{
    /**
     * @link http://php.net/manual/en/function.exec.php
     * @param RunnableInterface $command
     * @return string
     */
    public function run(RunnableInterface $command, callable $func = null)
    {
        $command = (string) $command->getCommandAssembler();
        $return = exec($command, $output, $status);
        if ($func) {
            $t = '';
            foreach ($output as $line) {
                $t .= call_user_func($func, $line);
            }
            $output = $t;
        }
        return $this->getResponseClass($command, $status, $output);
    }
}
