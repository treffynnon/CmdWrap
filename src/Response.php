<?php

namespace Treffynnon\CmdWrap;

class Response implements ResponseInterface
{
    private $immutable = false;
    private $command = '';
    private $status;
    private $output = '';
    private $error = '';

    public function set($command, $status, $output, $error = '')
    {
        if (false === $this->immutable) {
            $this->immutable = true;
            $this->command = $command;
            $this->status = (int) $status;
            $this->output = $output;
            $this->error = $error;
            return $this;
        }
        throw new \Exception('This object is immutable and cannot be changed.');
    }

    public function getCommand()
    {
        return $this->command;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function getOutputAsArray()
    {
        return explode("\n", $this->getOutput());
    }

    public function getError()
    {
        return $this->error;
    }

    public function getErrorAsArray()
    {
        return explode("\n", $this->getError());
    }

    public function wasSuccess()
    {
        return $this->getStatus() === 0;
    }

    public function __toString()
    {
        return $this->wasSuccess
          ? (string) $this->getOutput()
          : (string) $this->getError();
    }
}
