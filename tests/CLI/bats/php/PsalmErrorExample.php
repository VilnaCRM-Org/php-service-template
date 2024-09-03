<?php

declare(strict_types=1);

namespace App\Shared\Application\PsalmTest;

class PsalmErrorExample
{
    public function exampleMethod(): void
    {
        $undefinedVariable;
        $number = "not a number";
        return $number;
    }
}
