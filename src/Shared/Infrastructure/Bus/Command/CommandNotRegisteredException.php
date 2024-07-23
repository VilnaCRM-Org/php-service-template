<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Command;

use App\Shared\Domain\Bus\Command\CommandInterface;

final class CommandNotRegisteredException extends \RuntimeException
{
    public function __construct(CommandInterface $command)
    {
        $commandClass = $command::class;

        parent::__construct(
            "The command <{$commandClass}> hasn't a command handler associated"
        );
    }
}
