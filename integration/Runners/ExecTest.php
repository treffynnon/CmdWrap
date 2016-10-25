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
        $runner = new Exec();
        $r = $runner->run($x);
        $this->assertSame("date '+%d-%m-%Y'", $r->getCommand());
        $o = $r->getOutput();
        $this->assertSame(date('d-m-Y'), reset($o));
        $this->assertSame(0, $r->getStatus());
    }

    public function testCanRunACommandExecCallable()
    {
        $x = new Builder();
        $x->addCommand('date')
            ->addParameter('+%d-%m-%Y');
        $runner = new Exec();
        $r = $runner->run($x, function ($line) {
            return str_replace(date('Y'), '', $line);
        });
        $this->assertSame("date '+%d-%m-%Y'", $r->getCommand());
        $this->assertSame(date('d-m-'), trim($r->getOutput()));
        $this->assertSame(0, $r->getStatus());
    }

    public function testFailedExecCommand()
    {
        $x = new Builder();
        $x->addCommand('dat1e')
            ->addParameter('+%d-%m-%Y');
        $runner = new Exec();
        $r = $runner->run($x);
        $this->assertSame("dat1e '+%d-%m-%Y'", $r->getCommand());
        $o = $r->getOutput();
        $this->assertSame(false, reset($o));
        $this->assertSame(127, $r->getStatus());
    }
}
