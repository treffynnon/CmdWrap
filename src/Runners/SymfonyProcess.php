<?php

namespace Treffynnon\CmdWrap\Runners;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Treffynnon\CmdWrap\Types\CommandLine as CL;
use Symfony\Component\Process\Process;
use Treffynnon\CmdWrap\Types\RunnableInterface;

class SymfonyProcess extends RunnerAbstract implements RunnerInterface
{
    /**
     * @link http://symfony.com/doc/current/components/process.html
     * @param RunnableInterface $command
     */
    public function run(RunnableInterface $command, callable $func = null)
    {
        $callable = $this->prepareSymfonyProcessCallable($func);
        $process = $this->runProcess($command, $callable);
        if (is_null($callable)) {
            $this->output = $process->getOutput();
        }
    }

    protected function runProcess(RunnableInterface $command, callable $func = null)
    {
        $this->lastCommand = $this->getCommandStringExcludingEnvVars($command);
        $process = new Process(
            $this->lastCommand,
            null,
            $this->getEnvVarArray($command)
        );
        $process->setTimeout(3600);
        try {
            $process->mustRun($func);
        } catch (ProcessFailedException $e) {
        }
        $this->status = $process->getExitCode();
        return $process;
    }

    public function getCommandStringExcludingEnvVars(RunnableInterface $command)
    {
        return (string) $command->getCommandAssembler()->getCommandString(
            function ($item) {
                return !($item instanceof CL\EnvVarInterface);
            }
        );
    }

    public function getEnvVarArray(RunnableInterface $command)
    {
        return $command->getCommandAssembler()->getCommandLine(
            function ($item) {
                return ($item instanceof CL\EnvVarInterface);
            }
        )->get();
    }

    public function prepareSymfonyProcessCallable(callable $func = null)
    {
        if ($func) {
            return function ($type, $buffer) use ($func) {
                if ($type !== Process::ERR) {
                    $this->output .= call_user_func($func, $buffer);
                }
            };
        }
    }
}
