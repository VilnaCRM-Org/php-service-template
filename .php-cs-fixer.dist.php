<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var');

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'phpdoc_align' => false,
        'yoda_style' => [
            'equal' => false,
            'identical' => false,
            'less_and_greater' => false
        ],
        'nullable_type_declaration' => ['syntax' => 'question_mark'],
        'class_definition' => [
            'multi_line_extends_each_single_line' => true,
            'single_line' => false,
            'single_item_single_line' => false
        ],
        'no_unused_imports' => true,
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'cast_spaces' => true,
        'binary_operator_spaces' => true,
        'declare_strict_types' => true,
    ])
    ->setFinder($finder);
