<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php80\Rector\ClassMethod\AddParamBasedOnParentClassMethodRector;
use Rector\Php81\Rector\ClassMethod\NewInInitializerRector;
use Rector\Php81\Rector\Property\ReadOnlyPropertyRector;
use Rector\Php83\Rector\ClassConst\AddTypeToConstRector;
use Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector;
use Rector\Php83\Rector\FuncCall\RemoveGetClassGetParentClassNoArgsRector;
use Rector\Php84\Rector\MethodCall\NewMethodCallWithoutParenthesesRector;
use Rector\Php84\Rector\Param\ExplicitNullableParamTypeRector;
use Rector\Symfony\Symfony28\Rector\MethodCall\GetToConstructorInjectionRector;
use Rector\Symfony\Symfony30\Rector\MethodCall\StringFormTypeToClassRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use Rector\TypeDeclaration\Rector\FunctionLike\AddClosureParamTypeFromIterableMethodCallRector;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromAssignsRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __DIR__ . '/bin',
        __DIR__ . '/config',
    ])
    ->withRules([
        AddOverrideAttributeToOverriddenMethodsRector::class,
        AddParamTypeDeclarationRector::class,
        AddReturnTypeDeclarationRector::class,
        AddTypeToConstRector::class,
        ExplicitNullableParamTypeRector::class,
        GetToConstructorInjectionRector::class,
        NewMethodCallWithoutParenthesesRector::class,
        RemoveGetClassGetParentClassNoArgsRector::class,
        StringFormTypeToClassRector::class,
        AddParamBasedOnParentClassMethodRector::class,
        AddClosureParamTypeFromIterableMethodCallRector::class,
        NewInInitializerRector::class,
        ReadOnlyPropertyRector::class,
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
    ->withoutParallel();
