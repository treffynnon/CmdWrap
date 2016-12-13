<?php

namespace Treffynnon\CommandWrap\Runners;

use Treffynnon\CommandWrap\Types\RunnableInterface;

class System extends RunnerAbstract implements RunnerInterface
{
    /**
     * @link http://php.net/system
     * @param RunnableInterface $command
     * @return string
     */
    public function run(RunnableInterface $command, callable $func = null)
    {
        $command = (string) $command->getCommandAssembler();
        $output = system($command, $status);
        if ($func) {
            $t = '';
            $x = preg_split("/\n/", $output);
            foreach ($x as $line) {
                $t .= call_user_func($func, $line);
            }
            $output = $t;
        }
        return $this->getResponseClass(
            $command,
            $status,
            $output
        );
    }
}
