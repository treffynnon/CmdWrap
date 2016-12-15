<?php

namespace Treffynnon\CommandWrap\Runners;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Treffynnon\CommandWrap\Types\CommandLine as CL;
use Symfony\Component\Process\Process;
use Treffynnon\CommandWrap\Types\RunnableInterface;

class SymfonyProcess extends RunnerAbstract implements RunnerInterface
{
    protected $command = '';
    protected $output = '';

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
        return $this->getResponseClass(
            $this->command,
            $process->getExitCode(),
            $this->output,
            $process->getErrorOutput()
        );
    }

    protected function runProcess(RunnableInterface $command, callable $func = null)
    {
        $this->command = $this->getCommandStringExcludingEnvVars($command);
        $process = new Process(
            $this->command,
            null,
            $this->getEnvVarArray($command)
        );
        $process->setTimeout(3600);
        $process->run($func);
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
        $env = $command->getCommandAssembler()->getCommandLine(
            function ($item) {
                return ($item instanceof CL\EnvVarInterface);
            }
        );
        if (is_object($env)) {
            return $env->get();
        } elseif (is_array($env)) {
            return array_reduce($env, function ($carry, $item) {
                return array_merge($carry, $item->get());
            }, []);
        }
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
