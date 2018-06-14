<?php

namespace Phals;

use Composer\Plugin\Capability\CommandProvider as CommandProviderCapability;
use Phals\Command\Create;

class CommandProvider implements CommandProviderCapability
{
    public function getCommands()
    {
        return [
            new Create
        ];
    }
}
