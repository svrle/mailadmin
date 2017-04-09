<?php
namespace AppBundle\Process;

use AppBundle\Entity\PostfixInstance;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Created by PhpStorm.
 * User: svrle
 * Date: 4/9/17
 * Time: 10:43 AM
 */
class PostfixProcess extends ProcessBuilder
{
    public function __construct(PostfixInstance $postfixInstance)
    {
        $this->createStructure($postfixInstance);
    }

    public function createStructure(PostfixInstance $postfix)
    {
        $processBuilder = (new ProcessBuilder())
            ->setPrefix('sudo')
            ->add('/usr/bin/cp')
            ->add('-R')
            ->add('/etc/postfix')
            ->add('/etc/postfix-' . $postfix->getName());

        $process = $processBuilder->getProcess();
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();
        die;
    }
}