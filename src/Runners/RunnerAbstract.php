<?php

namespace Treffynnon\CmdWrap\Runners;

abstract class RunnerAbstract
{
    protected $output = '';
    protected $status = '';
    protected $lastCommand = '';

    public function getLastCommand()
    {
        return $this->lastCommand;
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function __toString()
    {
        return $this->getOutput();
    }
}
