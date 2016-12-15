<?php

use Treffynnon\CommandWrap\Builder;
use Treffynnon\CommandWrap\Runners\SymfonyProcess;

class SymfonyProcessTest extends PHPUnit_Framework_TestCase
{
    public function testCanRunACommandWithSymfonyProcess()
    {
        $x = new Builder();
        $x->addCommand('date')
          ->addParameter('+%d-%m-%Y');
        $runner = new SymfonyProcess();
        $r = $runner->run($x);
        $this->assertSame("date '+%d-%m-%Y'", $r->getCommand());
        $this->assertSame(date('d-m-Y'), trim($r->getOutput()));
        $this->assertSame(0, $r->getStatus());
    }

    public function testCanRunACommandWithSymfonyProcessCallable()
    {
        $x = new Builder();
        $x->addCommand('date')
            ->addParameter('+%d-%m-%Y');
        $runner = new SymfonyProcess();
        $r = $runner->run($x, function ($line) {
            return str_replace(date('Y'), '', $line);
        });
        $this->assertSame("date '+%d-%m-%Y'", $r->getCommand());
        $this->assertSame(date('d-m-'), trim($r->getOutput()));
        $this->assertSame(0, $r->getStatus());
    }

    public function testFailedSymfonyProcessCommand()
    {
        $x = new Builder();
        $x->addCommand('dat1e')
            ->addParameter('+%d-%m-%Y');
        $runner = new SymfonyProcess();
        $r = $runner->run($x);
        $this->assertSame("dat1e '+%d-%m-%Y'", $r->getCommand());
        $this->assertSame('', trim($r->getOutput()));
        $this->assertSame(127, $r->getStatus());
        $this->assertSame("sh: dat1e: command not found\n", $r->getError());
    }

    public function testRegressionCombinators()
    {
        $x = new Builder();
        $x->addCommand('echo')
          ->addEnvVar('ENV_VAR', 'test')
          ->addParameter('hello world');
        $x2 = new Builder();
        $x2->addEnvVar('ENV_VAR2', 'test2')
           ->addEnvVar('ENV_VAR3', 'test3')
           ->addCommand('grep "h"');
        $x3 = new \Treffynnon\CommandWrap\Combinators\Pipe(
            $x,
            $x2
        );
        
        $runner = new SymfonyProcess();
        $r = $runner->run($x3);
        $this->assertSame("echo 'hello world' | grep \"h\"", $r->getCommand());
        $this->assertSame('hello world', trim($r->getOutput()));

        $this->assertCount(3, $runner->getEnvVarArray($x3));
        foreach($runner->getEnvVarArray($x3) as $var) {
            $this->assertInstanceOf('\Treffynnon\CommandWrap\Types\CommandLine\EnvVar', $var);
            $this->assertSame($var->getValue() . '=' . $var->getExtraValue(), (string) $var);
        }
    }
}
