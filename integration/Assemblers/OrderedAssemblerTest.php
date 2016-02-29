<?php

use Treffynnon\CmdWrap\Builder;
use Treffynnon\CmdWrap\Assemblers\OrderedAssembler;

class OrderedAssemblerTest extends PHPUnit_Framework_TestCase
{
    public function testCanOrderAComplexBuilder()
    {
        $a = new OrderedAssembler();
        $x = new Builder($a);
        $x->addEnvVar('JAVA_BIN', '/usr/bin/java')
            ->addFlag('t', 'xml')
            ->addCommand('src/')
            ->addArgument('verbose')
            ->addCommand('foo')
            ->addArgument('results-log', '/tmp/results.log')
            ->addEnvVar('TMP_DIR', '/tmp')
            ->addFlag('f')
            ->addCommand('hint&&hint');

        $this->assertSame(
            "JAVA_BIN='/usr/bin/java' TMP_DIR='/tmp' hint\&\&hint foo src/ -t='xml' -f --verbose --results-log='/tmp/results.log'",
            (string) $x
        );
    }
}
