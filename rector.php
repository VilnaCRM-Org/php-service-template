<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use Rector\Php81\Rector\Property\ReadOnlyPropertyRector;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromAssignsRector;
use Symfony\Component\DependencyInjection\Exception\ContainerNotFoundException;

$isCi = getenv('RECTOR_MODE') === 'ci';

$rectorConfig = RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __DIR__ . '/bin',
        __DIR__ . '/config',
        __DIR__ . '/templates',
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
    $containerXmlPath =
        __DIR__ .
        '/var/cache/dev/App_Shared_KernelDevDebugContainer.xml';
    if (!file_exists($containerXmlPath)) {
        throw new ContainerNotFoundException(sprintf(
            'Symfony container XML not found at "%s".
            Please warm up the dev cache: bin/console cache:clear --env=dev.',
            $containerXmlPath
        ));
    }
    $rectorConfig
        ->withSymfonyContainerXml($containerXmlPath)
        ->withParallel();
}

return $rectorConfig;
