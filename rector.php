<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use Rector\Php81\Rector\Property\ReadOnlyPropertyRector;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromAssignsRector;

$isCi = getenv('RECTOR_MODE') === 'ci';

$rectorConfig = RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __DIR__ . '/bin',
        __DIR__ . '/config',
    ])
    ->withRules([
        TypedPropertyFromAssignsRector::class,
    ])
    ->withPhpSets()
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        privatization: true,
        naming: true,
        instanceOf: true,
        strictBooleans: true,
        phpunitCodeQuality: true,
        doctrineCodeQuality: true,
        symfonyCodeQuality: true,
        symfonyConfigs: true,
    )
    ->withImportNames(
        removeUnusedImports: true
    )
    ->withComposerBased(
        twig: true,
        doctrine: true,
        phpunit: true,
        symfony: true
    )
    ->withSkip([
        ReadOnlyPropertyRector::class,
        RenamePropertyToMatchTypeRector::class,
    ]);

if ($isCi) {
    $rectorConfig
        ->withoutParallel();
} else {
    $rectorConfig
        ->withSymfonyContainerXml(
            __DIR__ .
            '/var/cache/dev/Shared_Infrastructure_KernelDevDebugContainer.xml'
        )
        ->withParallel();
}

return $rectorConfig;
