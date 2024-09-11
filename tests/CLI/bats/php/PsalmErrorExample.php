<?php

declare(strict_types=1);

namespace App\Shared\Application\PsalmTest;

use App\Shared\Application\NonExistentTrait;

class PsalmErrorExample
{
    use NonExistentTrait {
        nonExistentMethod as aliasMethod;
    }
}
