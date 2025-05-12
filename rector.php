<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use Rector\Php81\Rector\Property\ReadOnlyPropertyRector;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromAssignsRector;

return RectorConfig::configure()
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
        true, //import names
        true, // import doc block names
        true, // import short classes
        true // remove unused imports
    )
    ->withComposerBased(
        true, // twig
        true, // doctrine
        true, // phpunit
        true // symfony
    )
    ->withSkip([
        ReadOnlyPropertyRector::class,
        RenamePropertyToMatchTypeRector::class,
    ])
    ->withSymfonyContainerXml(
        __DIR__ . '/var/cache/dev/Shared_Infrastructure_KernelDevDebugContainer.xml'
    );
