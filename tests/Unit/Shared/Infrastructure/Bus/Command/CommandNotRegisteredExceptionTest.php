<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Infrastructure\Bus\Command;

use App\Shared\Domain\Bus\Command\CommandInterface;
use App\Shared\Infrastructure\Bus\Command\CommandNotRegisteredException;
use App\Tests\Unit\UnitTestCase;

final class CommandNotRegisteredExceptionTest extends UnitTestCase
{
    public function testConstruct(): void
    {
        $command = $this->createMock(CommandInterface::class);
        $commandClass = $command::class;

        $exception = new CommandNotRegisteredException($command);

        $expectedMessage =
            "The command <{$commandClass}> hasn't a command handler associated";
        $this->assertEquals($expectedMessage, $exception->getMessage());
    }
}
