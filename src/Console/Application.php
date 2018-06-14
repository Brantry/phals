<?php
/**
 * Created by PhpStorm.
 * User: denzyl
 * Date: 4/6/17
 * Time: 9:13 PM
 */

namespace Phals\Console;


use Phals\Command\Create;

class Application
{
    public function __construct()
    {
        $console = new \Symfony\Component\Console\Application();
        $console->add(new Create());
        $console->run();
    }
}