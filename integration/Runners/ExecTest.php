<?php

use Treffynnon\CmdWrap\Builder;
use Treffynnon\CmdWrap\Runners\Exec;

class ExecTest extends PHPUnit_Framework_TestCase
{
    public function testCanRunACommandWithExec()
    {
        $x = new Builder();
        $x->addCommand('date')
          ->addParameter('+%d-%m-%Y');
        $r = new Exec();
        $r->run($x);
        $this->assertSame("date '+%d-%m-%Y'", $r->getLastCommand());
        $this->assertSame(date('d-m-Y'), reset($r->getOutput()));
        $this->assertSame(0, $r->getStatus());
    }

    public function testCanRunACommandExecCallable()
    {
        $x = new Builder();
        $x->addCommand('date')
            ->addParameter('+%d-%m-%Y');
        $r = new Exec();
        $r->run($x, function ($line) {
            return str_replace(date('Y'), '', $line);
        });
        $this->assertSame("date '+%d-%m-%Y'", $r->getLastCommand());
        $this->assertSame(date('d-m-'), trim($r->getOutput()));
        $this->assertSame(0, $r->getStatus());
    }

    public function testFailedExecCommand()
    {
        $x = new Builder();
        $x->addCommand('dat1e')
            ->addParameter('+%d-%m-%Y');
        $r = new Exec();
        $r->run($x);
        $this->assertSame("dat1e '+%d-%m-%Y'", $r->getLastCommand());
        $this->assertSame(false, reset($r->getOutput()));
        $this->assertSame(127, $r->getStatus());
    }
}
