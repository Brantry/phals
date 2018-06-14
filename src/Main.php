<?php


namespace Phals;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\Capable;
use Composer\Plugin\PluginInterface;

class Main implements PluginInterface, Capable
{
    public function activate(Composer $composer, IOInterface $iointerface)
    {

    }

    public function getCapabilities()
    {
        return array(
            \Composer\Plugin\Capability\CommandProvider::class => CommandProvider::class,
        );
    }


}