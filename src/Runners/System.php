<?php

namespace Treffynnon\CmdWrap\Runners;

use Treffynnon\CmdWrap\Types\RunnableInterface;

class System extends RunnerAbstract implements RunnerInterface
{
    /**
     * @link http://php.net/system
     * @param RunnableInterface $command
     * @return string
     */
    public function run(RunnableInterface $command, callable $func = null)
    {
        $this->lastCommand = (string) $command->getCommandAssembler();
        $this->output = system($this->lastCommand, $this->status);
        if ($func) {
            $t = '';
            $x = preg_split("/\n/", $this->output);
            foreach ($x as $line) {
                $t .= call_user_func($func, $line);
            }
            $this->output = $t;
        }
        return $this->output;
    }
}
