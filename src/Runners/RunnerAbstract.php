<?php

namespace Treffynnon\CmdWrap\Runners;

abstract class RunnerAbstract
{
    protected $output = '';
    protected $status = '';
    protected $lastCommand = '';
    protected $responseClass;

    public function __construct(\Treffynnon\CmdWrap\ResponseInterface $class = null)
    {
        $this->setResponseClass(new \Treffynnon\CmdWrap\Response);
        if ($class) {
            $this->setResponseClass($class);
        }
    }

    public function setResponseClass(\Treffynnon\CmdWrap\ResponseInterface $class)
    {
        $this->responseClass = $class;
    }

    public function getResponseClass($command, $status, $output, $error = '')
    {
        $response = clone $this->responseClass;
        $response->set($command, $status, $output, $error);
        return $response;
    }
}
