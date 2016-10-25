<?php

namespace Treffynnon\CmdWrap;

interface ResponseInterface
{
    public function set($command, $status, $output, $error);
    public function getCommand();
    public function getStatus();
    public function getOutput();
    public function getError();
    public function wasSuccess();
}
